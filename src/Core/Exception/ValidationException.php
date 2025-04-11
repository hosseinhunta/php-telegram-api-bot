<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core\Exception;

use Exception;

/**
 * Exception thrown when validation of parameters fails before sending a Telegram API request.
 * This includes cases like missing required parameters or invalid data formats.
 */
class ValidationException extends Exception
{
    /** @var string|null Name of the parameter that caused the validation failure */
    protected ?string $parameter;

    /**
     * Constructs a new ValidationException.
     *
     * @param string $message Error message (e.g., "Parameter 'chat_id' is required.").
     * @param string|null $parameter Name of the invalid parameter, defaults to null.
     * @param Exception|null $previous Previous exception for chaining, defaults to null.
     */
    public function __construct(string $message, ?string $parameter = null, ?Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->parameter = $parameter;
    }

    /**
     * Gets the name of the parameter that caused the validation failure.
     *
     * @return string|null Parameter name or null if not specified.
     */
    public function getParameter(): ?string
    {
        return $this->parameter;
    }
}