<?php

namespace Hosseinhunta\PhpTelegramBotApi\Updates;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Trait for handling Telegram Bot API update-related methods.
 * Provides methods to manage updates, webhooks, and webhook information.
 */
trait Update
{
    /**
     * Retrieves updates from Telegram (synchronous).
     * Use this method to get new updates via long polling.
     *
     * @param array $params Optional parameters for getUpdates.
     *                      - offset (int): Identifier of the first update to be returned.
     *                      - limit (int): Limits the number of updates to be retrieved (1-100).
     *                      - timeout (int): Timeout in seconds for long polling.
     *                      - allowed_updates (array): List of update types to receive.
     * @return TelegramUpdate[] Array of TelegramUpdate objects.
     * @throws Exception|GuzzleException If the request fails.
     */
    public function getUpdates(array $params = []): array
    {
        $response = $this->request('getUpdates', $params);
        $updates = $response['result'] ?? [];
        return array_map(fn($update) => new TelegramUpdate($update), $updates);
    }

    /**
     * Retrieves updates from Telegram (asynchronous).
     * Use this method to get new updates via long polling in an async manner (Guzzle only).
     *
     * @param array $params Optional parameters for getUpdates.
     *                      - offset (int): Identifier of the first update to be returned.
     *                      - limit (int): Limits the number of updates to be retrieved (1-100).
     *                      - timeout (int): Timeout in seconds for long polling.
     *                      - allowed_updates (array): List of update types to receive.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     */
    public function getUpdatesAsync(array $params = []): ?PromiseInterface
    {
        $promise = $this->requestAsync('getUpdates', $params);
        return $promise?->then(function ($response) {
            $response = json_decode($response, true);
            $updates = $response['result'] ?? [];
            return array_map(fn($update) => new TelegramUpdate($update), $updates);
        });
    }

    /**
     * Sets a webhook to receive updates via HTTP.
     * Use this method to specify a URL for Telegram to send updates to.
     *
     * @param array $params Parameters for setWebhook.
     *                      - url (string, required): HTTPS URL to send updates to.
     *                      - certificate (string, optional): Path to a public key certificate.
     *                      - max_connections (int, optional): Maximum allowed number of simultaneous HTTPS connections (1-100).
     *                      - allowed_updates (array, optional): List of update types to receive.
     * @return array The response from Telegram.
     * @throws Exception|GuzzleException If the request fails or if the 'url' parameter is missing.
     */
    public function setWebhook(array $params = []): array
    {
        if (empty($params['url'])) {
            throw new Exception("The 'url' parameter is required for setWebhook.");
        }

        return $this->request('setWebhook', $params);
    }

    /**
     * Deletes the current webhook.
     * Use this method to remove the webhook and switch back to getUpdates.
     *
     * @param array $params Optional parameters for deleteWebhook.
     *                      - drop_pending_updates (bool, optional): Pass true to drop all pending updates.
     * @return array The response from Telegram.
     * @throws Exception|GuzzleException If the request fails.
     */
    public function deleteWebhook(array $params = []): array
    {
        return $this->request('deleteWebhook', $params);
    }

    /**
     * Retrieves information about the current webhook.
     * Use this method to get details about the currently set webhook.
     *
     * @return array The response containing webhook info.
     * @throws Exception|GuzzleException If the request fails.
     */
    public function getWebhookInfo(): array
    {
        return $this->request('getWebhookInfo');
    }
}