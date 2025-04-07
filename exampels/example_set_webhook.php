<?php

require __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;


$bot = new Bot("Token", [
    'http_client' => 'guzzle',
    'timeout' => 15,
    'retries' => 2,
    'log_file' => 'updates.log'
]);


$result = $bot->setWebhook([
    'url' => 'https://example.com/webhook',
    'max_connections' => 40
]);
print_r($result);


$webhookInfo = $bot->getWebhookInfo();
print_r($webhookInfo);


$result = $bot->deleteWebhook([
    'drop_pending_updates' => true
]);
print_r($result);