<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Trait for handling Telegram Bot API send-related methods.
 * Provides methods to send messages, media, locations, polls, and other content types.
 * Based on Telegram Bot API version 7.3.
 */
trait sendMethod
{
    /**
     * Sends a text message (synchronous).
     * Use this method to send text messages.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $text Text of the message to be sent, 1-4096 characters.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - parse_mode (string): Mode for parsing entities in the message text (e.g., 'Markdown', 'HTML').
     *                       - entities (array): List of special entities in the message text (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - link_preview_options (array): Options for link preview generation (e.g., ['is_disabled' => true]).
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendMessage(int|string $chatId, string $text, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $text,
        ];

        if (isset($options['entities'])) {
            $params['entities'] = json_encode($options['entities']);
        }
        if (isset($options['link_preview_options'])) {
            $params['link_preview_options'] = json_encode($options['link_preview_options']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendMessage', array_merge($params, $options));
    }

    /**
     * Sends a text message (asynchronous).
     * Use this method to send text messages in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $text Text of the message to be sent, 1-4096 characters.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - parse_mode (string): Mode for parsing entities in the message text (e.g., 'Markdown', 'HTML').
     *                       - entities (array): List of special entities in the message text (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - link_preview_options (array): Options for link preview generation (e.g., ['is_disabled' => true]).
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendMessageAsync(int|string $chatId, string $text, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $text,
        ];

        if (isset($options['entities'])) {
            $params['entities'] = json_encode($options['entities']);
        }
        if (isset($options['link_preview_options'])) {
            $params['link_preview_options'] = json_encode($options['link_preview_options']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendMessage', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Forwards a message (synchronous).
     * Use this method to forward messages of any kind.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int|string $fromChatId Unique identifier for the chat where the original message was sent or username of the target channel (in the format @channelusername).
     * @param int $messageId Message identifier in the chat specified in from_chat_id.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the forwarded message from forwarding and saving.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function forwardMessage(int|string $chatId, int|string $fromChatId, int $messageId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId,
        ];

        return $this->request('forwardMessage', array_merge($params, $options));
    }

    /**
     * Forwards a message (asynchronous).
     * Use this method to forward messages of any kind in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int|string $fromChatId Unique identifier for the chat where the original message was sent or username of the target channel (in the format @channelusername).
     * @param int $messageId Message identifier in the chat specified in from_chat_id.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the forwarded message from forwarding and saving.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function forwardMessageAsync(int|string $chatId, int|string $fromChatId, int $messageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId,
        ];

        $promise = $this->requestAsync('forwardMessage', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Forwards multiple messages (synchronous).
     * Use this method to forward multiple messages simultaneously.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int|string $fromChatId Unique identifier for the chat where the original messages were sent or username of the target channel (in the format @channelusername).
     * @param array $messageIds List of message identifiers in the chat specified in from_chat_id (1-100 messages).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - disable_notification (bool): Sends the messages silently.
     *                       - protect_content (bool): Protects the contents of the forwarded messages from forwarding and saving.
     * @return array The response from Telegram containing an array of sent Message objects (['ok' => true, 'result' => [Message]]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function forwardMessages(int|string $chatId, int|string $fromChatId, array $messageIds, array $options = []): array
    {
        if (count($messageIds) < 1 || count($messageIds) > 100) {
            throw new Exception('The number of message IDs must be between 1 and 100.');
        }

        $params = [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_ids' => json_encode($messageIds),
        ];

        return $this->request('forwardMessages', array_merge($params, $options));
    }

    /**
     * Forwards multiple messages (asynchronous).
     * Use this method to forward multiple messages simultaneously in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int|string $fromChatId Unique identifier for the chat where the original messages were sent or username of the target channel (in the format @channelusername).
     * @param array $messageIds List of message identifiers in the chat specified in from_chat_id (1-100 messages).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - disable_notification (bool): Sends the messages silently.
     *                       - protect_content (bool): Protects the contents of the forwarded messages from forwarding and saving.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function forwardMessagesAsync(int|string $chatId, int|string $fromChatId, array $messageIds, array $options = []): ?PromiseInterface
    {
        if (count($messageIds) < 1 || count($messageIds) > 100) {
            throw new Exception('The number of message IDs must be between 1 and 100.');
        }

        $params = [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_ids' => json_encode($messageIds),
        ];

        $promise = $this->requestAsync('forwardMessages', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Copies a message (synchronous).
     * Use this method to copy messages of any kind.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int|string $fromChatId Unique identifier for the chat where the original message was sent or username of the target channel (in the format @channelusername).
     * @param int $messageId Message identifier in the chat specified in from_chat_id.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): New caption for media messages, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the copied message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the MessageId object (['ok' => true, 'result' => MessageId]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function copyMessage(int|string $chatId, int|string $fromChatId, int $messageId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('copyMessage', array_merge($params, $options));
    }

    /**
     * Copies a message (asynchronous).
     * Use this method to copy messages of any kind in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int|string $fromChatId Unique identifier for the chat where the original message was sent or username of the target channel (in the format @channelusername).
     * @param int $messageId Message identifier in the chat specified in from_chat_id.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): New caption for media messages, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the copied message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function copyMessageAsync(int|string $chatId, int|string $fromChatId, int $messageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('copyMessage', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Copies multiple messages (synchronous).
     * Use this method to copy multiple messages simultaneously.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int|string $fromChatId Unique identifier for the chat where the original messages were sent or username of the target channel (in the format @channelusername).
     * @param array $messageIds List of message identifiers in the chat specified in from_chat_id (1-100 messages).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - disable_notification (bool): Sends the messages silently.
     *                       - protect_content (bool): Protects the contents of the copied messages from forwarding and saving.
     *                       - remove_caption (bool): Pass true to copy the messages without their captions.
     * @return array The response from Telegram containing an array of MessageId objects (['ok' => true, 'result' => [MessageId]]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function copyMessages(int|string $chatId, int|string $fromChatId, array $messageIds, array $options = []): array
    {
        if (count($messageIds) < 1 || count($messageIds) > 100) {
            throw new Exception('The number of message IDs must be between 1 and 100.');
        }

        $params = [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_ids' => json_encode($messageIds),
        ];

        return $this->request('copyMessages', array_merge($params, $options));
    }

    /**
     * Copies multiple messages (asynchronous).
     * Use this method to copy multiple messages simultaneously in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int|string $fromChatId Unique identifier for the chat where the original messages were sent or username of the target channel (in the format @channelusername).
     * @param array $messageIds List of message identifiers in the chat specified in from_chat_id (1-100 messages).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - disable_notification (bool): Sends the messages silently.
     *                       - protect_content (bool): Protects the contents of the copied messages from forwarding and saving.
     *                       - remove_caption (bool): Pass true to copy the messages without their captions.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function copyMessagesAsync(int|string $chatId, int|string $fromChatId, array $messageIds, array $options = []): ?PromiseInterface
    {
        if (count($messageIds) < 1 || count($messageIds) > 100) {
            throw new Exception('The number of message IDs must be between 1 and 100.');
        }

        $params = [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_ids' => json_encode($messageIds),
        ];

        $promise = $this->requestAsync('copyMessages', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a photo (synchronous).
     * Use this method to send photos.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $photo Photo to send. Pass a file_id as String to send a photo that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a photo from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Photo caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - has_spoiler (bool): Pass true if the photo needs to be covered with a spoiler animation.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendPhoto(int|string $chatId, string $photo, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'photo' => $photo,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendPhoto', array_merge($params, $options));
    }

    /**
     * Sends a photo (asynchronous).
     * Use this method to send photos in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $photo Photo to send. Pass a file_id as String to send a photo that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a photo from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Photo caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - has_spoiler (bool): Pass true if the photo needs to be covered with a spoiler animation.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendPhotoAsync(int|string $chatId, string $photo, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'photo' => $photo,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendPhoto', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends an audio file (synchronous).
     * Use this method to send audio files, if you want Telegram clients to display them in the music player.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $audio Audio file to send. Pass a file_id as String to send an audio file that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get an audio file from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Audio caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - duration (int): Duration of the audio in seconds.
     *                       - performer (string): Performer of the audio.
     *                       - title (string): Title of the audio.
     *                       - thumbnail (string): Thumbnail of the audio file. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendAudio(int|string $chatId, string $audio, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'audio' => $audio,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendAudio', array_merge($params, $options));
    }

    /**
     * Sends an audio file (asynchronous).
     * Use this method to send audio files in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $audio Audio file to send. Pass a file_id as String to send an audio file that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get an audio file from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Audio caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - duration (int): Duration of the audio in seconds.
     *                       - performer (string): Performer of the audio.
     *                       - title (string): Title of the audio.
     *                       - thumbnail (string): Thumbnail of the audio file. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendAudioAsync(int|string $chatId, string $audio, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'audio' => $audio,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendAudio', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a document (synchronous).
     * Use this method to send general files.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $document File to send. Pass a file_id as String to send a file that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a file from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Document caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - thumbnail (string): Thumbnail of the file. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - disable_content_type_detection (bool): Disables automatic server-side content type detection for files uploaded using multipart/form-data.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendDocument(int|string $chatId, string $document, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'document' => $document,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendDocument', array_merge($params, $options));
    }

    /**
     * Sends a document (asynchronous).
     * Use this method to send general files in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $document File to send. Pass a file_id as String to send a file that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a file from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Document caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - thumbnail (string): Thumbnail of the file. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - disable_content_type_detection (bool): Disables automatic server-side content type detection for files uploaded using multipart/form-data.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendDocumentAsync(int|string $chatId, string $document, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'document' => $document,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendDocument', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a video (synchronous).
     * Use this method to send video files.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $video Video to send. Pass a file_id as String to send a video that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a video from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Video caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - duration (int): Duration of the video in seconds.
     *                       - width (int): Video width.
     *                       - height (int): Video height.
     *                       - thumbnail (string): Thumbnail of the video. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - has_spoiler (bool): Pass true if the video needs to be covered with a spoiler animation.
     *                       - supports_streaming (bool): Pass true if the uploaded video is suitable for streaming.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendVideo(int|string $chatId, string $video, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'video' => $video,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendVideo', array_merge($params, $options));
    }

    /**
     * Sends a video (asynchronous).
     * Use this method to send video files in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $video Video to send. Pass a file_id as String to send a video that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a video from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Video caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - duration (int): Duration of the video in seconds.
     *                       - width (int): Video width.
     *                       - height (int): Video height.
     *                       - thumbnail (string): Thumbnail of the video. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - has_spoiler (bool): Pass true if the video needs to be covered with a spoiler animation.
     *                       - supports_streaming (bool): Pass true if the uploaded video is suitable for streaming.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendVideoAsync(int|string $chatId, string $video, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'video' => $video,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendVideo', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends an animation (synchronous).
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $animation Animation to send. Pass a file_id as String to send an animation that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get an animation from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Animation caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - duration (int): Duration of the animation in seconds.
     *                       - width (int): Animation width.
     *                       - height (int): Animation height.
     *                       - thumbnail (string): Thumbnail of the animation. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - has_spoiler (bool): Pass true if the animation needs to be covered with a spoiler animation.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendAnimation(int|string $chatId, string $animation, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'animation' => $animation,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendAnimation', array_merge($params, $options));
    }

    /**
     * Sends an animation (asynchronous).
     * Use this method to send animation files in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $animation Animation to send. Pass a file_id as String to send an animation that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get an animation from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Animation caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - duration (int): Duration of the animation in seconds.
     *                       - width (int): Animation width.
     *                       - height (int): Animation height.
     *                       - thumbnail (string): Thumbnail of the animation. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - has_spoiler (bool): Pass true if the animation needs to be covered with a spoiler animation.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendAnimationAsync(int|string $chatId, string $animation, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'animation' => $animation,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendAnimation', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a voice message (synchronous).
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $voice Audio file to send. Pass a file_id as String to send a voice message that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a voice message from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Voice message caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - duration (int): Duration of the voice message in seconds.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendVoice(int|string $chatId, string $voice, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'voice' => $voice,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendVoice', array_merge($params, $options));
    }

    /**
     * Sends a voice message (asynchronous).
     * Use this method to send audio files as voice messages in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $voice Audio file to send. Pass a file_id as String to send a voice message that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a voice message from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - caption (string): Voice message caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - duration (int): Duration of the voice message in seconds.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendVoiceAsync(int|string $chatId, string $voice, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'voice' => $voice,
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendVoice', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a video note (synchronous).
     * Use this method to send video messages.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $videoNote Video note to send. Pass a file_id as String to send a video note that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a video note from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - duration (int): Duration of the video note in seconds.
     *                       - length (int): Video width and height (diameter of the video message).
     *                       - thumbnail (string): Thumbnail of the video note. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendVideoNote(int|string $chatId, string $videoNote, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'video_note' => $videoNote,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendVideoNote', array_merge($params, $options));
    }

    /**
     * Sends a video note (asynchronous).
     * Use this method to send video messages in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $videoNote Video note to send. Pass a file_id as String to send a video note that exists on the Telegram servers, or pass an HTTP URL as a String for Telegram to get a video note from the Internet.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - duration (int): Duration of the video note in seconds.
     *                       - length (int): Video width and height (diameter of the video message).
     *                       - thumbnail (string): Thumbnail of the video note. Pass a file_id as String to send a thumbnail that exists on the Telegram servers.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendVideoNoteAsync(int|string $chatId, string $videoNote, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'video_note' => $videoNote,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendVideoNote', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends paid media (synchronous).
     * Use this method to send paid media to channel chats.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $starCount Number of Telegram Stars that the user must pay to view the media.
     * @param array $media A JSON-serialized array describing the media to be sent; up to 10 items.
     * @param array $options Optional parameters:
     *                       - payload (string): Bot-defined payload for the paid media, 0-128 bytes.
     *                       - caption (string): Media caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - show_caption_above_media (bool): Pass true to show the caption above the media.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendPaidMedia(int|string $chatId, int $starCount, array $media, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'star_count' => $starCount,
            'media' => json_encode($media),
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendPaidMedia', array_merge($params, $options));
    }

    /**
     * Sends paid media (asynchronous).
     * Use this method to send paid media to channel chats in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $starCount Number of Telegram Stars that the user must pay to view the media.
     * @param array $media A JSON-serialized array describing the media to be sent; up to 10 items.
     * @param array $options Optional parameters:
     *                       - payload (string): Bot-defined payload for the paid media, 0-128 bytes.
     *                       - caption (string): Media caption, 0-1024 characters.
     *                       - parse_mode (string): Mode for parsing entities in the caption (e.g., 'Markdown', 'HTML').
     *                       - caption_entities (array): List of special entities in the caption (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - show_caption_above_media (bool): Pass true to show the caption above the media.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendPaidMediaAsync(int|string $chatId, int $starCount, array $media, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'star_count' => $starCount,
            'media' => json_encode($media),
        ];

        if (isset($options['caption_entities'])) {
            $params['caption_entities'] = json_encode($options['caption_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendPaidMedia', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a media group (synchronous).
     * Use this method to send a group of photos, videos, documents, or audios as an album.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $media A JSON-serialized array describing photos, videos, documents, or audios to be sent; 2-10 items.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     * @return array The response from Telegram containing an array of sent Message objects (['ok' => true, 'result' => [Message]]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendMediaGroup(int|string $chatId, array $media, array $options = []): array
    {
        if (count($media) < 2 || count($media) > 10) {
            throw new Exception('The number of media items must be between 2 and 10.');
        }

        $params = [
            'chat_id' => $chatId,
            'media' => json_encode($media),
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }

        return $this->request('sendMediaGroup', array_merge($params, $options));
    }

    /**
     * Sends a media group (asynchronous).
     * Use this method to send a group of photos, videos, documents, or audios as an album in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $media A JSON-serialized array describing photos, videos, documents, or audios to be sent; 2-10 items.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendMediaGroupAsync(int|string $chatId, array $media, array $options = []): ?PromiseInterface
    {
        if (count($media) < 2 || count($media) > 10) {
            throw new Exception('The number of media items must be between 2 and 10.');
        }

        $params = [
            'chat_id' => $chatId,
            'media' => json_encode($media),
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }

        $promise = $this->requestAsync('sendMediaGroup', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a location (synchronous).
     * Use this method to send point on the map.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param float $latitude Latitude of the location.
     * @param float $longitude Longitude of the location.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - horizontal_accuracy (float): The radius of uncertainty for the location, measured in meters; 0-1500.
     *                       - live_period (int): Period in seconds for which the location will be updated (e.g., 60-86400).
     *                       - heading (int): Direction in which the user is moving, in degrees; 1-360.
     *                       - proximity_alert_radius (int): Maximum distance for proximity alerts about approaching another chat member, in meters; 0-100000.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendLocation(int|string $chatId, float $latitude, float $longitude, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendLocation', array_merge($params, $options));
    }

    /**
     * Sends a location (asynchronous).
     * Use this method to send point on the map in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param float $latitude Latitude of the location.
     * @param float $longitude Longitude of the location.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - horizontal_accuracy (float): The radius of uncertainty for the location, measured in meters; 0-1500.
     *                       - live_period (int): Period in seconds for which the location will be updated (e.g., 60-86400).
     *                       - heading (int): Direction in which the user is moving, in degrees; 1-360.
     *                       - proximity_alert_radius (int): Maximum distance for proximity alerts about approaching another chat member, in meters; 0-100000.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendLocationAsync(int|string $chatId, float $latitude, float $longitude, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendLocation', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
    /**
     * Sends a venue (synchronous).
     * Use this method to send information about a venue.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param float $latitude Latitude of the venue.
     * @param float $longitude Longitude of the venue.
     * @param string $title Name of the venue.
     * @param string $address Address of the venue.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - foursquare_id (string): Foursquare identifier of the venue.
     *                       - foursquare_type (string): Foursquare type of the venue (e.g., "arts_entertainment/default").
     *                       - google_place_id (string): Google Places identifier of the venue.
     *                       - google_place_type (string): Google Places type of the venue.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendVenue(int|string $chatId, float $latitude, float $longitude, string $title, string $address, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'title' => $title,
            'address' => $address,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendVenue', array_merge($params, $options));
    }

    /**
     * Sends a venue (asynchronous).
     * Use this method to send information about a venue in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param float $latitude Latitude of the venue.
     * @param float $longitude Longitude of the venue.
     * @param string $title Name of the venue.
     * @param string $address Address of the venue.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - foursquare_id (string): Foursquare identifier of the venue.
     *                       - foursquare_type (string): Foursquare type of the venue (e.g., "arts_entertainment/default").
     *                       - google_place_id (string): Google Places identifier of the venue.
     *                       - google_place_type (string): Google Places type of the venue.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendVenueAsync(int|string $chatId, float $latitude, float $longitude, string $title, string $address, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'title' => $title,
            'address' => $address,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendVenue', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a contact (synchronous).
     * Use this method to send phone contacts.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $phoneNumber Contact's phone number.
     * @param string $firstName Contact's first name.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - last_name (string): Contact's last name.
     *                       - vcard (string): Additional data about the contact in the form of a vCard.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendContact(int|string $chatId, string $phoneNumber, string $firstName, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'phone_number' => $phoneNumber,
            'first_name' => $firstName,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendContact', array_merge($params, $options));
    }

    /**
     * Sends a contact (asynchronous).
     * Use this method to send phone contacts in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $phoneNumber Contact's phone number.
     * @param string $firstName Contact's first name.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - last_name (string): Contact's last name.
     *                       - vcard (string): Additional data about the contact in the form of a vCard.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendContactAsync(int|string $chatId, string $phoneNumber, string $firstName, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'phone_number' => $phoneNumber,
            'first_name' => $firstName,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendContact', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a poll (synchronous).
     * Use this method to send a native poll.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $question Poll question, 1-300 characters.
     * @param array $optionsList List of answer options, 2-10 strings 1-100 characters each.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - is_anonymous (bool): True, if the poll needs to be anonymous, defaults to True.
     *                       - type (string): Poll type, “quiz” or “regular”, defaults to “regular”.
     *                       - allows_multiple_answers (bool): True, if the poll allows multiple answers, ignored for quizzes.
     *                       - correct_option_id (int): 0-based identifier of the correct answer option in quizzes.
     *                       - explanation (string): Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz, 0-200 characters.
     *                       - explanation_entities (array): List of special entities in the explanation (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - open_period (int): Amount of time in seconds the poll will be active after creation, 5-600.
     *                       - close_date (int): Point in time (Unix timestamp) when the poll will be automatically closed.
     *                       - is_closed (bool): Pass True, if the poll needs to be immediately closed.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object with the poll (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendPoll(int|string $chatId, string $question, array $optionsList, array $options = []): array
    {
        if (count($optionsList) < 2 || count($optionsList) > 10) {
            throw new Exception('The number of poll options must be between 2 and 10.');
        }

        $params = [
            'chat_id' => $chatId,
            'question' => $question,
            'options' => json_encode($optionsList),
        ];

        if (isset($options['explanation_entities'])) {
            $params['explanation_entities'] = json_encode($options['explanation_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendPoll', array_merge($params, $options));
    }

    /**
     * Sends a poll (asynchronous).
     * Use this method to send a native poll in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $question Poll question, 1-300 characters.
     * @param array $optionsList List of answer options, 2-10 strings 1-100 characters each.
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - is_anonymous (bool): True, if the poll needs to be anonymous, defaults to True.
     *                       - type (string): Poll type, “quiz” or “regular”, defaults to “regular”.
     *                       - allows_multiple_answers (bool): True, if the poll allows multiple answers, ignored for quizzes.
     *                       - correct_option_id (int): 0-based identifier of the correct answer option in quizzes.
     *                       - explanation (string): Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz, 0-200 characters.
     *                       - explanation_entities (array): List of special entities in the explanation (e.g., ['type' => 'bold', 'offset' => 0, 'length' => 4]).
     *                       - open_period (int): Amount of time in seconds the poll will be active after creation, 5-600.
     *                       - close_date (int): Point in time (Unix timestamp) when the poll will be automatically closed.
     *                       - is_closed (bool): Pass True, if the poll needs to be immediately closed.
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendPollAsync(int|string $chatId, string $question, array $optionsList, array $options = []): ?PromiseInterface
    {
        if (count($optionsList) < 2 || count($optionsList) > 10) {
            throw new Exception('The number of poll options must be between 2 and 10.');
        }

        $params = [
            'chat_id' => $chatId,
            'question' => $question,
            'options' => json_encode($optionsList),
        ];

        if (isset($options['explanation_entities'])) {
            $params['explanation_entities'] = json_encode($options['explanation_entities']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendPoll', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a dice (synchronous).
     * Use this method to send an animated emoji that will display a random value.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - emoji (string): Emoji on which the dice throw animation is based. Currently, must be one of "🎲", "🎯", "🏀", "⚽", "🎳", or "🎰". Defaults to "🎲".
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return array The response from Telegram containing the sent Message object with the dice (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendDice(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendDice', array_merge($params, $options));
    }

    /**
     * Sends a dice (asynchronous).
     * Use this method to send an animated emoji that will display a random value in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     *                       - emoji (string): Emoji on which the dice throw animation is based. Currently, must be one of "🎲", "🎯", "🏀", "⚽", "🎳", or "🎰". Defaults to "🎲".
     *                       - disable_notification (bool): Sends the message silently.
     *                       - protect_content (bool): Protects the contents of the sent message from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => 123]).
     *                       - reply_markup (array): A JSON-serialized object for an inline or reply keyboard.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendDiceAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendDice', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sends a chat action (synchronous).
     * Use this method to inform the user that something is happening on the bot's side (e.g., typing, uploading a photo).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $action Type of action to broadcast. Choose one from: "typing", "upload_photo", "record_video", "upload_video", "record_voice", "upload_voice", "upload_document", "choose_sticker", "find_location", "record_video_note", "upload_video_note".
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendChatAction(int|string $chatId, string $action, array $options = []): array
    {
        $validActions = [
            'typing', 'upload_photo', 'record_video', 'upload_video', 'record_voice',
            'upload_voice', 'upload_document', 'choose_sticker', 'find_location',
            'record_video_note', 'upload_video_note'
        ];

        if (!in_array($action, $validActions)) {
            throw new Exception('Invalid action type. Must be one of: ' . implode(', ', $validActions));
        }

        $params = [
            'chat_id' => $chatId,
            'action' => $action,
        ];

        return $this->request('sendChatAction', array_merge($params, $options));
    }

    /**
     * Sends a chat action (asynchronous).
     * Use this method to inform the user that something is happening on the bot's side in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $action Type of action to broadcast. Choose one from: "typing", "upload_photo", "record_video", "upload_video", "record_voice", "upload_voice", "upload_document", "choose_sticker", "find_location", "record_video_note", "upload_video_note".
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) in a forum.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function sendChatActionAsync(int|string $chatId, string $action, array $options = []): ?PromiseInterface
    {
        $validActions = [
            'typing', 'upload_photo', 'record_video', 'upload_video', 'record_voice',
            'upload_voice', 'upload_document', 'choose_sticker', 'find_location',
            'record_video_note', 'upload_video_note'
        ];

        if (!in_array($action, $validActions)) {
            throw new Exception('Invalid action type. Must be one of: ' . implode(', ', $validActions));
        }

        $params = [
            'chat_id' => $chatId,
            'action' => $action,
        ];

        $promise = $this->requestAsync('sendChatAction', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets a reaction to a message (synchronous).
     * Use this method to set a reaction on a message.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the target message.
     * @param array $reaction List of reaction types to set. Pass an empty array to remove the reaction. Each reaction is a JSON object (e.g., ['type' => 'emoji', 'emoji' => '👍'] or ['type' => 'custom_emoji', 'custom_emoji_id' => 'id']).
     * @param array $options Optional parameters:
     *                       - is_big (bool): Pass True to set the reaction with a big animation.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setMessageReaction(int|string $chatId, int $messageId, array $reaction, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'reaction' => json_encode($reaction),
        ];

        return $this->request('setMessageReaction', array_merge($params, $options));
    }

    /**
     * Sets a reaction to a message (asynchronous).
     * Use this method to set a reaction on a message in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param int $messageId Identifier of the target message.
     * @param array $reaction List of reaction types to set. Pass an empty array to remove the reaction. Each reaction is a JSON object (e.g., ['type' => 'emoji', 'emoji' => '👍'] or ['type' => 'custom_emoji', 'custom_emoji_id' => 'id']).
     * @param array $options Optional parameters:
     *                       - is_big (bool): Pass True to set the reaction with a big animation.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function setMessageReactionAsync(int|string $chatId, int $messageId, array $reaction, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'reaction' => json_encode($reaction),
        ];

        $promise = $this->requestAsync('setMessageReaction', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}
