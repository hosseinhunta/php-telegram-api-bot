<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core\handler;

use Exception;
use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Updates\TelegramUpdate;
use Psr\Log\LoggerInterface;

class commandHandler
{
    protected array $commands = [];
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setCommand(string $command, callable $handler): self
    {
        $command = strtolower(ltrim($command, '/')); // Normalize command
        $this->commands[$command] = $handler;
        $this->logger->debug('Set command', ['command' => $command]);
        return $this;
    }

    public function handle(TelegramUpdate $update, Bot $bot): bool
    {
        $message = $update->getMessage();
        $text = $update->getField('message.text', '');

        if (!$message || !str_starts_with(trim($text), '/')) {
            return false;
        }

        $commandParts = explode(' ', trim($text), 2);
        $commandName = strtolower(ltrim($commandParts[0], '/')); // Case-insensitive
        $params = $commandParts[1] ?? '';

        if (isset($this->commands[$commandName])) {
            $this->logger->info("Processing command", ['command' => $commandName]);
            try {
                call_user_func($this->commands[$commandName], $update, $bot, $params); // Pass $update instead of $message
                return true;
            } catch (Exception $e) {
                $this->logger->error("Error executing command", [
                    'command' => $commandName,
                    'error' => $e->getMessage(),
                    'stack_trace' => $e->getTraceAsString()
                ]);
                throw $e; // Propagate to UpdateHandler
            }
        }
        return false;
    }
}