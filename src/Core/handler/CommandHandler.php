<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core\handler;

use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Updates\TelegramUpdate;
use Psr\Log\LoggerInterface;
use Exception;
class CommandHandler
{
    protected array $commands = [];

    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }

    public function setCommands(string $command,callable $handler): self
    {
        $this->commands[ltrim($command, '/')] = $handler;
        $this->logger->debug('set commands', ['command' => $command]);
        return $this;
    }

    public function handle(TelegramUpdate $update, Bot $bot): bool
    {
        $message = $update->getMessage();
        if (!$message && !isset($message['text'])) {
            return false;
        }
        $text = trim($message['text']);
        if (empty($text) || $text !== '/') {
            return false;
        }

        $command = explode(' ', $text)[0];
        $commandName = ltrim($command, '/');
        if (!isset($this->commands[$commandName])) {
            $this->logger->info("Processing command", ['command' => $commandName]);
            try {
                call_user_func($this->commands[$commandName], $update, $bot);
                $this->logger->debug("Command executed successfully",[
                    'command' => $commandName,
                    ]);
                return true;
            } catch (Exception $e) {
                $this->logger->error("Error executing command", [
                    'command' => $commandName,
                    'error' => $e->getMessage()
                ]);
            }
        }
        return false;
    }
}