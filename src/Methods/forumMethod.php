<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

trait forumMethod
{
    /**
     * Gets the list of custom emoji stickers for forum topic icons (synchronous).
     * Use this method to get all custom emoji stickers that can be used as forum topic icons.
     *
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing an array of Sticker objects (['ok' => true, 'result' => [Sticker]]).
     * @throws Exception|GuzzleException If the request fails.
     */
    public function getForumTopicIconStickers(array $options = []): array
    {
        return $this->request('getForumTopicIconStickers', $options);
    }

    /**
     * Gets the list of custom emoji stickers for forum topic icons (asynchronous).
     * Use this method to get all custom emoji stickers that can be used as forum topic icons in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getForumTopicIconStickersAsync(array $options = []): ?PromiseInterface
    {
        $promise = $this->requestAsync('getForumTopicIconStickers', $options);
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Creates a new forum topic (synchronous).
     * Use this method to create a topic in a forum supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param string $name Name of the topic, 1-128 characters.
     * @param array $options Optional parameters:
     *                       - icon_custom_emoji_id (string): Unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers.
     *                       - icon_color (int): Color of the topic icon in RGB format. Currently, must be one of 0x6FB9F0, 0xFFD67E, 0xCB86DB, 0x8EEE98, 0xFF93B2, or 0xFB6F5F.
     * @return array The response from Telegram containing the created ForumTopic object (['ok' => true, 'result' => ForumTopic]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function createForumTopic(int|string $chatId, string $name, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'name' => $name,
        ];

        return $this->request('createForumTopic', array_merge($params, $options));
    }

    /**
     * Creates a new forum topic (asynchronous).
     * Use this method to create a topic in a forum supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param string $name Name of the topic, 1-128 characters.
     * @param array $options Optional parameters:
     *                       - icon_custom_emoji_id (string): Unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers.
     *                       - icon_color (int): Color of the topic icon in RGB format. Currently, must be one of 0x6FB9F0, 0xFFD67E, 0xCB86DB, 0x8EEE98, 0xFF93B2, or 0xFB6F5F.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function createForumTopicAsync(int|string $chatId, string $name, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'name' => $name,
        ];

        $promise = $this->requestAsync('createForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Edits a forum topic (synchronous).
     * Use this method to edit the name and icon of a topic in a forum supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights, unless it is the creator of the topic.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters:
     *                       - name (string): New topic name, 0-128 characters. If not specified, the current name will be kept.
     *                       - icon_custom_emoji_id (string): New unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers. Pass an empty string to remove the icon.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editForumTopic(int|string $chatId, int $messageThreadId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        return $this->request('editForumTopic', array_merge($params, $options));
    }

    /**
     * Edits a forum topic (asynchronous).
     * Use this method to edit the name and icon of a topic in a forum supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters:
     *                       - name (string): New topic name, 0-128 characters. If not specified, the current name will be kept.
     *                       - icon_custom_emoji_id (string): New unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers. Pass an empty string to remove the icon.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editForumTopicAsync(int|string $chatId, int $messageThreadId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        $promise = $this->requestAsync('editForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Closes a forum topic (synchronous).
     * Use this method to close a forum topic in a supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function closeForumTopic(int|string $chatId, int $messageThreadId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        return $this->request('closeForumTopic', array_merge($params, $options));
    }

    /**
     * Closes a forum topic (asynchronous).
     * Use this method to close a forum topic in a supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function closeForumTopicAsync(int|string $chatId, int $messageThreadId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        $promise = $this->requestAsync('closeForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Reopens a forum topic (synchronous).
     * Use this method to reopen a closed forum topic in a supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function reopenForumTopic(int|string $chatId, int $messageThreadId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        return $this->request('reopenForumTopic', array_merge($params, $options));
    }

    /**
     * Reopens a forum topic (asynchronous).
     * Use this method to reopen a closed forum topic in a supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function reopenForumTopicAsync(int|string $chatId, int $messageThreadId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        $promise = $this->requestAsync('reopenForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Deletes a forum topic (synchronous).
     * Use this method to delete a forum topic along with all its messages in a supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function deleteForumTopic(int|string $chatId, int $messageThreadId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        return $this->request('deleteForumTopic', array_merge($params, $options));
    }

    /**
     * Deletes a forum topic (asynchronous).
     * Use this method to delete a forum topic along with all its messages in a supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function deleteForumTopicAsync(int|string $chatId, int $messageThreadId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        $promise = $this->requestAsync('deleteForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Unpins all messages in a forum topic (synchronous).
     * Use this method to unpin all pinned messages in a forum topic. The bot must be an administrator in the chat and must have the can_pin_messages administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function unpinAllForumTopicMessages(int|string $chatId, int $messageThreadId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        return $this->request('unpinAllForumTopicMessages', array_merge($params, $options));
    }

    /**
     * Unpins all messages in a forum topic (asynchronous).
     * Use this method to unpin all pinned messages in a forum topic in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $messageThreadId Unique identifier for the target message thread of the forum topic.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function unpinAllForumTopicMessagesAsync(int|string $chatId, int $messageThreadId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_thread_id' => $messageThreadId,
        ];

        $promise = $this->requestAsync('unpinAllForumTopicMessages', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Edits the general forum topic (synchronous).
     * Use this method to edit the name of the 'General' topic in a forum supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param string $name New name for the 'General' topic, 1-128 characters.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editGeneralForumTopic(int|string $chatId, string $name, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'name' => $name,
        ];

        return $this->request('editGeneralForumTopic', array_merge($params, $options));
    }

    /**
     * Edits the general forum topic (asynchronous).
     * Use this method to edit the name of the 'General' topic in a forum supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param string $name New name for the 'General' topic, 1-128 characters.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editGeneralForumTopicAsync(int|string $chatId, string $name, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'name' => $name,
        ];

        $promise = $this->requestAsync('editGeneralForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Closes the general forum topic (synchronous).
     * Use this method to close the 'General' topic in a forum supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function closeGeneralForumTopic(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('closeGeneralForumTopic', array_merge($params, $options));
    }

    /**
     * Closes the general forum topic (asynchronous).
     * Use this method to close the 'General' topic in a forum supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function closeGeneralForumTopicAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('closeGeneralForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Reopens the general forum topic (synchronous).
     * Use this method to reopen the 'General' topic in a forum supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function reopenGeneralForumTopic(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('reopenGeneralForumTopic', array_merge($params, $options));
    }

    /**
     * Reopens the general forum topic (asynchronous).
     * Use this method to reopen the 'General' topic in a forum supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function reopenGeneralForumTopicAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('reopenGeneralForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Hides the general forum topic (synchronous).
     * Use this method to hide the 'General' topic in a forum supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function hideGeneralForumTopic(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('hideGeneralForumTopic', array_merge($params, $options));
    }

    /**
     * Hides the general forum topic (asynchronous).
     * Use this method to hide the 'General' topic in a forum supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function hideGeneralForumTopicAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('hideGeneralForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Unhides the general forum topic (synchronous).
     * Use this method to unhide the 'General' topic in a forum supergroup chat. The bot must be an administrator in the chat and must have the can_manage_topics administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function unhideGeneralForumTopic(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('unhideGeneralForumTopic', array_merge($params, $options));
    }

    /**
     * Unhides the general forum topic (asynchronous).
     * Use this method to unhide the 'General' topic in a forum supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function unhideGeneralForumTopicAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('unhideGeneralForumTopic', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
    /**
     * Unpins all messages in the general forum topic (synchronous).
     * Use this method to unpin all pinned messages in the 'General' topic of a forum supergroup chat. The bot must be an administrator in the chat and must have the can_pin_messages administrator rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws \Exception If the request fails or required parameters are missing.
     */
    public function unpinAllGeneralForumTopicMessages(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('unpinAllGeneralForumTopicMessages', array_merge($params, $options));
    }

    /**
     * Unpins all messages in the general forum topic (asynchronous).
     * Use this method to unpin all pinned messages in the 'General' topic of a forum supergroup chat in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws \Exception If the request fails or required parameters are missing.
     */
    public function unpinAllGeneralForumTopicMessagesAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('unpinAllGeneralForumTopicMessages', array_merge($params, $options));
        if ($promise) {
            return $promise->then(function ($response) {
                return json_decode($response, true);
            });
        }
        return null;
    }
}