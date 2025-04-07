<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core;

use Exception;
/**
 * Exception thrown when a network-related error occurs during a Telegram API request.
 * This includes issues like connection timeouts, HTTP errors, or unreachable servers.
 */
class NetworkException extends Exception
{
    /** @var int|null HTTP status code associated with the error (if applicable) */
    protected ?int $httpCode;

    /** @var string|null Raw response body (if available) */
    protected ?string $rawResponse;

    /**
     * Constructs a new NetworkException.
     *
     * @param string $message Error message (e.g., "cURL error: Connection timed out").
     * @param int|null $httpCode HTTP status code (e.g., 500, 404), defaults to null.
     * @param string|null $rawResponse Raw response from the server, defaults to null.
     * @param Exception|null $previous Previous exception for chaining, defaults to null.
     */
    public function __construct(string $message, ?int $httpCode = null, ?string $rawResponse = null, ?Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->httpCode = $httpCode;
        $this->rawResponse = $rawResponse;
    }

    /**
     * Gets the HTTP status code associated with the error.
     *
     * @return int|null HTTP status code or null if not applicable.
     */
    public function getHttpCode(): ?int
    {
        return $this->httpCode;
    }

    /**
     * Gets the raw response body from the server.
     *
     * @return string|null Raw response or null if not available.
     */
    public function getRawResponse(): ?string
    {
        return $this->rawResponse;
    }
}