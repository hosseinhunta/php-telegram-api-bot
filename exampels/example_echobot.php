<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
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

$bot->request('deleteWebhook', ['drop_pending_updates' => true]);
$logger->info("Webhook حذف شد");

$updateHandler = new UpdateHandler(
    $bot,
    'polling',
    $logger,
    $storage,
    0.1,
    50,
    true
);

$updateHandler->setUpdateCallback(function (TelegramUpdate $update, Bot $bot) use ($logger) {
    $message = $update->getMessage();
    if ($message && ($text = $update->getField('message.text'))) {
        $chatId = $update->getField('message.chat.id');
        $bot->request('sendMessage', [
            'chat_id' => $chatId,
            'text' => 'You Say: ' . $text
        ]);
        $logger->info("پیام اکو شد", ['chat_id' => $chatId, 'text' => $text]);
    }
});

try {
    $logger->info("Echo Bot شروع به کار کرد");
    $updateHandler->handleUpdates();
} catch (Exception $e) {
    $logger->error("خطا: " . $e->getMessage());
}