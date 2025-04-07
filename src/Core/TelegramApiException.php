<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core;

use Exception;
class TelegramApiException extends Exception
{
    protected int $errorCode;
    protected string $description;

    public function __construct(string $message, int $errorCode = 0, string $description = '')
    {
        parent::__construct($message);
        $this->errorCode = $errorCode;
        $this->description = $description;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}