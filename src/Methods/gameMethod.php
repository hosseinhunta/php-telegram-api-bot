<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Trait for handling Telegram Bot API game-related methods.
 * Provides methods to send and manage games within Telegram chats.
 * Based on Telegram Bot API version 7.3.
 */
trait gameMethod
{
    /**
     * Sends a game (synchronous).
     * Use this method to send a game to a chat.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $gameShortName Short name of the game (e.g., 'MyGame').
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) of the forum.
     *                       - disable_notification (bool): Pass true to send the message silently. Defaults to false.
     *                       - protect_content (bool): Pass true to protect the content from forwarding and saving. Defaults to false.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => int]).
     *                       - reply_markup (array): Inline keyboard markup for the game message.
     *                       - business_connection_id (string): Unique identifier of the business connection.
     * @return array The response from Telegram containing the sent Message object with the game (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendGame(int|string $chatId, string $gameShortName, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'game_short_name' => $gameShortName,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }

        return $this->request('sendGame', array_merge($params, $options));
    }

    /**
     * Sends a game (asynchronous).
     * Use this method to send a game to a chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $gameShortName Short name of the game (e.g., 'MyGame').
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) of the forum.
     *                       - disable_notification (bool): Pass true to send the message silently. Defaults to false.
     *                       - protect_content (bool): Pass true to protect the content from forwarding and saving. Defaults to false.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => int]).
     *                       - reply_markup (array): Inline keyboard markup for the game message.
     *                       - business_connection_id (string): Unique identifier of the business connection.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function sendGameAsync(int|string $chatId, string $gameShortName, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'game_short_name' => $gameShortName,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }

        $promise = $this->requestAsync('sendGame', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the score for a game (synchronous).
     * Use this method to set a user's score in a game.
     *
     * @param int $userId Unique identifier of the target user.
     * @param int $score New score, must be non-negative.
     * @param array $options Optional parameters:
     *                       - chat_id (int|string): Required if inline_message_id is not specified. Unique identifier for the target chat.
     *                       - message_id (int): Required if inline_message_id is not specified. Identifier of the sent game message.
     *                       - inline_message_id (string): Required if chat_id and message_id are not specified. Identifier of the inline message.
     *                       - force (bool): Pass true to set the score even if it decreases the previous score. Defaults to false.
     *                       - disable_edit_message (bool): Pass true to prevent the game message from being edited. Defaults to false.
     * @return array The response from Telegram containing the edited Message object (['ok' => true, 'result' => Message]), or true for inline messages.
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setGameScore(int $userId, int $score, array $options = []): array
    {
        if ($score < 0) {
            throw new Exception('Score must be non-negative.');
        }

        $params = [
            'user_id' => $userId,
            'score' => $score,
        ];

        if (!isset($options['inline_message_id']) && (!isset($options['chat_id']) || !isset($options['message_id']))) {
            throw new Exception('Either inline_message_id or both chat_id and message_id must be specified.');
        }

        return $this->request('setGameScore', array_merge($params, $options));
    }

    /**
     * Sets the score for a game (asynchronous).
     * Use this method to set a user's score in a game in an async manner (Guzzle only).
     *
     * @param int $userId Unique identifier of the target user.
     * @param int $score New score, must be non-negative.
     * @param array $options Optional parameters:
     *                       - chat_id (int|string): Required if inline_message_id is not specified. Unique identifier for the target chat.
     *                       - message_id (int): Required if inline_message_id is not specified. Identifier of the sent game message.
     *                       - inline_message_id (string): Required if chat_id and message_id are not specified. Identifier of the inline message.
     *                       - force (bool): Pass true to set the score even if it decreases the previous score. Defaults to false.
     *                       - disable_edit_message (bool): Pass true to prevent the game message from being edited. Defaults to false.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setGameScoreAsync(int $userId, int $score, array $options = []): ?PromiseInterface
    {
        if ($score < 0) {
            throw new Exception('Score must be non-negative.');
        }

        $params = [
            'user_id' => $userId,
            'score' => $score,
        ];

        if (!isset($options['inline_message_id']) && (!isset($options['chat_id']) || !isset($options['message_id']))) {
            throw new Exception('Either inline_message_id or both chat_id and message_id must be specified.');
        }

        $promise = $this->requestAsync('setGameScore', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets high scores for a game (synchronous).
     * Use this method to retrieve the high scores for a game.
     *
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - chat_id (int|string): Required if inline_message_id is not specified. Unique identifier for the target chat.
     *                       - message_id (int): Required if inline_message_id is not specified. Identifier of the sent game message.
     *                       - inline_message_id (string): Required if chat_id and message_id are not specified. Identifier of the inline message.
     * @return array The response from Telegram containing an array of GameHighScore objects (['ok' => true, 'result' => [GameHighScore]]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getGameHighScores(int $userId, array $options = []): array
    {
        $params = [
            'user_id' => $userId,
        ];

        if (!isset($options['inline_message_id']) && (!isset($options['chat_id']) || !isset($options['message_id']))) {
            throw new Exception('Either inline_message_id or both chat_id and message_id must be specified.');
        }

        return $this->request('getGameHighScores', array_merge($params, $options));
    }

    /**
     * Gets high scores for a game (asynchronous).
     * Use this method to retrieve the high scores for a game in an async manner (Guzzle only).
     *
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - chat_id (int|string): Required if inline_message_id is not specified. Unique identifier for the target chat.
     *                       - message_id (int): Required if inline_message_id is not specified. Identifier of the sent game message.
     *                       - inline_message_id (string): Required if chat_id and message_id are not specified. Identifier of the inline message.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getGameHighScoresAsync(int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'user_id' => $userId,
        ];

        if (!isset($options['inline_message_id']) && (!isset($options['chat_id']) || !isset($options['message_id']))) {
            throw new Exception('Either inline_message_id or both chat_id and message_id must be specified.');
        }

        $promise = $this->requestAsync('getGameHighScores', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}