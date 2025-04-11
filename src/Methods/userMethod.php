<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

trait userMethod
{
    /**
     * Sets the emoji status for a user (synchronous).
     * Use this method to set a custom emoji status for a user, which will be displayed next to their name.
     *
     * @param int $userId Unique identifier of the target user.
     * @param string $customEmojiId Unique identifier of the custom emoji to set as the user's status.
     * @param array $options Optional parameters:
     *                       - until (int): Unix timestamp when the emoji status will expire. If not specified, the status remains until manually changed.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setUserEmojiStatus(int $userId, string $customEmojiId, array $options = []): array
    {
        $params = [
            'user_id' => $userId,
            'custom_emoji_id' => $customEmojiId,
        ];

        return $this->request('setUserEmojiStatus', array_merge($params, $options));
    }

    /**
     * Sets the emoji status for a user (asynchronous).
     * Use this method to set a custom emoji status for a user in an async manner (Guzzle only).
     *
     * @param int $userId Unique identifier of the target user.
     * @param string $customEmojiId Unique identifier of the custom emoji to set as the user's status.
     * @param array $options Optional parameters:
     *                       - until (int): Unix timestamp when the emoji status will expire. If not specified, the status remains until manually changed.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setUserEmojiStatusAsync(int $userId, string $customEmojiId, array $options = []): ?PromiseInterface
    {
        $params = [
            'user_id' => $userId,
            'custom_emoji_id' => $customEmojiId,
        ];

        $promise = $this->requestAsync('setUserEmojiStatus', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets a user's profile photos (synchronous).
     * Use this method to retrieve the list of profile photos for a user.
     *
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - offset (int): Sequential number of the first photo to be returned; defaults to 0.
     *                       - limit (int): Limits the number of photos to be retrieved; 1-100, defaults to 100.
     * @return array The response from Telegram containing a UserProfilePhotos object (['ok' => true, 'result' => UserProfilePhotos]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getUserProfilePhotos(int $userId, array $options = []): array
    {
        $params = [
            'user_id' => $userId,
        ];

        return $this->request('getUserProfilePhotos', array_merge($params, $options));
    }

    /**
     * Gets a user's profile photos (asynchronous).
     * Use this method to retrieve the list of profile photos for a user in an async manner (Guzzle only).
     *
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - offset (int): Sequential number of the first photo to be returned; defaults to 0.
     *                       - limit (int): Limits the number of photos to be retrieved; 1-100, defaults to 100.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getUserProfilePhotosAsync(int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('getUserProfilePhotos', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}