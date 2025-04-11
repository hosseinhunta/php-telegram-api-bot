<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Core\handler\CallbackQueryHandler;
use Hosseinhunta\PhpTelegramBotApi\Core\handler\CommandHandler;
use Hosseinhunta\PhpTelegramBotApi\Core\Storage\ArrayUpdateStorage;
use Hosseinhunta\PhpTelegramBotApi\Updates\TelegramUpdate;
use Hosseinhunta\PhpTelegramBotApi\Updates\UpdateHandler;
use Psr\Log\NullLogger;

$token = 'YOUR_BOT_TOKEN_HERE';

$options = [
    'cache_enabled' => true,
    'cache_type' => 'array',
    'cache_max_size' => 500,
    'log_file' => 'command_bot.log',
    'verify_ssl' => false,
    'http_proxy' => 'http://127.0.0.1:10808',
];

$bot = new Bot($token, $options);
$logger = new NullLogger();

$callbackQueryHandler = new CallbackQueryHandler($logger);
$commandHandler = new CommandHandler($logger);

$storage = new ArrayUpdateStorage();

$updateHandler = new UpdateHandler(
    $bot,
    'polling',
    $logger,
    $storage,
    0.1,
    50,
    true
);

$callbackQueryHandler->setCallback('give_me_advice', function (TelegramUpdate $update, Bot $bot) use ($logger) {
    $chatId = $update->getField('callback_query.from.id');
    try {
        $adviceResponse = $bot->sendCustomRequest('https://api.adviceslip.com/advice', 'GET');
        $text = $adviceResponse['slip']['advice'] ?? 'Sorry, no advice available.';
    } catch (Exception $e) {
        $text = "Failed to fetch advice: " . $e->getMessage();
        $logger->error("Advice fetch failed", ['error' => $e->getMessage()]);
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

$commandHandler->setCommand('/start', function (TelegramUpdate $update, Bot $bot) use ($logger) {
    $chatId = $update->getField('message.chat.id');
    $bot->sendMessage($chatId, 'Hello! This is a test message from PhpTelegramBotApi.');
    $bot->sendPhoto(
        $chatId,
        'https://file-examples.com/storage/fe2465184067ef97996fb41/2017/10/file_example_JPG_100kB.jpg',
        ['caption' => 'test_photo.jpg']
    );
    $bot->sendDocument($chatId, 'https://file-examples.com/storage/fe2465184067ef97996fb41/2017/10/file-sample_150kB.pdf');
    $bot->sendAudio($chatId, 'https://file-examples.com/storage/fe2465184067ef97996fb41/2017/11/file_example_MP3_700KB.mp3');
    $bot->sendVideo($chatId, 'https://file-examples.com/storage/fe2465184067ef97996fb41/2017/04/file_example_MP4_480_1_5MG.mp4');
    $logger->info("/start worked");
});

$updateHandler->setUpdateCallback(function (TelegramUpdate $update, Bot $bot) use ($logger) {
    $chatId = $update->getField('message.chat.id') ?? $update->getField('callback_query.from.id');
    $text = $update->getField('message.text');

    $bot->sendMessage($chatId, "Click Button", [
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'Youtube', 'url' => 'https://www.youtube.com'], ['text' => 'HosseinHunTa', 'url' => 'https://github.com/hosseinhunta']],
                [['text' => 'Give Me Advice', 'callback_data' => 'give_me_advice']],
            ]
        ])
    ]);

    $logger->info("Send Keyboard", ['chat_id' => $chatId, 'text' => $text]);
});

try {
    $logger->info("Keyboard Bot Running");
    $updateHandler->setCallbackQueryHandler($callbackQueryHandler);
    $updateHandler->setCommandHandler($commandHandler);
    $updateHandler->handleUpdates();
} catch (Exception $e) {
    $logger->error("Error : " . $e->getMessage());
}