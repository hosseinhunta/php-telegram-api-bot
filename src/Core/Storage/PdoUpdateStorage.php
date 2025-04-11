<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core\Storage;

use PDO;

class PdoUpdateStorage implements UpdateStorageInterface
{
    private PDO $pdo;
    private string $tableName = 'processed_updates';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->initializeTable();
    }

    private function initializeTable(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS {$this->tableName} (
                update_id VARCHAR(255) PRIMARY KEY,
                processed_at INTEGER NOT NULL
            )
        ");
    }

    public function has(string $updateId): bool
    {
        $stmt = $this->pdo->prepare("SELECT 1 FROM {$this->tableName} WHERE update_id = :update_id");
        $stmt->execute(['update_id' => $updateId]);
        return (bool)$stmt->fetchColumn();
    }

    public function markAsProcessed(string $updateId, int $ttl = 3600): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->tableName} (update_id, processed_at) 
            VALUES (:update_id, :processed_at) 
            ON DUPLICATE KEY UPDATE processed_at = :processed_at
        ");
        $stmt->execute([
            'update_id' => $updateId,
            'processed_at' => time(),
        ]);

        // Clean up old entries (optional, based on TTL)
        $this->pdo->exec("DELETE FROM {$this->tableName} WHERE processed_at < " . (time() - $ttl));
    }
}