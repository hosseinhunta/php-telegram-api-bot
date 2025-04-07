<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


$token = 'YOUR_BOT_TOKEN_HERE';
$chat_id = 123456789;

$logger = new Logger('telegram_bot_example');
$logger->pushHandler(new StreamHandler('example.log', Logger::DEBUG));

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
    echo "Error initializing bot: " . $e->getMessage() . "</br>";
    exit(1);
}

$bot->setErrorHandler(function ($method, $e, $params) {
    echo "Custom error in method '$method': " . $e->getMessage() . "</br>";
    return ['ok' => false, 'error' => $e->getMessage()];
});


try {
    $response = $bot->sendMessage($chat_id,'Hello! This is a test message from PhpTelegramBotApi.');
    echo "Message sent successfully: " . json_encode($response) . "<\br>";
} catch (Exception $e) {
    echo "Error sending message: " . $e->getMessage() . "<\br>";
}


try {
    $response = $bot->sendPhoto(
        $chat_id,
        'https://file-examples.com/storage/fe2465184067ef97996fb41/2017/10/file_example_JPG_100kB.jpg',
        ['caption' => 'test_photo.jpg']
    );
    echo "Photo sent successfully: " . json_encode($response) . "<\br>";
} catch (Exception $e) {
    echo "Error sending photo: " . $e->getMessage() . "<\br>";
}

try {
    $response = $bot->sendDocument($chat_id,'https://file-examples.com/storage/fe2465184067ef97996fb41/2017/10/file-sample_150kB.pdf');
    echo "Document sent successfully: " . json_encode($response) . "<\br>";
} catch (Exception $e) {
    echo "Error sending document: " . $e->getMessage() . "<\br>";
}

try {
    $response = $bot->sendAudio($chat_id,'https://file-examples.com/storage/fe2465184067ef97996fb41/2017/11/file_example_MP3_700KB.mp3');
} catch (Exception $e) {
    echo "Error sending audio: " . $e->getMessage() . "<\br>";
}

try {
    $response = $bot->sendVideo($chat_id,'https://file-examples.com/storage/fe2465184067ef97996fb41/2017/04/file_example_MP4_480_1_5MG.mp4');
} catch (Exception $e) {
    echo "Error sending Video: " . $e->getMessage() . "<\br>";
}

try {
    $response = $bot->getMe();
    echo "Bot info: " . json_encode($response) . "<\br>";
} catch (Exception $e) {
    echo "Error getting bot info: " . $e->getMessage() . "<\br>";
}

try {
    $webhookUrl = 'https://yourdomain.com/webhook.php';
    $response = $bot->setWebhook([
        'url' => $webhookUrl,
    ]);
    echo "Webhook set successfully: " . json_encode($response) . "<\br>";
} catch (Exception $e) {
    echo "Error setting webhook: " . $e->getMessage() . "<\br>";
}
