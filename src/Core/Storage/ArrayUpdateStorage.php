<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core\Storage;

class ArrayUpdateStorage implements UpdateStorageInterface
{
    private array $processed = [];
    private int $maxSize = 1000;

    public function __construct(int $maxSize = 1000)
    {
        $this->maxSize = $maxSize;
    }

    public function has(string $updateId): bool
    {
        return isset($this->processed[$updateId]);
    }

    public function markAsProcessed(string $updateId, int $ttl = 3600): void
    {
        $this->processed[$updateId] = true;
        if (count($this->processed) > $this->maxSize) {
            array_shift($this->processed);
        }
    }
}