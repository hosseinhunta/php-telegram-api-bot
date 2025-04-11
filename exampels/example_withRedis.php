<?php
require_once '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Core\Storage\RedisUpdateStorage;
use Hosseinhunta\PhpTelegramBotApi\Updates\UpdateHandler;
use Psr\Log\NullLogger;
use Redis;



$token = 'YOUR_BOT_TOKEN_HERE';
$options = [
    'cache_enabled' => true,
    'cache_type' => 'redis',
    'redis_host' => 'localhost',
    'redis_port' => 6379,
    'cache_max_size' => 500,
    'log_file' => 'echo_bot.log',
    'verify_ssl' => false
];

$bot = new Bot($token, $options);

$logger = new NullLogger();

$redis = new Redis();
$redis->connect('localhost', 6379);
$storage = new RedisUpdateStorage($redis);

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
