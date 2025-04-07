خوبه! می‌خوای `Monolog` اختیاری بشه و به صورت پیش‌فرض ازش استفاده کنی، ولی کاربر بتونه هر لاگر دیگه‌ای که با استاندارد `PSR-3` (یعنی `LoggerInterface`) سازگاره رو جایگزین کنه. من کدت رو آپدیت می‌کنم که این انعطاف رو داشته باشه و همچنان حرفه‌ای بمونه.

---

### کد بازنویسی‌شده با Monolog اختیاری
```php
<?php

namespace Hosseinhunta\PhpTelegramBotApi;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Base class for interacting with the Telegram Bot API using cURL or Guzzle.
 *
 * @package Hosseinhunta\PhpTelegramBotApi
 */
class Bot
{
    /** @var string The bot's API token */
    protected string $token;

    /** @var LoggerInterface The logger instance for debugging and error tracking */
    protected LoggerInterface $logger;

    /** @var string The base URL for Telegram API requests */
    protected string $baseUrl = 'https://api.telegram.org/bot';

    /** @var string The HTTP client type ('curl' or 'guzzle') */
    protected string $httpClientType;

    /** @var GuzzleClient|null Guzzle HTTP client instance */
    protected ?GuzzleClient $guzzleClient;

    /**
     * Constructs a new TelegramBotBase instance.
     *
     * @param string $token The bot's API token from BotFather.
     * @param string $httpClientType 'curl' or 'guzzle' (default: 'curl').
     * @param LoggerInterface|null $logger Custom logger (defaults to Monolog if available, else NullLogger).
     * @param string|null $logFile Path to log file if using default Monolog (optional).
     */
    public function __construct(
        string $token,
        string $httpClientType = 'curl',
        ?LoggerInterface $logger = null,
        ?string $logFile = null
    ) {
        $this->token = $token;
        $this->httpClientType = in_array($httpClientType, ['curl', 'guzzle']) ? $httpClientType : 'curl';

        // تنظیم لاگر پیش‌فرض
        $this->logger = $this->setupDefaultLogger($logger, $logFile);

        if ($this->httpClientType === 'guzzle') {
            $this->guzzleClient = new GuzzleClient(['base_uri' => $this->baseUrl . $this->token . '/']);
        }
    }

    /**
     * Sets up the default logger (Monolog if available, otherwise NullLogger).
     *
     * @param LoggerInterface|null $logger Custom logger provided by user.
     * @param string|null $logFile Path to log file for Monolog.
     * @return LoggerInterface The configured logger.
     */
    protected function setupDefaultLogger(?LoggerInterface $logger, ?string $logFile): LoggerInterface
    {
        if ($logger !== null) {
            return $logger; // استفاده از لاگر سفارشی کاربر
        }

        // چک کردن اینکه Monolog در دسترس هست یا نه
        if (class_exists('\Monolog\Logger') && class_exists('\Monolog\Handler\StreamHandler')) {
            $logFile = $logFile ?? 'telegram_bot.log'; // فایل پیش‌فرض
            $monolog = new Logger('telegram_bot');
            $monolog->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
            return $monolog;
        }

        // اگر Monolog نباشه، از NullLogger استفاده می‌کنه
        return new NullLogger();
    }

    /**
     * Sends a request to the Telegram API using the selected HTTP client.
     *
     * @param string $method The API method to call (e.g., 'sendMessage').
     * @param array $params Parameters for the API method.
     * @return array The API response.
     * @throws Exception If the request fails.
     */
    public function request(string $method, array $params = []): array
    {
        $this->logger->debug("Preparing request", [
            'method' => $method,
            'params' => $params,
            'client' => $this->httpClientType
        ]);

        try {
            $response = $this->httpClientType === 'guzzle'
                ? $this->sendWithGuzzle($method, $params)
                : $this->sendWithCurl($method, $params);

            $result = json_decode($response, true);
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                $this->logError("Invalid Telegram API response", [
                    'response' => $response,
                    'description' => $result['description'] ?? 'Unknown error'
                ]);
                throw new Exception("Telegram API error: " . ($result['description'] ?? 'Unknown error'));
            }

            $this->logger->info("Request successful", [
                'method' => $method,
                'result' => $result
            ]);
            return $result;
        } catch (Exception $e) {
            $this->logError("Request failed", [
                'method' => $method,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Sends a request using cURL.
     *
     * @param string $method The API method.
     * @param array $params Request parameters.
     * @return string The raw response.
     * @throws Exception
     */
    protected function sendWithCurl(string $method, array $params): string
    {
        $url = $this->baseUrl . $this->token . '/' . $method;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($response === false || $httpCode !== 200) {
            throw new Exception("cURL error: $error (HTTP $httpCode)");
        }

        return $response;
    }

    /**
     * Sends a request using Guzzle.
     *
     * @param string $method The API method.
     * @param array $params Request parameters.
     * @return string The raw response.
     * @throws GuzzleException
     */
    protected function sendWithGuzzle(string $method, array $params): string
    {
        $response = $this->guzzleClient->post($method, [
            'form_params' => $params,
            'timeout' => 10
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * Logs an error with detailed context.
     *
     * @param string $message The error message.
     * @param array $context Additional context for the error.
     */
    protected function logError(string $message, array $context = []): void
    {
        $this->logger->error($message, array_merge([
            'timestamp' => date('Y-m-d H:i:s'),
            'client' => $this->httpClientType
        ], $context));
    }

    /**
     * Gets the logger instance.
     *
     * @return LoggerInterface The logger instance.
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
```

---

### تغییرات و توضیحات
#### 1. **سازنده (Constructor)**
- پارامتر `$logFile` اضافه شده که مسیر فایل لاگ رو برای Monolog مشخص می‌کنه (اختیاریه).
- لاگر پیش‌فرض توی متد `setupDefaultLogger` تنظیم می‌شه.

#### 2. **متد `setupDefaultLogger`**
- اگه کاربر یه لاگر سفارشی (مثل یه نمونه از `LoggerInterface`) بده، همون رو استفاده می‌کنه.
- اگه لاگر سفارشی نده:
    - چک می‌کنه که `Monolog` نصب باشه یا نه (`class_exists`).
    - اگه Monolog باشه، یه لاگر با اسم `telegram_bot` می‌سازه و لاگ‌ها رو توی فایل مشخص‌شده (پیش‌فرض `telegram_bot.log`) ذخیره می‌کنه.
    - اگه Monolog نباشه، از `NullLogger` استفاده می‌کنه که هیچی ثبت نمی‌کنه.

#### 3. **انعطاف‌پذیری**
- حالا کاربر می‌تونه:
    - از Monolog پیش‌فرض استفاده کنه (فقط کافیه پکیجش نصب باشه).
    - یه لاگر دیگه (مثل `Zend\Log` یا هر چیزی که `LoggerInterface` رو پیاده‌سازی کنه) بده.
    - هیچی نده و `NullLogger` بگیره.

---

### مثال استفاده
#### 1. با Monolog پیش‌فرض
اگه `monolog/monolog` نصب باشه:
```php
use Hosseinhunta\PhpTelegramBotApi\Bot;

$bot = new Bot("توکن_رباتت", "guzzle", null, "my_custom_log.log");
$bot->request("sendMessage", [
    "chat_id" => 123456,
    "text" => "سلام با Monolog!"
]);
```
لاگ‌ها توی `my_custom_log.log` ذخیره می‌شن.

#### 2. با لاگر سفارشی
```php
use Hosseinhunta\PhpTelegramBotApi\Bot;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$customLogger = new Logger('custom_logger');
$customLogger->pushHandler(new StreamHandler('custom.log', Logger::INFO));

$bot = new Bot("توکن_رباتت", "curl", $customLogger);
$bot->request("sendMessage", [
    "chat_id" => 123456,
    "text" => "سلام با لاگر سفارشی!"
]);
```

#### 3. بدون لاگ (NullLogger)
اگه Monolog نصب نباشه و لاگر هم ندی:
```php
use Hosseinhunta\PhpTelegramBotApi\Bot;

$bot = new Bot("توکن_رباتت");
$bot->request("sendMessage", [
    "chat_id" => 123456,
    "text" => "سلام بدون لاگ!"
]);
```

---

### نصب Monolog (اختیاری)
اگه بخوای Monolog پیش‌فرض کار کنه:
```bash
composer require monolog/monolog
```

---

### نقاط قوت
- **اختیاری بودن Monolog**: بدون وابستگی اجباری به Monolog کار می‌کنه.
- **انعطاف‌پذیری بالا**: هر لاگری که `PSR-3` رو پشتیبانی کنه قابل‌استفاده‌ست.
- **پیش‌فرض معقول**: اگه Monolog باشه، خودش یه لاگر خوب راه‌اندازی می‌کنه.

اگه سوال دیگه‌ای داری یا چیزی رو تغییر بدم، بگو!