<?php

namespace Hosseinhunta\PhpTelegramBotApi\Core;

interface MiddlewareInterface
{
    /**
     * Process the request and response
     * @param string $method Telegram API method
     * @param array $params Request parameters
     * @param callable $next Next middleware or final handler
     * @return mixed Response from the API or modified response
     */
    public function handle(string $method, array $params, callable $next);
}