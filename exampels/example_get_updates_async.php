<?php

require __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;


$bot = new Bot("توکن_رباتت", [
    'http_client' => 'guzzle',
    'timeout' => 15,
    'retries' => 2,
    'log_file' => 'updates.log'
]);


$promise = $bot->getUpdatesAsync([
    'offset' => 0,
    'limit' => 10,
    'timeout' => 5
]);


$updates = $promise->wait();
foreach ($updates as $update) {
    echo "Update ID (Async): " . $update->getUpdateId() . "\n";
    print_r($update->getMessage());
    print_r($update->getRawData());

}