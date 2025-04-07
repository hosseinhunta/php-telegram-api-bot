<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Trait for handling Telegram Bot API inline-related methods.
 * Provides methods to manage inline queries and callback queries.
 * Based on Telegram Bot API version 7.3.
 */
trait inlineMethod
{
    /**
     * Answers an inline query (synchronous).
     * Use this method to send answers to an inline query.
     *
     * @param string $inlineQueryId Unique identifier for the target inline query.
     * @param array $results A JSON-serialized array of results for the inline query (e.g., [['type' => 'article', 'id' => '1', 'title' => 'Title', 'input_message_content' => ['message_text' => 'Text']]]).
     * @param array $options Optional parameters:
     *                       - cache_time (int): The maximum amount of time in seconds that the result of the inline query may be cached on the server. Defaults to 300.
     *                       - is_personal (bool): Pass True if results may be cached on the server side only for the user that sent the query.
     *                       - next_offset (string): Pass the offset that a client should send in the next query with the same text to receive more results.
     *                       - button (array): A JSON-serialized object for an inline keyboard button to be shown above the inline query results (e.g., ['text' => 'Button', 'web_app' => ['url' => 'https://example.com']]).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function answerInlineQuery(string $inlineQueryId, array $results, array $options = []): array
    {
        $params = [
            'inline_query_id' => $inlineQueryId,
            'results' => json_encode($results),
        ];

        if (isset($options['button'])) {
            $params['button'] = json_encode($options['button']);
        }

        return $this->request('answerInlineQuery', array_merge($params, $options));
    }

    /**
     * Answers an inline query (asynchronous).
     * Use this method to send answers to an inline query in an async manner (Guzzle only).
     *
     * @param string $inlineQueryId Unique identifier for the target inline query.
     * @param array $results A JSON-serialized array of results for the inline query (e.g., [['type' => 'article', 'id' => '1', 'title' => 'Title', 'input_message_content' => ['message_text' => 'Text']]]).
     * @param array $options Optional parameters:
     *                       - cache_time (int): The maximum amount of time in seconds that the result of the inline query may be cached on the server. Defaults to 300.
     *                       - is_personal (bool): Pass True if results may be cached on the server side only for the user that sent the query.
     *                       - next_offset (string): Pass the offset that a client should send in the next query with the same text to receive more results.
     *                       - button (array): A JSON-serialized object for an inline keyboard button to be shown above the inline query results (e.g., ['text' => 'Button', 'web_app' => ['url' => 'https://example.com']]).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function answerInlineQueryAsync(string $inlineQueryId, array $results, array $options = []): ?PromiseInterface
    {
        $params = [
            'inline_query_id' => $inlineQueryId,
            'results' => json_encode($results),
        ];

        if (isset($options['button'])) {
            $params['button'] = json_encode($options['button']);
        }

        $promise = $this->requestAsync('answerInlineQuery', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Answers a callback query (synchronous).
     * Use this method to send answers to callback queries sent from inline keyboards.
     *
     * @param string $callbackQueryId Unique identifier for the target callback query.
     * @param array $options Optional parameters:
     *                       - text (string): Text of the notification. If not specified, nothing will be shown to the user, 0-200 characters.
     *                       - show_alert (bool): If True, an alert will be shown by the client instead of a notification at the top of the chat screen.
     *                       - url (string): URL that will be opened by the user's client (e.g., for authentication or to open a game).
     *                       - cache_time (int): The maximum amount of time in seconds that the result of the callback query may be cached on the server. Defaults to 0.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function answerCallbackQuery(string $callbackQueryId, array $options = []): array
    {
        $params = [
            'callback_query_id' => $callbackQueryId,
        ];

        return $this->request('answerCallbackQuery', array_merge($params, $options));
    }

    /**
     * Answers a callback query (asynchronous).
     * Use this method to send answers to callback queries sent from inline keyboards in an async manner (Guzzle only).
     *
     * @param string $callbackQueryId Unique identifier for the target callback query.
     * @param array $options Optional parameters:
     *                       - text (string): Text of the notification. If not specified, nothing will be shown to the user, 0-200 characters.
     *                       - show_alert (bool): If True, an alert will be shown by the client instead of a notification at the top of the chat screen.
     *                       - url (string): URL that will be opened by the user's client (e.g., for authentication or to open a game).
     *                       - cache_time (int): The maximum amount of time in seconds that the result of the callback query may be cached on the server. Defaults to 0.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function answerCallbackQueryAsync(string $callbackQueryId, array $options = []): ?PromiseInterface
    {
        $params = [
            'callback_query_id' => $callbackQueryId,
        ];

        $promise = $this->requestAsync('answerCallbackQuery', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Edits an inline message's text (synchronous).
     * Use this method to edit text and game messages sent via the bot (for inline bots).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @param string $text New text of the message, 1-4096 characters.
     * @param array $options Optional parameters:
     *                       - parse_mode (string): Mode for parsing entities in the message text (e.g., 'Markdown', 'HTML').
     *                       - entities (array): List of special entities in the message text (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - link_preview_options (array): Options for link preview generation (e.g., ['is_disabled' => true]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editMessageTextInline(string $inlineMessageId, string $text, array $options = []): array
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
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
     * Edits an inline message's text (asynchronous).
     * Use this method to edit text and game messages sent via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @param string $text New text of the message, 1-4096 characters.
     * @param array $options Optional parameters:
     *                       - parse_mode (string): Mode for parsing entities in the message text (e.g., 'Markdown', 'HTML').
     *                       - entities (array): List of special entities in the message text (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - link_preview_options (array): Options for link preview generation (e.g., ['is_disabled' => true]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editMessageTextInlineAsync(string $inlineMessageId, string $text, array $options = []): ?PromiseInterface
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
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
     * Edits an inline message's caption (synchronous).
     * Use this method to edit captions of messages sent via the bot (for inline bots).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @param array $options Optional parameters:
     *                       - caption (string): New caption of the message, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editMessageCaptionInline(string $inlineMessageId, array $options = []): array
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
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
     * Edits an inline message's caption (asynchronous).
     * Use this method to edit captions of messages sent via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @param array $options Optional parameters:
     *                       - caption (string): New caption of the message, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editMessageCaptionInlineAsync(string $inlineMessageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
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
     * Edits an inline message's media (synchronous).
     * Use this method to edit animation, audio, document, photo, or video messages sent via the bot (for inline bots).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @param array $media A JSON-serialized object for the new media content (e.g., ['type' => 'photo', 'media' => 'file_id']).
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editMessageMediaInline(string $inlineMessageId, array $media, array $options = []): array
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
            'media' => json_encode($media),
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('editMessageMedia', array_merge($params, $options));
    }

    /**
     * Edits an inline message's media (asynchronous).
     * Use this method to edit animation, audio, document, photo, or video messages sent via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @param array $media A JSON-serialized object for the new media content (e.g., ['type' => 'photo', 'media' => 'file_id']).
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editMessageMediaInlineAsync(string $inlineMessageId, array $media, array $options = []): ?PromiseInterface
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
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
     * Edits an inline message's reply markup (synchronous).
     * Use this method to edit only the reply markup of messages sent via the bot (for inline bots).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editMessageReplyMarkupInline(string $inlineMessageId, array $options = []): array
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
        ];

        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('editMessageReplyMarkup', array_merge($params, $options));
    }

    /**
     * Edits an inline message's reply markup (asynchronous).
     * Use this method to edit only the reply markup of messages sent via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @param array $options Optional parameters:
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function editMessageReplyMarkupInlineAsync(string $inlineMessageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
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
     * Deletes an inline message (synchronous).
     * Use this method to delete a message sent via the bot (for inline bots).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function deleteMessageInline(string $inlineMessageId): array
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
        ];

        return $this->request('deleteMessage', $params);
    }

    /**
     * Deletes an inline message (asynchronous).
     * Use this method to delete a message sent via the bot (for inline bots) in an async manner (Guzzle only).
     *
     * @param string $inlineMessageId Identifier of the inline message.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function deleteMessageInlineAsync(string $inlineMessageId): ?PromiseInterface
    {
        $params = [
            'inline_message_id' => $inlineMessageId,
        ];

        $promise = $this->requestAsync('deleteMessage', $params);
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}