<?php

namespace Hosseinhunta\PhpTelegramBotApi\Updates;

use AllowDynamicProperties;
use Exception;
use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Core\Exception\ValidationException;
use Hosseinhunta\PhpTelegramBotApi\Core\handler\callbackQueryHandler;
use Hosseinhunta\PhpTelegramBotApi\Core\handler\CommandHandler;
use Hosseinhunta\PhpTelegramBotApi\Core\handler\EventHandler;
use Hosseinhunta\PhpTelegramBotApi\Core\Storage\UpdateStorageInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

#[AllowDynamicProperties]
class UpdateHandler
{
    private Bot $bot;
    private LoggerInterface $logger;
    private UpdateStorageInterface $storage;
    private string $mode;
    private $updateCallback;
    private ?CommandHandler $commandHandler = null;
    private ?EventHandler $eventHandler = null;
    private ?CallbackQueryHandler $callbackQueryHandler = null;
    private ?int $lastUpdateId = null;
    private bool $shouldStopPolling = false;
    private float $minProcessingInterval;
    private int $maxConcurrentUpdates;
    private bool $debugMode;
    private ?string $secretToken;
    private float $lastUpdateTime;
    private bool $restrictToTelegramApi;

    /**
     * Constructor for UpdateHandler.
     *
     * @param Bot $bot Telegram Bot instance
     * @param string $mode Execution mode ('webhook' or 'polling')
     * @param LoggerInterface $logger Logger for debugging and errors
     * @param UpdateStorageInterface $storage Storage for processed updates
     * @param float $minProcessingInterval Minimum interval between updates (seconds)
     * @param int $maxConcurrentUpdates Maximum concurrent updates allowed
     * @param bool $debugMode Enable debug logging
     * @param ?string $secretToken Secret token for webhook validation
     * @param bool $restrictToTelegramApi Restrict updates to Telegram API IPs
     */
    public function __construct(
        Bot $bot,
        string $mode,
        LoggerInterface $logger,
        UpdateStorageInterface $storage,
        float $minProcessingInterval = 0.1,
        int $maxConcurrentUpdates = 50,
        bool $debugMode = false,
        ?string $secretToken = null,
        bool $restrictToTelegramApi = true
    ) {
        if (!in_array($mode, ['webhook', 'polling'])) {
            throw new InvalidArgumentException("Execution mode must be either 'webhook' or 'polling'.");
        }

        $this->bot = $bot;
        $this->logger = $logger;
        $this->storage = $storage;
        $this->mode = $mode;
        $this->minProcessingInterval = max(0.01, min($minProcessingInterval, 1));
        $this->maxConcurrentUpdates = max(1, $maxConcurrentUpdates);
        $this->debugMode = $debugMode;
        $this->secretToken = $secretToken;
        $this->restrictToTelegramApi = $restrictToTelegramApi;
        $this->lastUpdateTime = microtime(true);
    }

    public function setUpdateCallback(callable $callback): self
    {
        $this->updateCallback = $callback;
        return $this;
    }

    public function setCommandHandler(CommandHandler $handler): self
    {
        $this->commandHandler = $handler;
        return $this;
    }

    public function setEventHandler(EventHandler $handler): self
    {
        $this->eventHandler = $handler;
        return $this;
    }

    public function setCallbackQueryHandler(CallbackQueryHandler $handler): self
    {
        $this->callbackQueryHandler = $handler;
        return $this;
    }

    public function handleUpdates(array $options = []): void
    {
        if ($this->mode === 'webhook') {
            $this->handleWebhook();
        } else {
            $this->handlePolling($options);
        }
    }

    private function handleWebhook(): void
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->sendResponse(405, ['ok' => false, 'error' => 'Method Not Allowed']);
                return;
            }

            if ($this->restrictToTelegramApi && !$this->isTelegramIp($_SERVER['REMOTE_ADDR'] ?? '')) {
                $this->logger->warning("IP not allowed", ['ip' => $_SERVER['REMOTE_ADDR']]);
                $this->sendResponse(403, ['ok' => false, 'error' => 'Forbidden']);
                return;
            }

            if ($this->secretToken &&
                (!isset($_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN']) ||
                    $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] !== $this->secretToken)) {
                $this->sendResponse(403, ['ok' => false, 'error' => 'Invalid token']);
                return;
            }

            $input = file_get_contents('php://input');
            if (empty($input)) {
                $this->sendResponse(400, ['ok' => false, 'error' => 'Empty input']);
                return;
            }

            $updateData = json_decode($input, true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($updateData['update_id'])) {
                $this->sendResponse(400, ['ok' => false, 'error' => 'Invalid update data']);
                return;
            }

            $update = new TelegramUpdate($updateData);
            $this->processUpdate($update);

            $this->sendResponse(200, ['ok' => true]);

        } catch (Exception $e) {
            $this->logger->error("Webhook error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->sendResponse(500, ['ok' => false, 'error' => 'Internal server error']);
        }
    }

    private function sendResponse(int $statusCode, array $data): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function processUpdate(TelegramUpdate $update): void
    {
        $updateId = $update->getUpdateId();
        $updateIdStr = (string)$updateId;

        $this->logger->debug("Processing update", ['update_id' => $updateId, 'data' => $update->getRawData()]);

        if ($this->storage->has($updateIdStr)) {
            $this->logger->debug("Skipping duplicate update", ['update_id' => $updateId]);
            return;
        }

        $now = microtime(true);
        if ($now - $this->lastUpdateTime < $this->minProcessingInterval) {
            usleep((int)(($this->minProcessingInterval - ($now - $this->lastUpdateTime)) * 1000000));
        }
        $this->lastUpdateTime = $now;

        try {
            $this->storage->markAsProcessed($updateIdStr);

            if ($this->updateCallback) {
                $this->logger->debug("Executing update callback", ['update_id' => $updateId]);
                call_user_func($this->updateCallback, $update, $this->bot);
            }

            $handled = false;


            if ($this->callbackQueryHandler && $update->getCallbackQuery()) {
                $this->logger->debug("Handling callback query", ['update_id' => $updateId]);
                $handled = $this->callbackQueryHandler->handle($update, $this->bot);
            }


            if ($update->getMessage()) {
                // ابتدا command‌ها
                if ($this->commandHandler) {
                    $messageText = $update->getMessage()['text'] ?? '';
                    if (!empty($messageText) && str_starts_with($messageText, '/')) {
                        $this->logger->debug("Handling command", ['update_id' => $updateId, 'text' => $messageText]);
                        $handled = $this->commandHandler->handle($update, $this->bot);
                    }
                }


                if ($this->eventHandler && !$handled) {
                    $this->logger->debug("Handling event", ['update_id' => $updateId]);
                    $handled = $this->eventHandler->handle($update, $this->bot);
                }
            }

            if (!$handled) {
                $this->logger->warning("No handler processed the update", ['update_id' => $updateId]);
            }

            $this->logger->info("Update processed", [
                'update_id' => $updateId,
                'handled' => $handled
            ]);
        } catch (Exception $e) {
            $this->logger->error("Error processing update", [
                'update_id' => $updateId,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function handlePolling(array $options): void
    {
        $this->logger->info("Starting polling...");
        $maxRetries = 10;
        $retryCount = 0;
        $baseDelay = 0.1;

        while ($retryCount < $maxRetries && !$this->shouldStopPolling) {
            try {
                $params = array_merge(['offset' => $this->lastUpdateId ? $this->lastUpdateId + 1 : null], $options);
                $updates = $this->bot->getUpdates($params);
                $retryCount = 0; // Reset retry count on success

                if (empty($updates)) {
                    $this->logger->debug("No updates received in this cycle");
                    usleep((int)($baseDelay * 1000000));
                    $baseDelay = min($baseDelay + 0.2, 1.0); // افزایش متعادل‌تر
                    continue;
                }

                foreach ($updates as $update) {
                    $this->lastUpdateId = $update->getUpdateId();
                    $this->processUpdate($update);
                }
                $baseDelay = 0.1;
            } catch (Exception $e) {
                $this->logger->error("Polling error", [
                    'error' => $e->getMessage(),
                    'retry' => $retryCount + 1
                ]);
                if (++$retryCount >= $maxRetries) {
                    $this->logger->critical("Maximum polling retries reached, stopping");
                    break;
                }
                $delay = min($retryCount * 0.5, 5.0); // تأخیر متعادل‌تر
                sleep($delay);
            }
        }
    }

    public function stopPolling(): void
    {
        $this->shouldStopPolling = true;
        $this->logger->info("Polling stopped");
    }

    private function isTelegramIp(string $ip): bool
    {
        $telegramIpRanges = [
            "91.108.4.0/22", "91.108.8.0/22", "91.108.12.0/22",
            "91.108.16.0/22", "91.108.20.0/22", "91.108.56.0/22",
            "91.105.192.0/23", "149.154.160.0/20", "185.76.151.0/24"
        ];

        foreach ($telegramIpRanges as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }
        return false;
    }

    private function ipInRange(string $ip, string $range): bool
    {
        [$subnet, $bits] = explode('/', $range);
        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);

        if ($ipLong === false || $subnetLong === false) {
            return false;
        }

        $mask = -1 << (32 - (int)$bits);
        return ($ipLong & $mask) === ($subnetLong & $mask);
    }
}