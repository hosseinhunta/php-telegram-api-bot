<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Updates\UpdateHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$token = '7994367682:AAG3G6dXcMMULmMqHMZaKQnqNUbaxNlr03I';

$logger = new Logger('telegram_bot_polling');
$logger->pushHandler(new StreamHandler('polling.log', Logger::DEBUG));

$options = [
    'http_client' => 'guzzle',
    'http_proxy' => 'http://127.0.0.1:10808',
    'verify_ssl' => false,
    'timeout' => 15,
    'retries' => 2,
    'keep_alive' => true,
    'log_file' => 'telegram_bot.log',
];

try {
    $bot = new Bot($token, $options, $logger);
} catch (Exception $e) {
    $logger->error("Error initializing bot: " . $e->getMessage());
    exit(1);
}

$bot->setErrorHandler(function ($method, $e, $params) use ($logger) {
    $logger->error("Custom error in method '$method': " . $e->getMessage(), ['params' => $params]);
    return ['ok' => false, 'error' => $e->getMessage()];
});

$updateHandler = new UpdateHandler($bot, 'polling', $logger);

$updateHandler->setUpdateCallback(function ($update, $bot) use ($logger) {
    $chatId = $update['message']['chat']['id'];
    $text = $update['message']['text'];

    $logger->debug("Processing update", ['chat_id' => $chatId, 'text' => $text]);

    if ($text == '/start') {
        $response = $bot->sendMessage($chatId, 'Bot Ready!', [
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => '/help']],
                    [['text' => 'Say Hello']],
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => false,
            ]),
        ]);
        $logger->info("Test message sent with keyboard", ['response' => $response]);
    } elseif ($text == 'Say Hello') {
        $response = $bot->sendMessage($chatId, 'Hello! How can I help you today?');
        $logger->info("Say Hello response sent", ['response' => $response]);
    } elseif ($text == '/help') {
        $response = $bot->sendMessage($chatId, 'This is an Echo Bot. I repeat whatever you say!');
        $logger->info("Help response sent", ['response' => $response]);
    } else {
        $response = $bot->sendMessage($chatId, $text);
        $logger->info("Echo message sent", ['response' => $response]);
    }
});

$updateHandler->handleUpdates(['timeout' => 30]);