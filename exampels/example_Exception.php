<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Hosseinhunta\PhpTelegramBotApi\Bot;
use Hosseinhunta\PhpTelegramBotApi\Core\TelegramApiException;
use Hosseinhunta\PhpTelegramBotApi\Core\NetworkException;
use Hosseinhunta\PhpTelegramBotApi\Core\ValidationException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

const VALID_TOKEN = 'TOKEN';

function printResult(string $testName, $result): void
{
    echo "=== $testName ===</br>";
    if ($result instanceof Exception) {
        echo "Exception: " . get_class($result) . "</br>";
        echo "Message: " . $result->getMessage() . "</br>";
        if ($result instanceof TelegramApiException) {
            echo "Error Code: " . $result->getErrorCode() . "</br>";
            echo "Description: " . $result->getDescription() . "</br>";
        } elseif ($result instanceof NetworkException) {
            echo "HTTP Code: " . ($result->getHttpCode() ?: 'None') . "</br>";
            echo "Raw Response: " . ($result->getRawResponse() ?: 'None') . "</br>";
        } elseif ($result instanceof ValidationException) {
            echo "Parameter: " . ($result->getParameter() ?: 'None') . "</br>";
        }
    } else {
        echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "</br>";
    }
    echo "Log File: " . (file_exists(__DIR__ . '/telegram_bot.log') ? "Check telegram_bot.log" : "Not created") . "</br>";
    echo "================</br></br>";
}

$tests = [
    ['name' => 'Invalid Token', 'callback' => fn() => new Bot('')],
    ['name' => 'Successful getMe Request', 'callback' => fn() => (new Bot(VALID_TOKEN, ['log_file' => __DIR__ . '/telegram_bot.log']))->request('getMe')],
    ['name' => 'Missing Parameters for sendMessage', 'callback' => fn() => (new Bot(VALID_TOKEN))->request('sendMessage')],
    ['name' => 'Non-existent Method', 'callback' => fn() => (new Bot(VALID_TOKEN))->request('nonExistentMethod', ['chat_id' => 12345])],
    ['name' => 'Network Timeout', 'callback' => fn() => (new Bot(VALID_TOKEN, ['http_client' => 'curl', 'timeout' => 0.1]))->request('getMe')],
    ['name' => 'Custom Error Handler', 'callback' => function () {
        $bot = new Bot(VALID_TOKEN);
        $bot->setErrorHandler(fn($method, $e, $params) => ['ok' => false, 'custom_error' => "Custom handler triggered: {$e->getMessage()} in $method", 'params' => $params]);
        return $bot->request('sendMessage', ['chat_id' => 'invalid_id']);
    }],
    ['name' => 'Async Request with Error', 'callback' => function () {
        $bot = new Bot(VALID_TOKEN, ['http_client' => 'guzzle']);
        $promise = $bot->requestAsync('sendMessage');
        return $promise->wait();
    }],
    ['name' => 'Retries with Persistent Error', 'callback' => fn() => (new Bot(VALID_TOKEN, ['http_client' => 'guzzle', 'timeout' => 0.1, 'retries' => 2]))->request('getMe')],
];

foreach ($tests as $test) {
    $result = null;
    try {
        $result = $test['callback']();
    } catch (Exception $e) {
        $result = $e;
    }
    printResult($test['name'], $result);
}

$logFile = __DIR__ . '/telegram_bot.log';
if (file_exists($logFile)) {
    echo "=== Last 5 Lines of Log ===</br>";
    $logContent = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    echo implode("</br>", array_slice($logContent, -5)) . "</br>";
    echo "================</br>";
}