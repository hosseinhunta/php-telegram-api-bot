<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core\Storage;

interface UpdateStorageInterface
{
    public function has(string $updateId): bool;

    public function markAsProcessed(string $updateId, int $ttl = 3600): void;
}