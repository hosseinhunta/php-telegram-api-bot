<?php
require_once '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Core\Storage\PdoUpdateStorage;
use Hosseinhunta\PhpTelegramBotApi\Updates\UpdateHandler;
use Psr\Log\NullLogger;
use PDO;


$token = 'YOUR_BOT_TOKEN_HERE';
$options = [
    'cache_enabled' => true,
    'cache_type' => 'pdo',
    'cache_max_size' => 500,
    'log_file' => 'echo_bot.log',
    'verify_ssl' => false,
    'pdo_dsn' => 'sqlite::memory:'
];

$bot = new Bot($token, $options);

$logger = new NullLogger();

$pdo = new PDO('sqlite:' . __DIR__ . '/telegram_database.sqlite');
//    $pdo = new PDO('mysql:host=localhost;dbname=telegram_db', 'username', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$storage = new PdoUpdateStorage($pdo);


$updateHandler = new UpdateHandler(
    $bot,
    'polling',
    $logger,
    $storage,
    0.1,
    50,
    true
);


$updateHandler->setUpdateCallback(function (array $update, Bot $bot) use ($logger) {
    if (isset($update['message']) && isset($update['message']['text'])) {
        $chatId = $update['message']['chat']['id'];
        $text = $update['message']['text'];

        $bot->sendMessage($chatId, 'You Say : ' . $text);

        $logger->info("Message Echo", ['chat_id' => $chatId, 'text' => $text]);
    }
});

try {
    $logger->info("Echo Bot Running");
    $updateHandler->handleUpdates();
} catch (Exception $e) {
    $logger->error("Error : " . $e->getMessage());
}