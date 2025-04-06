<?php

namespace Hosseinhunta\PhpTelegramBotApi\Updates;

/**
 * Class representing a single Telegram update.
 */
class TelegramUpdate
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Gets the update ID.
     *
     * @return int The update ID.
     */
    public function getUpdateId(): int
    {
        return $this->data['update_id'] ?? 0;
    }

    /**
     * Gets the message from the update, if available.
     *
     * @return array|null The message data or null if not present.
     */
    public function getMessage(): ?array
    {
        return $this->data['message'] ?? null;
    }

    /**
     * Gets the raw update data.
     *
     * @return array The raw update data.
     */
    public function getRawData(): array
    {
        return $this->data;
    }
}