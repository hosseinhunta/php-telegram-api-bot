<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core\handler;

use Exception;
use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Updates\TelegramUpdate;
use Psr\Log\LoggerInterface;

class eventHandler
{
    protected array $events = [];
    protected LoggerInterface $logger;
    protected array $adminIDs;

    public function __construct(LoggerInterface $logger, array $adminIDs = [])
    {
        $this->logger = $logger;
        $this->adminIDs = $adminIDs;
    }

    public function setEvent(string $event, callable $handler, array $conditions = []): self
    {
        $this->events[$event] = ['handler' => $handler, 'conditions' => $conditions];
        $this->logger->debug('Set event', ['event' => $event]);
        return $this;
    }

    public function handle(TelegramUpdate $update, Bot $bot): bool
    {
        $message = $update->getMessage();
        if (!$message) {
            $this->logger->debug("No message found in update", ['update_id' => $update->getUpdateId()]);
            return false;
        }

        $handled = false;
        foreach ($this->events as $eventName => $eventData) {
            if ($this->matchesEvent($eventName, $update, $eventData['conditions'])) {
                $this->logger->info("Processing event", ['event' => $eventName]);
                try {
                    if ($eventName === 'private' && str_starts_with($update->getField('message.text', ''), '/')) {
                        $this->logger->debug("Skipping command message in event handler", ['text' => $update->getField('message.text')]);
                        continue;
                    }
                    $isAdmin = $this->isAdmin($update);
                    call_user_func($eventData['handler'], $update, $bot, $isAdmin); // Pass $update instead of $message
                    $this->logger->debug("Event executed successfully", ['event' => $eventName]);
                    $handled = true;
                } catch (Exception $e) {
                    $this->logger->error("Error executing event", [
                        'event' => $eventName,
                        'error' => $e->getMessage(),
                        'stack_trace' => $e->getTraceAsString()
                    ]);
                    throw $e; // Propagate to UpdateHandler
                }
            }
        }
        return $handled;
    }

    private function matchesEvent(string $eventName, TelegramUpdate $update, array $conditions): bool
    {
        $eventConditions = [
            'private' => fn() => $update->getField('message.chat.type') === 'private',
            'group' => fn() => $update->getField('message.chat.type') === 'group',
            'channel' => fn() => $update->getField('message.chat.type') === 'channel',
            'photo' => fn() => $update->getField('message.photo') !== null,
            'video' => fn() => $update->getField('message.video') !== null,
            'audio' => fn() => $update->getField('message.audio') !== null,
            'voice' => fn() => $update->getField('message.voice') !== null,
            'document' => fn() => $update->getField('message.document') !== null,
            'animation' => fn() => $update->getField('message.animation') !== null,
            'sticker' => fn() => $update->getField('message.sticker') !== null,
            'location' => fn() => $update->getField('message.location') !== null,
            'contact' => fn() => $update->getField('message.contact') !== null,
            'poll' => fn() => $update->getField('message.poll') !== null,
        ];

        $baseMatch = isset($eventConditions[$eventName]) && $eventConditions[$eventName]();
        if (!$baseMatch) {
            return false;
        }

        // Apply additional conditions if specified
        foreach ($conditions as $field => $value) {
            if ($update->getField("message.$field") !== $value) {
                return false;
            }
        }
        return true;
    }

    public function isAdmin(TelegramUpdate $update): bool
    {
        $chatId = $update->getField('message.chat.id');
        return $chatId !== null && in_array($chatId, $this->adminIDs);
    }
}