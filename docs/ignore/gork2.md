باشه! فقط بخش‌هایی که برای بهینه‌سازی، تنظیمات بیشتر و پشتیبانی از Async تغییر کردن رو می‌دم، بقیه کد همون قبلی می‌مونه. بعدش هم مثال می‌ذارم.

---

### بخش‌های تغییر کرده
#### 1. **متغیرها و سازنده**
```php
class Bot
{
    protected string $token;
    protected LoggerInterface $logger;
    protected string $baseUrl = 'https://api.telegram.org/bot';
    protected string $httpClientType;
    protected ?GuzzleClient $guzzleClient = null;
    protected array $httpOptions; // جدید

    public function __construct(string $token, array $options = [], ?LoggerInterface $logger = null)
    {
        $this->token = $token;
        $this->httpOptions = array_merge([
            'http_client' => 'curl',
            'timeout' => 10,
            'retries' => 0,
            'keep_alive' => true,
        ], $options);

        $this->httpClientType = in_array($this->httpOptions['http_client'], ['curl', 'guzzle'])
            ? $this->httpOptions['http_client']
            : 'curl';

        $this->logger = $this->setupDefaultLogger($logger, $this->httpOptions['log_file'] ?? null);

        if ($this->httpClientType === 'guzzle') {
            $this->guzzleClient = new GuzzleClient([
                'base_uri' => $this->baseUrl . $this->token . '/',
                'timeout' => $this->httpOptions['timeout'],
                'http_errors' => false,
                'headers' => $this->httpOptions['keep_alive'] ? ['Connection' => 'keep-alive'] : [],
            ]);
        }
    }
```

#### 2. **متدهای درخواست (Sync و Async)**
```php
    public function request(string $method, array $params = []): array
    {
 mansion    return $this->sendRequest($method, $params, false);
    }

    public function requestAsync(string $method, array $params = []): ?PromiseInterface
    {
        if ($this->httpClientType !== 'guzzle') {
            $this->logger->warning("Async requests are only supported with Guzzle.");
            return null;
        }
        return $this->sendRequest($method, $params, true);
    }

    protected function sendRequest(string $method, array $params, bool $async)
    {
        $this->logger->debug("Preparing request", [
            'method' => $method,
            'params' => $params,
            'client' => $this->httpClientType,
            'async' => $async
        ]);

        $attempts = 0;
        while ($attempts <= $this->httpOptions['retries']) {
            try {
                $response = $this->httpClientType === 'guzzle'
                    ? $this->sendWithGuzzle($method, $params, $async)
                    : $this->sendWithCurl($method, $params);

                if ($async) {
                    return $response; // Promise برمی‌گردونه
                }

                $result = json_decode($response, true);
                if (!$result || !isset($result['ok']) || !$result['ok']) {
                    throw new Exception("Telegram API error: " . ($result['description'] ?? 'Unknown error'));
                }

                $this->logger->info("Request successful", ['method' => $method, 'result' => $result]);
                return $result;
            } catch (Exception $e) {
                $attempts++;
                $this->logError("Request attempt #$attempts failed", [
                    'method' => $method,
                    'error' => $e->getMessage(),
                ]);

                if ($attempts > $this->httpOptions['retries']) {
                    $this->logError("Max retries exceeded", ['method' => $method]);
                    throw $e;
                }
                sleep(1); // تاخیر قبل از تلاش بعدی
            }
        }
    }
```

#### 3. **متدهای ارسال (cURL و Guzzle)**
```php
    protected function sendWithCurl(string $method, array $params): string
    {
        $url = $this->baseUrl . $this->token . '/' . $method;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->httpOptions['timeout']);
        if ($this->httpOptions['keep_alive']) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: keep-alive']);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false || $httpCode !== 200) {
            throw new Exception("cURL error: $error (HTTP $httpCode)");
        }

        return $response;
    }

    protected function sendWithGuzzle(string $method, array $params, bool $async)
    {
        $options = [
            'form_params' => $params,
            'timeout' => $this->httpOptions['timeout'],
        ];

        return $async
            ? $this->guzzleClient->postAsync($method, $options)
            : $this->guzzleClient->post($method, $options)->getBody()->getContents();
    }
```

---

### مثال استفاده
#### 1. درخواست معمولی (Sync) با تنظیمات
```php
use Hosseinhunta\PhpTelegramBotApi\Bot;

$bot = new Bot("توکن_رباتت", [
    'http_client' => 'curl', // یا 'guzzle'
    'timeout' => 20,
    'retries' => 3,
    'keep_alive' => true,
    'log_file' => 'bot_sync.log'
]);

$result = $bot->request("sendMessage", [
    "chat_id" => 123456,
    "text" => "سلام همگام با تنظیمات!"
]);
print_r($result);
```

#### 2. درخواست ناهمگام (Async) با Guzzle
```php
use Hosseinhunta\PhpTelegramBotApi\Bot;

$bot = new Bot("توکن_رباتت", [
    'http_client' => 'guzzle',
    'timeout' => 15,
    'retries' => 2,
    'log_file' => 'bot_async.log'
]);

// یه درخواست ناهمگام
$promise = $bot->requestAsync("sendMessage", [
    "chat_id" => 123456,
    "text" => "سلام ناهمگام!"
]);
$result = $promise->wait();
print_r($result);

// چند درخواست ناهمگام با هم
$promises = [
    $bot->requestAsync("sendMessage", ["chat_id" => 123456, "text" => "پیام 1"]),
    $bot->requestAsync("sendMessage", ["chat_id" => 123456, "text" => "پیام 2"]),
];
$results = \GuzzleHttp\Promise\unwrap($promises);
print_r($results);
```

---

این تغییرات رو توی کدت اعمال کن، بقیه قسمت‌ها (مثل `setupDefaultLogger` و `logError`) همون قبلی می‌مونن. اگه چیزی رو بیشتر توضیح بدم یا تست بخوای، بگو!