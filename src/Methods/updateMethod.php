<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Trait for handling Telegram Bot API update-related methods.
 * Provides methods to edit, delete, and manage messages, polls, and live locations.
 * Based on Telegram Bot API version 7.3.
 */
trait updateMethod
{
    /**
     * Edits the text of a message (synchronous).
     * Use this method to edit text messages sent by the bot or via the bot (for inline bots).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param string $text New text of the message, 1-4096 characters.
     * @param array $options Optional parameters:
     *                       - parse_mode (string): Mode for parsing entities in the message text (e.g., 'Markdown', 'HTML').
     *                       - entities (array): List of special entities in the message text (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - link_preview_options (array): Options for link preview generation (e.g., ['is_disabled' => true]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram containing the edited Message object (['ok' => true, 'result' => Message]), or true for inline messages.
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editMessageText(int|string $chatId, int $messageId, string $text, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
        ];

        if (isset($options['entities'])) {
            $params['entities'] = json_encode($options['entities']);
        }
        if (isset($options['link_preview_options'])) {
            $params['link_preview_options'] = json_encode($options['link_preview_options']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('editMessageText', array_merge($params, $options));
    }

    /**
     * Edits the text of a message (asynchronous).
     * Use this method to edit text messages sent by the bot or via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param string $text New text of the message, 1-4096 characters.
     * @param array $options Optional parameters:
     *                       - parse_mode (string): Mode for parsing entities in the message text (e.g., 'Markdown', 'HTML').
     *                       - entities (array): List of special entities in the message text (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - link_preview_options (array): Options for link preview generation (e.g., ['is_disabled' => true]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editMessageTextAsync(int|string $chatId, int $messageId, string $text, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
        ];

        if (isset($options['entities'])) {
            $params['entities'] = json_encode($options['entities']);
        }
        if (isset($options['link_preview_options'])) {
            $params['link_preview_options'] = json_encode($options['link_preview_options']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('editMessageText', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Edits the caption of a message (synchronous).
     * Use this method to edit the caption of a message sent by the bot or via the bot (for inline bots).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param array $options Optional parameters:
     *                       - caption (string): New caption of the message, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram containing the edited Message object (['ok' => true, 'result' => Message]), or true for inline messages.
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editMessageCaption(int|string $chatId, int $messageId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('editMessageCaption', array_merge($params, $options));
    }

    /**
     * Edits the caption of a message (asynchronous).
     * Use this method to edit the caption of a message sent by the bot or via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param array $options Optional parameters:
     *                       - caption (string): New caption of the message, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editMessageCaptionAsync(int|string $chatId, int $messageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('editMessageCaption', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Edits the media of a message (synchronous).
     * Use this method to edit animation, audio, document, photo, or video messages sent by the bot or via the bot (for inline bots).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param array $media A JSON-serialized object for the new media content (e.g., ['type' => 'photo', 'media' => 'file_id']).
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram containing the edited Message object (['ok' => true, 'result' => Message]), or true for inline messages.
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editMessageMedia(int|string $chatId, int $messageId, array $media, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'media' => json_encode($media),
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('editMessageMedia', array_merge($params, $options));
    }

    /**
     * Edits the media of a message (asynchronous).
     * Use this method to edit animation, audio, document, photo, or video messages sent by the bot or via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param array $media A JSON-serialized object for the new media content (e.g., ['type' => 'photo', 'media' => 'file_id']).
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editMessageMediaAsync(int|string $chatId, int $messageId, array $media, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'media' => json_encode($media),
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('editMessageMedia', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Edits the live location of a message (synchronous).
     * Use this method to edit live location messages sent by the bot or via the bot (for inline bots).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param float $latitude Latitude of the new location.
     * @param float $longitude Longitude of the new location.
     * @param array $options Optional parameters:
     *                       - horizontal_accuracy (float): The radius of uncertainty for the location, measured in meters; 0-1500.
     *                       - heading (int): Direction in which the user is moving, in degrees; 1-360.
     *                       - proximity_alert_radius (int): Maximum distance for proximity alerts about approaching another chat member, in meters; 0-100000.
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram containing the edited Message object (['ok' => true, 'result' => Message]), or true for inline messages.
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editMessageLiveLocation(int|string $chatId, int $messageId, float $latitude, float $longitude, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('editMessageLiveLocation', array_merge($params, $options));
    }

    /**
     * Edits the live location of a message (asynchronous).
     * Use this method to edit live location messages sent by the bot or via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param float $latitude Latitude of the new location.
     * @param float $longitude Longitude of the new location.
     * @param array $options Optional parameters:
     *                       - horizontal_accuracy (float): The radius of uncertainty for the location, measured in meters; 0-1500.
     *                       - heading (int): Direction in which the user is moving, in degrees; 1-360.
     *                       - proximity_alert_radius (int): Maximum distance for proximity alerts about approaching another chat member, in meters; 0-100000.
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editMessageLiveLocationAsync(int|string $chatId, int $messageId, float $latitude, float $longitude, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('editMessageLiveLocation', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Stops a live location message (synchronous).
     * Use this method to stop updating a live location message before the live_period expires.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to stop.
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram containing the edited Message object (['ok' => true, 'result' => Message]), or true for inline messages.
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function stopMessageLiveLocation(int|string $chatId, int $messageId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('stopMessageLiveLocation', array_merge($params, $options));
    }

    /**
     * Stops a live location message (asynchronous).
     * Use this method to stop updating a live location message before the live_period expires in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to stop.
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function stopMessageLiveLocationAsync(int|string $chatId, int $messageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('stopMessageLiveLocation', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Edits the reply markup of a message (synchronous).
     * Use this method to edit the reply markup of messages sent by the bot or via the bot (for inline bots).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram containing the edited Message object (['ok' => true, 'result' => Message]), or true for inline messages.
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editMessageReplyMarkup(int|string $chatId, int $messageId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('editMessageReplyMarkup', array_merge($params, $options));
    }

    /**
     * Edits the reply markup of a message (asynchronous).
     * Use this method to edit the reply markup of messages sent by the bot or via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to edit.
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editMessageReplyMarkupAsync(int|string $chatId, int $messageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('editMessageReplyMarkup', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Stops a poll (synchronous).
     * Use this method to stop a poll sent by the bot.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message containing the poll.
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram containing the stopped Poll object (['ok' => true, 'result' => Poll]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function stopPoll(int|string $chatId, int $messageId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('stopPoll', array_merge($params, $options));
    }

    /**
     * Stops a poll (asynchronous).
     * Use this method to stop a poll sent by the bot in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message containing the poll.
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function stopPollAsync(int|string $chatId, int $messageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('stopPoll', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Deletes a message (synchronous).
     * Use this method to delete a message, including service messages, with certain limitations.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to delete.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function deleteMessage(int|string $chatId, int $messageId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        return $this->request('deleteMessage', array_merge($params, $options));
    }

    /**
     * Deletes a message (asynchronous).
     * Use this method to delete a message, including service messages, in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to delete.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function deleteMessageAsync(int|string $chatId, int $messageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        $promise = $this->requestAsync('deleteMessage', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Deletes multiple messages (synchronous).
     * Use this method to delete multiple messages simultaneously. If some of the specified messages can't be deleted, they are skipped.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $messageIds List of message identifiers to delete (1-100 messages).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function deleteMessages(int|string $chatId, array $messageIds, array $options = []): array
    {
        if (count($messageIds) < 1 || count($messageIds) > 100) {
            throw new Exception('The number of message IDs must be between 1 and 100.');
        }

        $params = [
            'chat_id' => $chatId,
            'message_ids' => json_encode($messageIds),
        ];

        return $this->request('deleteMessages', array_merge($params, $options));
    }

    /**
     * Deletes multiple messages (asynchronous).
     * Use this method to delete multiple messages simultaneously in an async manner (Guzzle only). If some of the specified messages can't be deleted, they are skipped.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $messageIds List of message identifiers to delete (1-100 messages).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function deleteMessagesAsync(int|string $chatId, array $messageIds, array $options = []): ?PromiseInterface
    {
        if (count($messageIds) < 1 || count($messageIds) > 100) {
            throw new Exception('The number of message IDs must be between 1 and 100.');
        }

        $params = [
            'chat_id' => $chatId,
            'message_ids' => json_encode($messageIds),
        ];

        $promise = $this->requestAsync('deleteMessages', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}