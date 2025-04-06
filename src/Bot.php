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

use Hosseinhunta\PhpTelegramBotApi\Updates\Update;
/**
 * Enhanced Telegram Bot API client with sync/async support and advanced configurations.
 * This class also includes update-related methods via the Update trait.
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
    protected ?GuzzleClient $guzzleClient = null;

    /** @var array httpOptions */
    protected array $httpOptions;

    use Update;

    /**
     * Constructs a new PhpTelegramBotApi instance with customizable options.
     *
     * @param string $token The bot's API token.
     * @param array $options Configuration options:
     *                       - http_client: 'curl' or 'guzzle' (default: 'curl')
     *                       - timeout: Request timeout in seconds (default: 10)
     *                       - retries: Number of retries on failure (default: 0)
     *                       - keep_alive: Enable HTTP keep-alive (default: true)
     *                       - log_file: Path to log file (optional)
     * @param LoggerInterface|null $logger Custom logger.
     */
    public function __construct(
        string           $token,
        array            $options = [],
        ?LoggerInterface $logger = null
    )
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
     * Sends a request to the Telegram API using the selected HTTP client.
     *
     * @param string $method The API method to call (e.g., 'sendMessage').
     * @param array $params Parameters for the API method.
     * @return array The API response.
     * @throws Exception|GuzzleException If the request fails.
     */
    public function request(string $method, array $params = []): array
    {
        return $this->sendRequest($method, $params, false);
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
                    return $response;
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
                sleep(1);
            }
        }
    }

    /**
     * Sends a request using Guzzle.
     *
     * @param string $method The API method.
     * @param array $params Request parameters.
     * @return string The raw response.
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

    public function requestAsync(string $method, array $params = []): ?PromiseInterface
    {
        if ($this->httpClientType !== 'guzzle') {
            $this->logger->warning("Async requests are only supported with Guzzle.");
            return null;
        }
        return $this->sendRequest($method, $params, true);
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