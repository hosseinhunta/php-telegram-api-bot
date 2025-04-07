<?php

namespace Hosseinhunta\PhpTelegramBotApi\Updates;

use GuzzleHttp\Exception\GuzzleException;
use Hosseinhunta\PhpTelegramBotApi\Bot;
use Psr\Log\LoggerInterface;

class UpdateHandler
{
    /** @var Bot Instance of the Bot class */
    protected Bot $bot;

    /** @var LoggerInterface Logger instance */
    protected LoggerInterface $logger;

    /** @var string Update mode ('webhook' or 'polling') */
    protected string $mode;

    /** @var callable|null Callback to process updates */
    protected $updateCallback;

    /** @var int|null Last update ID for polling */
    protected ?int $lastUpdateId = null;

    public function __construct(Bot $bot, string $mode, LoggerInterface $logger)
    {
        if (!in_array($mode, ['webhook', 'polling'])) {
            throw new \InvalidArgumentException("Update mode must be 'webhook' or 'polling'.");
        }

        $this->bot = $bot;
        $this->mode = $mode;
        $this->logger = $logger;
    }

    public function setUpdateCallback(callable $callback): self
    {
        $this->updateCallback = $callback;
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

    protected function handleWebhook(): void
    {
        $update = json_decode(file_get_contents('php://input'), true);

        if (!$update) {
            $this->logger->warning("No update received in webhook");
            http_response_code(400);
            exit;
        }

        $this->logger->info("Received update via webhook", ['update' => $update]);
        $this->processUpdate($update);

        http_response_code(200);
        echo json_encode(['ok' => true]);
    }

    protected function handlePolling(array $options): void
    {
        $this->logger->info("Starting polling...");

        while (true) {
            try {
                $params = array_merge(['offset' => $this->lastUpdateId ? $this->lastUpdateId + 1 : null], $options);
                $updates = $this->bot->getUpdates($params);

                if (!empty($updates)) {
                    foreach ($updates as $update) {
                        $updateData = $update->getRawData(); // دریافت داده خام
                        $this->lastUpdateId = $update->getUpdateId(); // استفاده از متد شیء
                        $this->logger->info("Received update via polling", ['update' => $updateData]);
                        $this->processUpdate($updateData); // ارسال داده خام به processUpdate
                    }
                }
            } catch (\Exception $e) {
                $this->logger->error("Error in polling: " . $e->getMessage());
            }

            sleep(1); // Prevent excessive server load
        }
    }

    protected function processUpdate(array $update): void
    {
        if ($this->updateCallback) {
            $this->logger->debug("Calling update callback", ['update' => $update]);
            try {
                call_user_func($this->updateCallback, $update, $this->bot);
                $this->logger->debug("Update callback executed successfully");
            } catch (\Exception $e) {
                $this->logger->error("Error processing update: " . $e->getMessage(), ['update' => $update]);
            }
        } else {
            $this->logger->warning("No update callback defined", ['update' => $update]);
        }
    }
}