<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core\handler;

use Exception;
use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Updates\TelegramUpdate;
use Psr\Log\LoggerInterface;

class callbackQueryHandler
{
    protected array $callbacks = [];
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setCallback(string $callbackData, callable $handler): self
    {
        $this->callbacks[trim($callbackData)] = $handler;
        $this->logger->debug('Set callback handler', ['callback_data' => $callbackData]);
        return $this;
    }

    public function handle(TelegramUpdate $update, Bot $bot): bool
    {
        $callbackQuery = $update->getCallbackQuery();
        $callbackData = trim($update->getField('callback_query.data', ''));

        if (!$callbackQuery || empty($callbackData)) {
            return false;
        }

        if (isset($this->callbacks[$callbackData])) {
            $this->logger->info("Processing callback query", ['callback_data' => $callbackData]);
            try {
                call_user_func($this->callbacks[$callbackData], $update, $bot); // Pass $update, not $callbackQuery
                $bot->request('answerCallbackQuery', [
                    'callback_query_id' => $update->getField('callback_query.id')
                ]);
                return true;
            } catch (Exception $e) {
                $this->logger->error("Error executing callback handler", [
                    'callback_data' => $callbackData,
                    'error' => $e->getMessage(),
                    'stack_trace' => $e->getTraceAsString()
                ]);
                throw $e; // Propagate to UpdateHandler
            }
        }

        $this->logger->debug("No handler found for callback query", ['callback_data' => $callbackData]);
        return false;
    }
}