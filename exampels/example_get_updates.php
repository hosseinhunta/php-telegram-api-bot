<?php

require __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;

$bot = new Bot("Token", [
    'http_client' => 'guzzle',
    'timeout' => 15,
    'retries' => 2,
    'log_file' => 'updates.log'
]);

$updates = $bot->getUpdates([
    'offset' => 0,
    'limit' => 10,
    'timeout' => 5
]);

foreach ($updates as $update) {
    echo "Update ID: " . $update->getUpdateId() . "\n";
    print_r($update->getMessage());
    print_r($update->getRawData());
}