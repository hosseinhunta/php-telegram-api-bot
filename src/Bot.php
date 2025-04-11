<?php

namespace Hosseinhunta\PhpTelegramBotApi;

use CURLFile;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use Hosseinhunta\PhpTelegramBotApi\Core\Exception\NetworkException;
use Hosseinhunta\PhpTelegramBotApi\Core\Exception\TelegramApiException;
use Hosseinhunta\PhpTelegramBotApi\Core\Exception\ValidationException;
use Hosseinhunta\PhpTelegramBotApi\Core\MiddlewareInterface;
use Hosseinhunta\PhpTelegramBotApi\Methods\botMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\chatMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\forumMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\gameMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\getMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\giftMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\inlineMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\paymentMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\sendMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\stickerMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\updateMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\userMethod;
use Hosseinhunta\PhpTelegramBotApi\Updates\Update;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Enhanced Telegram Bot API client without caching support.
 */
class Bot
{
    protected string $token;
    protected LoggerInterface $logger;
    protected string $baseUrl = 'https://api.telegram.org/bot';
    protected string $httpClientType;
    protected ?GuzzleClient $guzzleClient = null;
    protected array $httpOptions;
    protected $errorHandler = null;
    protected array $middleware = [];
    protected int $maxConcurrentRequests;

    use Update, chatMethod, getMethod, sendMethod, botMethod, stickerMethod, userMethod, giftMethod, forumMethod, updateMethod, inlineMethod, paymentMethod, gameMethod;

    public function __construct(
        string           $token,
        array            $options = [],
        ?LoggerInterface $logger = null
    ) {
        if (empty($token) || !preg_match('/^\d+:[A-Za-z0-9\-_]+$/', $token)) {
            throw new ValidationException('Invalid or empty Telegram API token provided.');
        }

        $this->token = $token;
        $this->httpOptions = array_merge([
            'http_client' => 'curl',
            'timeout' => 10,
            'retries' => 3,
            'keep_alive' => true,
            'max_concurrent_requests' => 50,
            'http_proxy' => null,
            'socket_proxy' => null,
            'verify_ssl' => true,
            'log_file' => null,
            'max_memory_usage' => 10485760, // 10MB
        ], $options);

        $this->httpClientType = in_array($this->httpOptions['http_client'], ['curl', 'guzzle']) ? $this->httpOptions['http_client'] : 'curl';
        $this->logger = $this->setupDefaultLogger($logger, $this->httpOptions['log_file']);
        $this->maxConcurrentRequests = max(1, $this->httpOptions['max_concurrent_requests']);

        $this->checkMemoryUsage();
        if ($this->httpClientType === 'guzzle') {
            $this->initializeGuzzleClient();
        }
    }

    protected function setupDefaultLogger(?LoggerInterface $logger, ?string $logFile): LoggerInterface
    {
        if ($logger !== null) {
            return $logger;
        }

        if (class_exists('\Monolog\Logger') && class_exists('\Monolog\Handler\StreamHandler')) {
            $logFile = $logFile ?? 'telegram_bot.log';
            try {
                $monolog = new Logger('telegram_bot');
                $monolog->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
                return $monolog;
            } catch (Exception $e) {
                return new NullLogger();
            }
        }
        return new NullLogger();
    }

    protected function checkMemoryUsage(): void
    {
        if (memory_get_usage() > $this->httpOptions['max_memory_usage']) {
            $this->logger->critical("Memory usage exceeded limit.", ['memory' => memory_get_usage()]);
            throw new Exception("Memory usage exceeded configured limit.");
        }
    }

    private function initializeGuzzleClient(): void
    {
        $guzzleConfig = [
            'base_uri' => $this->baseUrl . $this->token . '/',
            'timeout' => $this->httpOptions['timeout'],
            'http_errors' => false,
            'headers' => $this->httpOptions['keep_alive'] ? ['Connection' => 'keep-alive'] : [],
            'verify' => $this->httpOptions['verify_ssl'],
        ];

        if ($this->httpOptions['http_proxy'] || $this->httpOptions['socket_proxy']) {
            $guzzleConfig['proxy'] = array_filter([
                'http' => $this->httpOptions['http_proxy'],
                'https' => $this->httpOptions['http_proxy'] ?: $this->httpOptions['socket_proxy'],
            ]);
        }

        $this->guzzleClient = new GuzzleClient($guzzleConfig);
    }

    public function setErrorHandler(?callable $handler): self
    {
        $this->errorHandler = $handler;
        return $this;
    }

    public function request(string $method, array $params = []): array
    {
        $this->checkMemoryUsage();
        if (empty($method) || !preg_match('/^[a-zA-Z]+$/', $method)) {
            throw new ValidationException("Invalid Telegram API method provided.");
        }

        $params = $this->normalizeParams($params);
        $handler = function (string $method, array $params) {
            return $this->sendRequest($method, $params, false);
        };

        return $this->processMiddleware($method, $params, $handler);
    }

    protected function normalizeParams(array $params): array
    {
        $normalized = [];
        foreach ($params as $key => $value) {
            if ($value instanceof CURLFile) {
                $normalized[$key] = $value;
            } elseif (is_array($value)) {
                $normalized[$key] = json_encode($value);
            } elseif (is_object($value) && method_exists($value, '__toString')) {
                $normalized[$key] = (string)$value;
            } else {
                $normalized[$key] = $value;
            }
        }
        return $normalized;
    }

    protected function sendRequest(string $method, array $params, bool $async)
    {
        $attempts = 0;
        while ($attempts <= $this->httpOptions['retries']) {
            try {
                $response = $this->httpClientType === 'guzzle' ? $this->sendWithGuzzle($method, $params, $async) : $this->sendWithCurl($method, $params);
                if ($async) {
                    return $response->then(
                        function ($response) use ($method) {
                            $result = json_decode($response->getBody()->getContents(), true);
                            return $this->validateResponse($result, $method);
                        },
                        function ($reason) use ($method) {
                            throw new NetworkException("Async request failed: " . $reason->getMessage());
                        }
                    );
                }
                $result = json_decode($response, true);
                return $this->validateResponse($result, $method);
            } catch (Exception $e) {
                $attempts++;
                $this->logError("Request attempt #$attempts failed.", ['method' => $method, 'exception' => $e]);
                if ($attempts > $this->httpOptions['retries']) {
                    if ($this->errorHandler) {
                        return call_user_func($this->errorHandler, $method, $e, $params);
                    }
                    throw $this->normalizeException($e);
                }
                sleep(1);
            }
        }
    }

    protected function sendWithGuzzle(string $method, array $params, bool $async)
    {
        $options = ['timeout' => $this->httpOptions['timeout']];
        if ($this->hasFile($params)) {
            $options['multipart'] = $this->prepareMultipart($params);
        } else {
            $options['form_params'] = $params;
        }
        return $async ? $this->guzzleClient->postAsync($method, $options) : $this->guzzleClient->post($method, $options)->getBody()->getContents();
    }

    protected function hasFile(array $params): bool
    {
        foreach ($params as $value) {
            if ($value instanceof CURLFile || (is_string($value) && file_exists($value) && is_readable($value))) {
                return true;
            }
        }
        return false;
    }

    protected function prepareMultipart(array $params): array
    {
        $multipart = [];
        foreach ($params as $name => $value) {
            if ($value instanceof CURLFile || (is_string($value) && file_exists($value) && is_readable($value))) {
                $filePath = $value instanceof CURLFile ? $value->getFilename() : $value;
                if (!file_exists($filePath) || !is_readable($filePath)) {
                    throw new ValidationException("File is not accessible: $filePath");
                }
                $multipart[] = [
                    'name' => $name,
                    'contents' => fopen($filePath, 'r'),
                    'filename' => basename($filePath),
                    'headers' => ['Content-Type' => mime_content_type($filePath) ?: 'application/octet-stream'],
                ];
            } else {
                $multipart[] = [
                    'name' => $name,
                    'contents' => is_array($value) ? json_encode($value) : (string)$value,
                    'headers' => is_array($value) ? ['Content-Type' => 'application/json'] : [],
                ];
            }
        }
        return $multipart;
    }

    protected function sendWithCurl(string $method, array $params): string
    {
        if (!preg_match('/^[a-zA-Z]+$/', $method)) {
            throw new ValidationException("Invalid API method name.");
        }

        $url = $this->baseUrl . $this->token . '/' . $method;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->httpOptions['timeout']);
        if ($this->httpOptions['keep_alive']) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: keep-alive']);
        }
        if (!$this->httpOptions['verify_ssl']) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $this->configureCurlProxy($ch);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->hasFile($params) ? $params : http_build_query($params));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            throw new NetworkException("cURL error: $error (HTTP $httpCode)");
        }
        return $response;
    }

    public function sendCustomRequest(string $url, string $httpMethod = 'POST', array $params = []): array|string
    {
        $this->checkMemoryUsage();
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new ValidationException("Invalid URL provided for custom request.");
        }

        $params = $this->normalizeParams($params);
        $attempts = 0;

        while ($attempts <= $this->httpOptions['retries']) {
            try {
                if ($this->httpClientType === 'guzzle') {
                    $options = [
                        'timeout' => $this->httpOptions['timeout'],
                        'verify' => $this->httpOptions['verify_ssl'],
                    ];
                    if ($this->hasFile($params)) {
                        $options['multipart'] = $this->prepareMultipart($params);
                    } else {
                        $options[$httpMethod === 'GET' ? 'query' : 'form_params'] = $params;
                    }
                    $response = $this->guzzleClient->request($httpMethod, $url, $options);
                    $body = $response->getBody()->getContents();
                } else {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $this->httpOptions['timeout']);
                    if ($this->httpOptions['keep_alive']) {
                        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: keep-alive']);
                    }
                    if (!$this->httpOptions['verify_ssl']) {
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    }
                    $this->configureCurlProxy($ch);

                    if ($httpMethod === 'POST') {
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->hasFile($params) ? $params : http_build_query($params));
                    } elseif ($httpMethod === 'GET') {
                        curl_setopt($ch, CURLOPT_HTTPGET, true);
                        if (!empty($params)) {
                            $url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . http_build_query($params);
                            curl_setopt($ch, CURLOPT_URL, $url);
                        }
                    }

                    $body = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $error = curl_error($ch);
                    curl_close($ch);

                    if ($body === false) {
                        throw new NetworkException("cURL error: $error (HTTP $httpCode)");
                    }
                }

                $decoded = json_decode($body, true);
                return $decoded !== null && json_last_error() === JSON_ERROR_NONE ? $decoded : $body;
            } catch (Exception $e) {
                $attempts++;
                $this->logError("Custom request attempt #$attempts failed.", ['url' => $url, 'exception' => $e]);
                if ($attempts > $this->httpOptions['retries']) {
                    if ($this->errorHandler) {
                        return call_user_func($this->errorHandler, $url, $e, $params);
                    }
                    throw $this->normalizeException($e);
                }
                sleep(1);
            }
        }
    }

    protected function configureCurlProxy($ch): void
    {
        if ($this->httpOptions['http_proxy'] && $this->validateProxy($this->httpOptions['http_proxy'])) {
            curl_setopt($ch, CURLOPT_PROXY, $this->httpOptions['http_proxy']);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            if (preg_match('/http:\/\/([^:]+):([^@]+)@/', $this->httpOptions['http_proxy'], $matches)) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$matches[1]}:{$matches[2]}");
            }
        } elseif ($this->httpOptions['socket_proxy'] && $this->validateProxy($this->httpOptions['socket_proxy'])) {
            curl_setopt($ch, CURLOPT_PROXY, $this->httpOptions['socket_proxy']);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            if (preg_match('/socks5:\/\/([^:]+):([^@]+)@/', $this->httpOptions['socket_proxy'], $matches)) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$matches[1]}:{$matches[2]}");
            }
        }
    }

    protected function validateProxy(string $proxy): bool
    {
        return preg_match('/^(http|socks5):\/\/(?:[^:]+:[^@]+@)?[^:]+:\d+$/', $proxy) === 1;
    }

    protected function validateResponse(?array $result, string $method): array
    {
        if (!is_array($result)) {
            throw new NetworkException("Invalid JSON response from Telegram API.");
        }
        if (!$result['ok']) {
            if (isset($result['error_code']) && $result['error_code'] === 429) {
                $retryAfter = $result['parameters']['retry_after'] ?? 1;
                $this->logger->warning("Rate limit exceeded, retrying after $retryAfter seconds.", ['method' => $method]);
                sleep($retryAfter);
                return $this->sendRequest($method, $this->normalizeParams([]), false);
            }
            throw new TelegramApiException($result['description'] ?? 'Unknown error', $result['error_code'] ?? 0);
        }
        $this->logger->info("Request successful.", ['method' => $method]);
        return $result;
    }

    protected function logError(string $message, array $context = []): void
    {
        $this->logger->error($message, array_merge(['timestamp' => date('Y-m-d H:i:s'), 'client' => $this->httpClientType], $context));
    }

    protected function normalizeException(Exception $e): Exception
    {
        return $e instanceof GuzzleException ? new NetworkException("Network error: " . $e->getMessage(), 0, $e) : $e;
    }

    protected function processMiddleware(string $method, array $params, callable $handler)
    {
        $stack = $handler;
        foreach (array_reverse($this->middleware) as $middleware) {
            if (!$middleware instanceof MiddlewareInterface) {
                throw new ValidationException("Middleware must implement MiddlewareInterface.");
            }
            $stack = fn($m, $p) => $middleware->handle($m, $p, $stack);
        }
        return $stack($method, $params);
    }

    public function requestAsync(string $method, array $params = []): PromiseInterface
    {
        if ($this->httpClientType !== 'guzzle') {
            throw new ValidationException("Asynchronous requests require Guzzle HTTP client.");
        }
        if (empty($method) || !preg_match('/^[a-zA-Z]+$/', $method)) {
            throw new ValidationException("Invalid Telegram API method provided.");
        }

        $params = $this->normalizeParams($params);
        $handler = function (string $method, array $params) {
            return $this->sendRequest($method, $params, true);
        };

        return $this->processMiddleware($method, $params, $handler);
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getHttpClientType(): string
    {
        return $this->httpClientType;
    }

    public function addMiddleware(MiddlewareInterface $middleware): self
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    public function __destruct()
    {
        // No cache-related cleanup needed
    }
}