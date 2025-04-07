<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
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

$update = json_decode(file_get_contents('php://input'), true);

if (!$update) {
    $logger->warning("No update received");
    http_response_code(400);
    exit;
}

$logger->info("Received update", ['update' => $update]);

$chatId = $update['message']['chat']['id'] ?? null;
$text = $update['message']['text'] ?? '';

if ($chatId && $text) {
    try {
        // ارسال پیام echo
        $response = $bot->sendMessage($chatId, 'You say: ' . $text);
        $logger->info("Echo message sent", ['chat_id' => $chatId, 'text' => $text, 'response' => $response]);
    } catch (Exception $e) {
        $logger->error("Error sending echo message: " . $e->getMessage());
    }
} else {
    $logger->warning("Invalid update: missing chat_id or text", ['update' => $update]);
}