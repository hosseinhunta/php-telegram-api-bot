<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Core\handler\CallbackQueryHandler;
use Hosseinhunta\PhpTelegramBotApi\Core\Storage\ArrayUpdateStorage;
use Hosseinhunta\PhpTelegramBotApi\Updates\TelegramUpdate;
use Hosseinhunta\PhpTelegramBotApi\Updates\UpdateHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$token = 'YOUR_BOT_TOKEN_HERE';

$options = [
    'cache_enabled' => false,
    'log_file' => 'echo_bot.log',
    'verify_ssl' => false,
    'http_proxy' => 'http://127.0.0.1:10808',
];

$bot = new Bot($token, $options);

$logger = new Logger('echo_bot');
$logger->pushHandler(new StreamHandler('echo_bot.log', Logger::DEBUG));
$storage = new ArrayUpdateStorage();

$callbackQueryHandler = new CallbackQueryHandler($logger);

$updateHandler = new UpdateHandler(
    $bot,
    'polling',
    $logger,
    $storage,
    0.1,
    50,
    true
);

// Callback for "Give Me Advice"
$callbackQueryHandler->setCallback('give_me_advice', function (TelegramUpdate $update, Bot $bot) use ($logger) {
    $chatId = $update->getField('callback_query.from.id'); // Correct path for callback query
    $adviceResponse = $bot->sendCustomRequest('https://api.adviceslip.com/advice', "GET");

    if ($adviceResponse === false) {
        $text = "Sorry, I couldn't fetch an advice right now.";
    } else {
        $text = $adviceResponse['slip']['advice'] ?? "No advice available.";
    }

    $bot->sendMessage($chatId, $text, [
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'Youtube', 'url' => 'https://www.youtube.com'], ['text' => 'HosseinHunTa', 'url' => 'https://github.com/hosseinhunta']],
                [['text' => 'Give Me Advice', 'callback_data' => 'give_me_advice']],
            ]
        ])
    ]);

    $logger->info("Sent advice", ['chat_id' => $chatId, 'advice' => $text]);
});

// Update callback for initial message
$updateHandler->setUpdateCallback(function (TelegramUpdate $update, Bot $bot) use ($logger) {
    $chatId = $update->getField('message.chat.id');
    $text = $update->getField('message.text');

    if ($chatId && $text) {
        $bot->sendMessage($chatId, 'Click Button:', [
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'Youtube', 'url' => 'https://www.youtube.com'], ['text' => 'HosseinHunTa', 'url' => 'https://github.com/hosseinhunta']],
                    [['text' => 'Give Me Advice', 'callback_data' => 'give_me_advice']],
                ]
            ])
        ]);

        $logger->info("Sent keyboard", ['chat_id' => $chatId, 'text' => $text]);
    }
});

$updateHandler->setCallbackQueryHandler($callbackQueryHandler);

try {
    $logger->info("Keyboard Bot Running");
    $updateHandler->handleUpdates();
} catch (Exception $e) {
    $logger->error("Error: " . $e->getMessage(), ['stack_trace' => $e->getTraceAsString()]);
}