<?php

namespace Hosseinhunta\PhpTelegramBotApi;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

use Hosseinhunta\PhpTelegramBotApi\Core\TelegramApiException;
use Hosseinhunta\PhpTelegramBotApi\Core\NetworkException;
use Hosseinhunta\PhpTelegramBotApi\Core\ValidationException;

use Hosseinhunta\PhpTelegramBotApi\Updates\Update;

use Hosseinhunta\PhpTelegramBotApi\Methods\chatMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\getMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\sendMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\botMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\stickerMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\userMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\giftMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\forumMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\updateMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\inlineMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\paymentMethod;
use Hosseinhunta\PhpTelegramBotApi\Methods\gameMethod;

/**
 * Enhanced Telegram Bot API client with synchronous/asynchronous support and advanced error handling.
 * This class integrates various Telegram API methods via traits and provides robust error management.
 *
 * @package Hosseinhunta\PhpTelegramBotApi
 */
class Bot
{
    /** @var string Telegram Bot API token */
    protected string $token;

    /** @var LoggerInterface Logger instance for debugging and error logging */
    protected LoggerInterface $logger;

    /** @var string Base URL for Telegram API requests */
    protected string $baseUrl = 'https://api.telegram.org/bot';

    /** @var string HTTP client type ('curl' or 'guzzle') */
    protected string $httpClientType;

    /** @var GuzzleClient|null Guzzle HTTP client instance */
    protected ?GuzzleClient $guzzleClient = null;

    /** @var array HTTP client options (timeout, retries, etc.) */
    protected array $httpOptions;

    /** @var callable|null Custom error handler callback */
    protected $errorHandler;

    use Update;
    use chatMethod;
    use getMethod;
    use sendMethod;
    use botMethod;
    use stickerMethod;
    use userMethod;
    use giftMethod;
    use forumMethod;
    use updateMethod;
    use inlineMethod;
    use paymentMethod;
    use gameMethod;

    /**
     * Constructs a new Bot instance with customizable options and error handling.
     *
     * @param string $token Telegram Bot API token (e.g., '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11').
     * @param array $options Configuration options:
     *                       - http_client: 'curl' or 'guzzle' (default: 'curl')
     *                       - timeout: Request timeout in seconds (default: 10)
     *                       - retries: Number of retries on failure (default: 0)
     *                       - keep_alive: Enable HTTP keep-alive (default: true)
     *                       - log_file: Path to log file (optional, e.g., '/var/log/telegram_bot.log')
     * @param LoggerInterface|null $logger Custom PSR-3 compatible logger (optional).
     * @throws ValidationException If token is empty or invalid.
     */
    public function __construct(
        string $token,
        array $options = [],
        ?LoggerInterface $logger = null
    ) {
        if (empty($token) || !preg_match('/^\d+:[A-Za-z0-9\-_]+$/', $token)) {
            throw new ValidationException('Invalid or empty Telegram API token provided.');
        }

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

    /**
     * Sets up a default logger (Monolog if available, otherwise NullLogger).
     *
     * @param LoggerInterface|null $logger Custom logger instance (optional).
     * @param string|null $logFile Path to log file for Monolog (optional).
     * @return LoggerInterface Configured logger instance.
     */
    protected function setupDefaultLogger(?LoggerInterface $logger, ?string $logFile): LoggerInterface
    {
        if ($logger !== null) {
            return $logger;
        }

        if (class_exists('\Monolog\Logger') && class_exists('\Monolog\Handler\StreamHandler')) {
            $logFile = $logFile ?? 'telegram_bot.log';
            $monolog = new Logger('telegram_bot');
            $monolog->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
            return $monolog;
        }

        return new NullLogger();
    }

    /**
     * Sets a custom error handler callback to override default exception throwing.
     *
     * @param callable|null $handler Callback function with signature: function(string $method, Exception $e, array $params): mixed
     * @return self
     * @example ```php
     * $bot->setErrorHandler(function ($method, $e, $params) {
     *     echo "Error in $method: " . $e->getMessage();
     *     return ['ok' => false, 'error' => $e->getMessage()];
     * });
     * ```
     */
    public function setErrorHandler(?callable $handler): self
    {
        $this->errorHandler = $handler;
        return $this;
    }

    /**
     * Sends a synchronous request to the Telegram API.
     *
     * @param string $method Telegram API method (e.g., 'sendMessage').
     * @param array $params Parameters for the API method.
     * @return array Decoded JSON response from Telegram (e.g., ['ok' => true, 'result' => [...]]) or custom handler result.
     * @throws TelegramApiException|NetworkException|ValidationException If request fails and no custom handler is set.
     */
    public function request(string $method, array $params = []): array
    {
        return $this->sendRequest($method, $params, false);
    }

    /**
     * Sends an asynchronous request to the Telegram API (Guzzle only).
     *
     * @param string $method Telegram API method (e.g., 'sendMessage').
     * @param array $params Parameters for the API method.
     * @return PromiseInterface|null Promise for the response or null if async is not supported.
     * @throws ValidationException If async is requested but Guzzle is not used.
     */
    public function requestAsync(string $method, array $params = []): ?PromiseInterface
    {
        if ($this->httpClientType !== 'guzzle') {
            throw new ValidationException('Async requests are only supported with Guzzle HTTP client.');
        }
        return $this->sendRequest($method, $params, true);
    }

    /**
     * Core method to send requests to Telegram API with retry logic and error handling.
     *
     * @param string $method Telegram API method.
     * @param array $params Request parameters.
     * @param bool $async Whether to send the request asynchronously (Guzzle only).
     * @return mixed Response (array for sync, PromiseInterface for async) or custom handler result.
     * @throws TelegramApiException|NetworkException|ValidationException
     */
    protected function sendRequest(string $method, array $params, bool $async)
    {
        $this->logger->debug("Preparing request", ['method' => $method, 'params' => $params, 'client' => $this->httpClientType, 'async' => $async]);
        $attempts = 0;
        while ($attempts <= $this->httpOptions['retries']) {
            try {
                $response = $this->httpClientType === 'guzzle' ? $this->sendWithGuzzle($method, $params, $async) : $this->sendWithCurl($method, $params);
                if ($async) {
                    return $response->then(
                        function ($response) use ($method) {
                            $result = json_decode($response->getBody()->getContents(), true);
                            if (!is_array($result)) throw new NetworkException('Invalid JSON response from Telegram API.');
                            if (!$result['ok']) throw new TelegramApiException($result['description'] ?? 'Unknown Telegram API error', $result['error_code'] ?? 0, $result['description'] ?? '');
                            $this->logger->info("Request successful", ['method' => $method, 'result' => $result]);
                            return $result;
                        },
                        function ($reason) {
                            throw new NetworkException("Async request failed: " . $reason->getMessage());
                        }
                    );
                }
                $result = json_decode($response, true);
                if (!is_array($result)) throw new NetworkException('Invalid JSON response from Telegram API.');
                if (!$result['ok']) throw new TelegramApiException($result['description'] ?? 'Unknown Telegram API error', $result['error_code'] ?? 0, $result['description'] ?? '');
                $this->logger->info("Request successful", ['method' => $method, 'result' => $result]);
                return $result;
            } catch (Exception $e) {
                $attempts++;
                $this->logError("Request attempt #$attempts failed", ['method' => $method, 'error' => $e->getMessage(), 'params' => $params, 'response' => $response ?? null, 'exception' => $e]);
                if ($this->errorHandler) return call_user_func($this->errorHandler, $method, $e, $params);
                if ($attempts > $this->httpOptions['retries']) {
                    $this->logError("Max retries exceeded", ['method' => $method, 'exception' => $e]);
                    throw $this->normalizeException($e);
                }
                sleep(1);
            }
        }
    }

    /**
     * Normalizes exceptions to specific types for better handling.
     *
     * @param Exception $e Original exception.
     * @return Exception Normalized exception.
     */
    protected function normalizeException(Exception $e): Exception
    {
        if ($e instanceof GuzzleException) {
            return new NetworkException("Network error: " . $e->getMessage(), 0, $e);
        }
        return $e;
    }

    /**
     * Sends a request using Guzzle HTTP client.
     *
     * @param string $method Telegram API method.
     * @param array $params Request parameters.
     * @param bool $async Whether to send asynchronously.
     * @return mixed String response (sync) or PromiseInterface (async).
     * @throws GuzzleException
     */
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

    /**
     * Sends a request using cURL.
     *
     * @param string $method Telegram API method.
     * @param array $params Request parameters.
     * @return string Raw response body.
     * @throws NetworkException If cURL request fails.
     */
    protected function sendWithCurl(string $method, array $params): string
    {
        $url = $this->baseUrl . $this->token . '/' . $method;
        $this->logger->debug("Sending cURL request", ['url' => $url, 'params' => $params, 'timeout' => $this->httpOptions['timeout']]);
        $ch = \curl_init($url);

        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, CURLOPT_POST, true);
        \curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        \curl_setopt($ch, CURLOPT_TIMEOUT, $this->httpOptions['timeout']);
        if ($this->httpOptions['keep_alive']) {
            \curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: keep-alive']);
        }

        $response = \curl_exec($ch);
        $httpCode = \curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = \curl_error($ch);
        \curl_close($ch);

        if ($response === false) {
            $this->logger->error("cURL request failed", [
                'url' => $url,
                'error' => $error,
                'http_code' => $httpCode,
                'response' => $response
            ]);
            throw new NetworkException("cURL error: $error (HTTP $httpCode)");
        }

        $result = json_decode($response, true);
        if ($httpCode !== 200 && is_array($result) && isset($result['error_code'])) {
            throw new TelegramApiException(
                $result['description'] ?? 'Unknown Telegram API error',
                $result['error_code'] ?? 0,
                $result['description'] ?? ''
            );
        }

        return $response;
    }

    /**
     * Logs an error with detailed context, including exception-specific details.
     *
     * @param string $message Error message.
     * @param array $context Additional context (e.g., method, params, response).
     */
    protected function logError(string $message, array $context = []): void
    {
        $exception = $context['exception'] ?? null;
        $extraContext = [];

        if ($exception instanceof TelegramApiException) {
            $extraContext = [
                'error_code' => $exception->getErrorCode(),
                'description' => $exception->getDescription(),
            ];
        } elseif ($exception instanceof NetworkException) {
            $extraContext = [
                'http_code' => $exception->getHttpCode(),
                'raw_response' => $exception->getRawResponse(),
            ];
        } elseif ($exception instanceof ValidationException) {
            $extraContext = [
                'parameter' => $exception->getParameter(),
            ];
        }

        $this->logger->error($message, array_merge([
            'timestamp' => date('Y-m-d H:i:s'),
            'client' => $this->httpClientType,
        ], $context, $extraContext));
    }

    /**
     * Gets the logger instance for custom logging.
     *
     * @return LoggerInterface Current logger instance.
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}