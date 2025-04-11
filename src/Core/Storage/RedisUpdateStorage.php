<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core\Storage;

use Redis;

class RedisUpdateStorage implements UpdateStorageInterface
{
    private Redis $redis;
    private string $prefix = 'processed_update:';

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function has(string $updateId): bool
    {
        return (bool)$this->redis->get($this->prefix . $updateId);
    }

    public function markAsProcessed(string $updateId, int $ttl = 3600): void
    {
        $this->redis->setex($this->prefix . $updateId, $ttl, '1');
    }
}