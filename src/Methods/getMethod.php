<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Trait for handling Telegram Bot API get-related methods.
 * Provides methods to retrieve information such as user profiles, chats, files, and more.
 * Based on Telegram Bot API version 7.3.
 */
trait getMethod
{
    /**
     * Gets information about a file (synchronous).
     * Use this method to get basic info about a file and prepare it for downloading. For the moment, bots can download files of up to 20MB in size.
     *
     * @param string $fileId File identifier to get info about.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the File object (['ok' => true, 'result' => File]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getFile(string $fileId, array $options = []): array
    {
        $params = [
            'file_id' => $fileId,
        ];

        return $this->request('getFile', array_merge($params, $options));
    }

    /**
     * Gets information about a file (asynchronous).
     * Use this method to get basic info about a file and prepare it for downloading in an async manner (Guzzle only).
     *
     * @param string $fileId File identifier to get info about.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getFileAsync(string $fileId, array $options = []): ?PromiseInterface
    {
        $params = [
            'file_id' => $fileId,
        ];

        $promise = $this->requestAsync('getFile', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets information about a chat (synchronous).
     * Use this method to get up-to-date information about a chat (like a private chat, group, supergroup, or channel).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the Chat object (['ok' => true, 'result' => Chat]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getChat(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('getChat', array_merge($params, $options));
    }

    /**
     * Gets information about a chat (asynchronous).
     * Use this method to get up-to-date information about a chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getChatAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('getChat', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the list of administrators in a chat (synchronous).
     * Use this method to get a list of administrators in a chat, including bots and users.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing an array of ChatMember objects (['ok' => true, 'result' => [ChatMember]]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getChatAdministrators(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('getChatAdministrators', array_merge($params, $options));
    }

    /**
     * Gets the list of administrators in a chat (asynchronous).
     * Use this method to get a list of administrators in a chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getChatAdministratorsAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('getChatAdministrators', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the number of members in a chat (synchronous).
     * Use this method to get the number of members in a chat.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the member count (['ok' => true, 'result' => int]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getChatMemberCount(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('getChatMemberCount', array_merge($params, $options));
    }

    /**
     * Gets the number of members in a chat (asynchronous).
     * Use this method to get the number of members in a chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getChatMemberCountAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('getChatMemberCount', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets information about a chat member (synchronous).
     * Use this method to get information about a member of a chat. The bot must be an administrator in the chat or have appropriate permissions.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the ChatMember object (['ok' => true, 'result' => ChatMember]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getChatMember(int|string $chatId, int $userId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        return $this->request('getChatMember', array_merge($params, $options));
    }

    /**
     * Gets information about a chat member (asynchronous).
     * Use this method to get information about a member of a chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getChatMemberAsync(int|string $chatId, int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('getChatMember', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the list of boosts applied to a chat by a user (synchronous).
     * Use this method to get the list of boosts added to a chat by a specific user.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the ChatBoost objects (['ok' => true, 'result' => ChatBoost]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getUserChatBoosts(int|string $chatId, int $userId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        return $this->request('getUserChatBoosts', array_merge($params, $options));
    }

    /**
     * Gets the list of boosts applied to a chat by a user (asynchronous).
     * Use this method to get the list of boosts added to a chat by a specific user in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getUserChatBoostsAsync(int|string $chatId, int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('getUserChatBoosts', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the current business connection (synchronous).
     * Use this method to get information about the connection of the bot with a business account.
     *
     * @param string $businessConnectionId Unique identifier of the business connection.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the BusinessConnection object (['ok' => true, 'result' => BusinessConnection]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getBusinessConnection(string $businessConnectionId, array $options = []): array
    {
        $params = [
            'business_connection_id' => $businessConnectionId,
        ];

        return $this->request('getBusinessConnection', array_merge($params, $options));
    }

    /**
     * Gets the current business connection (asynchronous).
     * Use this method to get information about the connection of the bot with a business account in an async manner (Guzzle only).
     *
     * @param string $businessConnectionId Unique identifier of the business connection.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getBusinessConnectionAsync(string $businessConnectionId, array $options = []): ?PromiseInterface
    {
        $params = [
            'business_connection_id' => $businessConnectionId,
        ];

        $promise = $this->requestAsync('getBusinessConnection', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}