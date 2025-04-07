<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

trait giftMethod
{
    /**
     * Gets the list of available gifts (synchronous).
     * Use this method to retrieve all gifts that can be sent by the bot.
     *
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing an array of Gift objects (['ok' => true, 'result' => [Gift]]).
     * @throws Exception|GuzzleException If the request fails.
     */
    public function getAvailableGifts(array $options = []): array
    {
        return $this->request('getAvailableGifts', $options);
    }

    /**
     * Gets the list of available gifts (asynchronous).
     * Use this method to retrieve all gifts that can be sent by the bot in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getAvailableGiftsAsync(array $options = []): ?PromiseInterface
    {
        $promise = $this->requestAsync('getAvailableGifts', $options);
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a gift to a user or chat (synchronous).
     * Use this method to send a gift to a user or a channel chat. The gift cannot be converted to Telegram Stars by the receiver.
     *
     * @param string $giftId Unique identifier of the gift to send.
     * @param int|null $userId Unique identifier of the target user who will receive the gift. Required if chat_id is not specified.
     * @param int|string|null $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername). Required if user_id is not specified.
     * @param array $options Optional parameters:
     *                       - pay_for_upgrade (bool): Pass true to pay for the gift upgrade from the bot’s balance, making the upgrade free for the receiver.
     *                       - text (string): Optional text message to send with the gift.
     *                       - text_parse_mode (string): Mode for parsing entities in the text (e.g., 'Markdown', 'HTML').
     *                       - text_entities (array): List of special entities in the text (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendGift(string $giftId, ?int $userId = null, int|string|null $chatId = null, array $options = []): array
    {
        if (!$userId && !$chatId) {
            throw new Exception('Either user_id or chat_id must be specified.');
        }

        $params = [
            'gift_id' => $giftId,
        ];

        if ($userId) {
            $params['user_id'] = $userId;
        }
        if ($chatId) {
            $params['chat_id'] = $chatId;
        }
        if (isset($options['text_entities'])) {
            $params['text_entities'] = json_encode($options['text_entities']);
        }

        return $this->request('sendGift', array_merge($params, $options));
    }

    /**
     * Sends a gift to a user or chat (asynchronous).
     * Use this method to send a gift to a user or a channel chat in an async manner (Guzzle only).
     *
     * @param string $giftId Unique identifier of the gift to send.
     * @param int|null $userId Unique identifier of the target user who will receive the gift. Required if chat_id is not specified.
     * @param int|string|null $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername). Required if user_id is not specified.
     * @param array $options Optional parameters:
     *                       - pay_for_upgrade (bool): Pass true to pay for the gift upgrade from the bot’s balance, making the upgrade free for the receiver.
     *                       - text (string): Optional text message to send with the gift.
     *                       - text_parse_mode (string): Mode for parsing entities in the text (e.g., 'Markdown', 'HTML').
     *                       - text_entities (array): List of special entities in the text (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendGiftAsync(string $giftId, ?int $userId = null, int|string|null $chatId = null, array $options = []): ?PromiseInterface
    {
        if (!$userId && !$chatId) {
            throw new Exception('Either user_id or chat_id must be specified.');
        }

        $params = [
            'gift_id' => $giftId,
        ];

        if ($userId) {
            $params['user_id'] = $userId;
        }
        if ($chatId) {
            $params['chat_id'] = $chatId;
        }
        if (isset($options['text_entities'])) {
            $params['text_entities'] = json_encode($options['text_entities']);
        }

        $promise = $this->requestAsync('sendGift', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}