<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Trait for handling Telegram Bot API sticker-related methods.
 * Provides methods to manage stickers, sticker sets, and sticker masks.
 * Based on Telegram Bot API version 7.3.
 */
trait stickerMethod
{
    /**
     * Sends a sticker (synchronous).
     * Use this method to send static, animated, or video stickers.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $sticker Sticker to send (file_id, HTTP URL, or file path for upload).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) of the forum.
     *                       - emoji (string): Emoji associated with the sticker; 1-2 characters.
     *                       - disable_notification (bool): Pass true to send the sticker silently. Defaults to false.
     *                       - protect_content (bool): Pass true to protect the sticker from being forwarded or saved. Defaults to false.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => int]).
     *                       - reply_markup (array): Inline keyboard, custom reply keyboard, or other markup.
     *                       - business_connection_id (string): Unique identifier of the business connection.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendSticker(int|string $chatId, string $sticker, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'sticker' => $sticker,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }

        return $this->request('sendSticker', array_merge($params, $options));
    }

    /**
     * Sends a sticker (asynchronous).
     * Use this method to send static, animated, or video stickers in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $sticker Sticker to send (file_id, HTTP URL, or file path for upload).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) of the forum.
     *                       - emoji (string): Emoji associated with the sticker; 1-2 characters.
     *                       - disable_notification (bool): Pass true to send the sticker silently. Defaults to false.
     *                       - protect_content (bool): Pass true to protect the sticker from being forwarded or saved. Defaults to false.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => int]).
     *                       - reply_markup (array): Inline keyboard, custom reply keyboard, or other markup.
     *                       - business_connection_id (string): Unique identifier of the business connection.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function sendStickerAsync(int|string $chatId, string $sticker, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'sticker' => $sticker,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }

        $promise = $this->requestAsync('sendSticker', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets a sticker set (synchronous).
     * Use this method to get a sticker set by its name.
     *
     * @param string $name Name of the sticker set.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the StickerSet object (['ok' => true, 'result' => StickerSet]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getStickerSet(string $name, array $options = []): array
    {
        $params = [
            'name' => $name,
        ];

        return $this->request('getStickerSet', array_merge($params, $options));
    }

    /**
     * Gets a sticker set (asynchronous).
     * Use this method to get a sticker set by its name in an async manner (Guzzle only).
     *
     * @param string $name Name of the sticker set.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getStickerSetAsync(string $name, array $options = []): ?PromiseInterface
    {
        $params = [
            'name' => $name,
        ];

        $promise = $this->requestAsync('getStickerSet', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets information about custom emoji stickers (synchronous).
     * Use this method to get information about custom emoji stickers by their identifiers.
     *
     * @param array $customEmojiIds List of custom emoji identifiers.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing an array of Sticker objects (['ok' => true, 'result' => [Sticker]]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getCustomEmojiStickers(array $customEmojiIds, array $options = []): array
    {
        $params = [
            'custom_emoji_ids' => json_encode($customEmojiIds),
        ];

        return $this->request('getCustomEmojiStickers', array_merge($params, $options));
    }

    /**
     * Gets information about custom emoji stickers (asynchronous).
     * Use this method to get information about custom emoji stickers by their identifiers in an async manner (Guzzle only).
     *
     * @param array $customEmojiIds List of custom emoji identifiers.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getCustomEmojiStickersAsync(array $customEmojiIds, array $options = []): ?PromiseInterface
    {
        $params = [
            'custom_emoji_ids' => json_encode($customEmojiIds),
        ];

        $promise = $this->requestAsync('getCustomEmojiStickers', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Uploads a sticker file (synchronous).
     * Use this method to upload a file for a sticker; the file must be in PNG, WEBP, or TGS format depending on the sticker type.
     *
     * @param int $userId User identifier of the sticker set owner.
     * @param string $sticker Path to the sticker file (PNG, WEBP, or TGS).
     * @param string $stickerFormat Format of the sticker ('static', 'animated', or 'video').
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the uploaded File object (['ok' => true, 'result' => File]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function uploadStickerFile(int $userId, string $sticker, string $stickerFormat, array $options = []): array
    {
        $params = [
            'user_id' => $userId,
            'sticker' => $sticker,
            'sticker_format' => $stickerFormat,
        ];

        return $this->request('uploadStickerFile', array_merge($params, $options));
    }

    /**
     * Uploads a sticker file (asynchronous).
     * Use this method to upload a file for a sticker in an async manner (Guzzle only); the file must be in PNG, WEBP, or TGS format depending on the sticker type.
     *
     * @param int $userId User identifier of the sticker set owner.
     * @param string $sticker Path to the sticker file (PNG, WEBP, or TGS).
     * @param string $stickerFormat Format of the sticker ('static', 'animated', or 'video').
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function uploadStickerFileAsync(int $userId, string $sticker, string $stickerFormat, array $options = []): ?PromiseInterface
    {
        $params = [
            'user_id' => $userId,
            'sticker' => $sticker,
            'sticker_format' => $stickerFormat,
        ];

        $promise = $this->requestAsync('uploadStickerFile', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Creates a new sticker set (synchronous).
     * Use this method to create a new sticker set owned by a user.
     *
     * @param int $userId User identifier of the sticker set owner.
     * @param string $name Short name of the sticker set, to be used in t.me/addstickers/ URLs (e.g., 'myPack').
     * @param string $title Sticker set title, 1-64 characters.
     * @param array $stickers List of stickers to add (each sticker must be an array with 'sticker' (file_id or uploaded file) and 'emoji_list' (array of emojis)).
     * @param string $stickerFormat Format of stickers in the set ('static', 'animated', or 'video').
     * @param array $options Optional parameters:
     *                       - sticker_type (string): Type of stickers ('regular', 'mask', or 'custom_emoji'). Defaults to 'regular'.
     *                       - needs_repainting (bool): Pass true if stickers need to be repainted (for mask stickers). Defaults to false.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function createNewStickerSet(int $userId, string $name, string $title, array $stickers, string $stickerFormat, array $options = []): array
    {
        $params = [
            'user_id' => $userId,
            'name' => $name,
            'title' => $title,
            'stickers' => json_encode($stickers),
            'sticker_format' => $stickerFormat,
        ];

        return $this->request('createNewStickerSet', array_merge($params, $options));
    }

    /**
     * Creates a new sticker set (asynchronous).
     * Use this method to create a new sticker set owned by a user in an async manner (Guzzle only).
     *
     * @param int $userId User identifier of the sticker set owner.
     * @param string $name Short name of the sticker set, to be used in t.me/addstickers/ URLs (e.g., 'myPack').
     * @param string $title Sticker set title, 1-64 characters.
     * @param array $stickers List of stickers to add (each sticker must be an array with 'sticker' (file_id or uploaded file) and 'emoji_list' (array of emojis)).
     * @param string $stickerFormat Format of stickers in the set ('static', 'animated', or 'video').
     * @param array $options Optional parameters:
     *                       - sticker_type (string): Type of stickers ('regular', 'mask', or 'custom_emoji'). Defaults to 'regular'.
     *                       - needs_repainting (bool): Pass true if stickers need to be repainted (for mask stickers). Defaults to false.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function createNewStickerSetAsync(int $userId, string $name, string $title, array $stickers, string $stickerFormat, array $options = []): ?PromiseInterface
    {
        $params = [
            'user_id' => $userId,
            'name' => $name,
            'title' => $title,
            'stickers' => json_encode($stickers),
            'sticker_format' => $stickerFormat,
        ];

        $promise = $this->requestAsync('createNewStickerSet', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Adds a sticker to a set (synchronous).
     * Use this method to add a new sticker to a set created by the bot.
     *
     * @param int $userId User identifier of the sticker set owner.
     * @param string $name Short name of the sticker set.
     * @param array $sticker Sticker to add (an array with 'sticker' (file_id or uploaded file) and 'emoji_list' (array of emojis)).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function addStickerToSet(int $userId, string $name, array $sticker, array $options = []): array
    {
        $params = [
            'user_id' => $userId,
            'name' => $name,
            'sticker' => json_encode($sticker),
        ];

        return $this->request('addStickerToSet', array_merge($params, $options));
    }

    /**
     * Adds a sticker to a set (asynchronous).
     * Use this method to add a new sticker to a set created by the bot in an async manner (Guzzle only).
     *
     * @param int $userId User identifier of the sticker set owner.
     * @param string $name Short name of the sticker set.
     * @param array $sticker Sticker to add (an array with 'sticker' (file_id or uploaded file) and 'emoji_list' (array of emojis)).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function addStickerToSetAsync(int $userId, string $name, array $sticker, array $options = []): ?PromiseInterface
    {
        $params = [
            'user_id' => $userId,
            'name' => $name,
            'sticker' => json_encode($sticker),
        ];

        $promise = $this->requestAsync('addStickerToSet', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Moves a sticker in a set (synchronous).
     * Use this method to move a sticker in a set created by the bot to a specific position.
     *
     * @param string $sticker File identifier of the sticker.
     * @param int $position New position in the set, zero-based.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setStickerPositionInSet(string $sticker, int $position, array $options = []): array
    {
        $params = [
            'sticker' => $sticker,
            'position' => $position,
        ];

        return $this->request('setStickerPositionInSet', array_merge($params, $options));
    }

    /**
     * Moves a sticker in a set (asynchronous).
     * Use this method to move a sticker in a set created by the bot to a specific position in an async manner (Guzzle only).
     *
     * @param string $sticker File identifier of the sticker.
     * @param int $position New position in the set, zero-based.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setStickerPositionInSetAsync(string $sticker, int $position, array $options = []): ?PromiseInterface
    {
        $params = [
            'sticker' => $sticker,
            'position' => $position,
        ];

        $promise = $this->requestAsync('setStickerPositionInSet', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Deletes a sticker from a set (synchronous).
     * Use this method to delete a sticker from a set created by the bot.
     *
     * @param string $sticker File identifier of the sticker.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function deleteStickerFromSet(string $sticker, array $options = []): array
    {
        $params = [
            'sticker' => $sticker,
        ];

        return $this->request('deleteStickerFromSet', array_merge($params, $options));
    }

    /**
     * Deletes a sticker from a set (asynchronous).
     * Use this method to delete a sticker from a set created by the bot in an async manner (Guzzle only).
     *
     * @param string $sticker File identifier of the sticker.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function deleteStickerFromSetAsync(string $sticker, array $options = []): ?PromiseInterface
    {
        $params = [
            'sticker' => $sticker,
        ];

        $promise = $this->requestAsync('deleteStickerFromSet', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Replaces an existing sticker in a set (synchronous).
     * Use this method to replace an existing sticker in a sticker set with a new one.
     *
     * @param int $userId User identifier of the sticker set owner.
     * @param string $name Short name of the sticker set.
     * @param string $oldSticker File identifier of the sticker to replace.
     * @param array $sticker New sticker data (an array with 'sticker' (file_id or uploaded file) and 'emoji_list' (array of emojis)).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function replaceStickerInSet(int $userId, string $name, string $oldSticker, array $sticker, array $options = []): array
    {
        $params = [
            'user_id' => $userId,
            'name' => $name,
            'old_sticker' => $oldSticker,
            'sticker' => json_encode($sticker),
        ];

        return $this->request('replaceStickerInSet', array_merge($params, $options));
    }

    /**
     * Replaces an existing sticker in a set (asynchronous).
     * Use this method to replace an existing sticker in a sticker set with a new one in an async manner (Guzzle only).
     *
     * @param int $userId User identifier of the sticker set owner.
     * @param string $name Short name of the sticker set.
     * @param string $oldSticker File identifier of the sticker to replace.
     * @param array $sticker New sticker data (an array with 'sticker' (file_id or uploaded file) and 'emoji_list' (array of emojis)).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function replaceStickerInSetAsync(int $userId, string $name, string $oldSticker, array $sticker, array $options = []): ?PromiseInterface
    {
        $params = [
            'user_id' => $userId,
            'name' => $name,
            'old_sticker' => $oldSticker,
            'sticker' => json_encode($sticker),
        ];

        $promise = $this->requestAsync('replaceStickerInSet', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the thumbnail of a sticker set (synchronous).
     * Use this method to set the thumbnail of a sticker set.
     *
     * @param string $name Short name of the sticker set.
     * @param int $userId User identifier of the sticker set owner.
     * @param string|null $thumbnail Path to the thumbnail file (PNG, WEBP, or TGS) or null to remove the thumbnail.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setStickerSetThumbnail(string $name, int $userId, ?string $thumbnail = null, array $options = []): array
    {
        $params = [
            'name' => $name,
            'user_id' => $userId,
        ];
        if ($thumbnail !== null) {
            $params['thumbnail'] = $thumbnail;
        }

        return $this->request('setStickerSetThumbnail', array_merge($params, $options));
    }

    /**
     * Sets the thumbnail of a sticker set (asynchronous).
     * Use this method to set the thumbnail of a sticker set in an async manner (Guzzle only).
     *
     * @param string $name Short name of the sticker set.
     * @param int $userId User identifier of the sticker set owner.
     * @param string|null $thumbnail Path to the thumbnail file (PNG, WEBP, or TGS) or null to remove the thumbnail.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setStickerSetThumbnailAsync(string $name, int $userId, ?string $thumbnail = null, array $options = []): ?PromiseInterface
    {
        $params = [
            'name' => $name,
            'user_id' => $userId,
        ];
        if ($thumbnail !== null) {
            $params['thumbnail'] = $thumbnail;
        }

        $promise = $this->requestAsync('setStickerSetThumbnail', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the title of a sticker set (synchronous).
     * Use this method to set the title of a sticker set created by the bot.
     *
     * @param string $name Short name of the sticker set.
     * @param string $title New sticker set title, 1-64 characters.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setStickerSetTitle(string $name, string $title, array $options = []): array
    {
        $params = [
            'name' => $name,
            'title' => $title,
        ];

        return $this->request('setStickerSetTitle', array_merge($params, $options));
    }

    /**
     * Sets the title of a sticker set (asynchronous).
     * Use this method to set the title of a sticker set created by the bot in an async manner (Guzzle only).
     *
     * @param string $name Short name of the sticker set.
     * @param string $title New sticker set title, 1-64 characters.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setStickerSetTitleAsync(string $name, string $title, array $options = []): ?PromiseInterface
    {
        $params = [
            'name' => $name,
            'title' => $title,
        ];

        $promise = $this->requestAsync('setStickerSetTitle', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Deletes a sticker set (synchronous).
     * Use this method to delete a sticker set created by the bot.
     *
     * @param string $name Short name of the sticker set.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function deleteStickerSet(string $name, array $options = []): array
    {
        $params = [
            'name' => $name,
        ];

        return $this->request('deleteStickerSet', array_merge($params, $options));
    }

    /**
     * Deletes a sticker set (asynchronous).
     * Use this method to delete a sticker set created by the bot in an async manner (Guzzle only).
     *
     * @param string $name Short name of the sticker set.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function deleteStickerSetAsync(string $name, array $options = []): ?PromiseInterface
    {
        $params = [
            'name' => $name,
        ];

        $promise = $this->requestAsync('deleteStickerSet', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the emojis for a sticker (synchronous).
     * Use this method to change the list of emojis associated with a sticker.
     *
     * @param string $sticker File identifier of the sticker.
     * @param array $emojiList List of 1-2 emoji associated with the sticker.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setStickerEmojiList(string $sticker, array $emojiList, array $options = []): array
    {
        $params = [
            'sticker' => $sticker,
            'emoji_list' => json_encode($emojiList),
        ];

        return $this->request('setStickerEmojiList', array_merge($params, $options));
    }

    /**
     * Sets the emojis for a sticker (asynchronous).
     * Use this method to change the list of emojis associated with a sticker in an async manner (Guzzle only).
     *
     * @param string $sticker File identifier of the sticker.
     * @param array $emojiList List of 1-2 emoji associated with the sticker.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setStickerEmojiListAsync(string $sticker, array $emojiList, array $options = []): ?PromiseInterface
    {
        $params = [
            'sticker' => $sticker,
            'emoji_list' => json_encode($emojiList),
        ];

        $promise = $this->requestAsync('setStickerEmojiList', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the keywords for a sticker (synchronous).
     * Use this method to set the keywords for a sticker to improve searchability.
     *
     * @param string $sticker File identifier of the sticker.
     * @param array $keywords List of 0-20 keywords associated with the sticker (each 1-64 characters).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setStickerKeywords(string $sticker, array $keywords, array $options = []): array
    {
        $params = [
            'sticker' => $sticker,
            'keywords' => json_encode($keywords),
        ];

        return $this->request('setStickerKeywords', array_merge($params, $options));
    }

    /**
     * Sets the keywords for a sticker (asynchronous).
     * Use this method to set the keywords for a sticker to improve searchability in an async manner (Guzzle only).
     *
     * @param string $sticker File identifier of the sticker.
     * @param array $keywords List of 0-20 keywords associated with the sticker (each 1-64 characters).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setStickerKeywordsAsync(string $sticker, array $keywords, array $options = []): ?PromiseInterface
    {
        $params = [
            'sticker' => $sticker,
            'keywords' => json_encode($keywords),
        ];

        $promise = $this->requestAsync('setStickerKeywords', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the mask position for a sticker (synchronous).
     * Use this method to set the mask position for a mask sticker.
     *
     * @param string $sticker File identifier of the sticker.
     * @param array|null $maskPosition Mask position data (e.g., ['point' => 'forehead', 'x_shift' => 0.0, 'y_shift' => 0.0, 'scale' => 1.0]) or null to remove the mask position.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setStickerMaskPosition(string $sticker, ?array $maskPosition = null, array $options = []): array
    {
        $params = [
            'sticker' => $sticker,
        ];
        if ($maskPosition !== null) {
            $params['mask_position'] = json_encode($maskPosition);
        }

        return $this->request('setStickerMaskPosition', array_merge($params, $options));
    }

    /**
     * Sets the mask position for a sticker (asynchronous).
     * Use this method to set the mask position for a mask sticker in an async manner (Guzzle only).
     *
     * @param string $sticker File identifier of the sticker.
     * @param array|null $maskPosition Mask position data (e.g., ['point' => 'forehead', 'x_shift' => 0.0, 'y_shift' => 0.0, 'scale' => 1.0]) or null to remove the mask position.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setStickerMaskPositionAsync(string $sticker, ?array $maskPosition = null, array $options = []): ?PromiseInterface
    {
        $params = [
            'sticker' => $sticker,
        ];
        if ($maskPosition !== null) {
            $params['mask_position'] = json_encode($maskPosition);
        }

        $promise = $this->requestAsync('setStickerMaskPosition', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}