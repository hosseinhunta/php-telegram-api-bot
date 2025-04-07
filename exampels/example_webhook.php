<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Updates\UpdateHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$token = 'YOUR_BOT_TOKEN_HERE';

$logger = new Logger('telegram_bot_webhook');
$logger->pushHandler(new StreamHandler('webhook.log', Logger::DEBUG));

$options = [
    'http_client' => 'guzzle',
    'timeout' => 15,
    'retries' => 2,
    'keep_alive' => true,
    'log_file' => 'telegram_bot.log',
];

try {
    $bot = new Bot($token, $options, $logger);
} catch (Exception $e) {
    $logger->error("Error initializing bot: " . $e->getMessage());
    http_response_code(500);
    exit;
}

$bot->setErrorHandler(function ($method, $e, $params) use ($logger) {
    $logger->error("Custom error in method '$method': " . $e->getMessage(), ['params' => $params]);
    return ['ok' => false, 'error' => $e->getMessage()];
});

$updateHandler = new UpdateHandler($bot, 'webhook', $logger);

$updateHandler->setUpdateCallback(function ($update, $bot) use ($logger) {
    $chatId = $update['message']['chat']['id'];
    $text = $update['message']['text'];

    $logger->debug("Processing update", ['chat_id' => $chatId, 'text' => $text]);

    if ($text == '/start') {
        $response = $bot->sendMessage($chatId,'Bot Ready!');
        $logger->info("Test message sent", ['response' => $response]);
    }else{
        $response = $bot->sendMessage($chatId,$text);
        $logger->info("echo message sent", ['response' => $response]);
    }
});

$updateHandler->handleUpdates();