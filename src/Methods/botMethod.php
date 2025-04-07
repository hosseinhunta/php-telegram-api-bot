<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Promise\PromiseInterface;

trait botMethod
{
    /**
     * Retrieves basic information about the bot.
     *
     * Use this method to verify the bot's token and get its ID, username, and capabilities.
     *
     * @return array User object with bot details on success.
     * @throws Exception On invalid token or API errors.
     * @see https://core.telegram.org/bots/api#getme
     */
    public function getMe(): array
    {
        return $this->request('getMe');
    }
    /**
     * Logs out the bot from the Telegram server.
     *
     * Use this method to terminate the bot's session on the server.
     *
     * @return array True on success.
     * @throws Exception On API errors.
     * @see https://core.telegram.org/bots/api#logout
     */
    public function logOut(): array
    {
        return $this->request('logOut');
    }
    /**
     * Closes the bot instance without logging out.
     *
     * Use this method to shut down the bot instance while keeping the session active.
     *
     * @return array True on success.
     * @throws Exception On API errors.
     * @see https://core.telegram.org/bots/api#close
     */
    public function close(): array
    {
        return $this->request('close');
    }

    /**
     * Sets the list of bot commands (synchronous).
     * Use this method to set the list of the bot's commands.
     *
     * @param array $commands A JSON-serialized list of bot commands to be set (e.g., [['command' => 'start', 'description' => 'Start the bot']]).
     * @param array $options Optional parameters:
     *                       - scope (array): A JSON-serialized object for the target scope of users (e.g., ['type' => 'chat', 'chat_id' => 123]).
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function setMyCommands(array $commands, array $options = []): array
    {
        $params = [
            'commands' => json_encode($commands),
        ];

        if (isset($options['scope'])) {
            $params['scope'] = json_encode($options['scope']);
        }

        return $this->request('setMyCommands', array_merge($params, $options));
    }

    /**
     * Sets the list of bot commands (asynchronous).
     * Use this method to set the list of the bot's commands in an async manner (Guzzle only).
     *
     * @param array $commands A JSON-serialized list of bot commands to be set (e.g., [['command' => 'start', 'description' => 'Start the bot']]).
     * @param array $options Optional parameters:
     *                       - scope (array): A JSON-serialized object for the target scope of users (e.g., ['type' => 'chat', 'chat_id' => 123]).
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function setMyCommandsAsync(array $commands, array $options = []): ?PromiseInterface
    {
        $params = [
            'commands' => json_encode($commands),
        ];

        if (isset($options['scope'])) {
            $params['scope'] = json_encode($options['scope']);
        }

        $promise = $this->requestAsync('setMyCommands', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Deletes the list of bot commands (synchronous).
     * Use this method to delete the list of the bot's commands for the given scope and user language.
     *
     * @param array $options Optional parameters:
     *                       - scope (array): A JSON-serialized object for the target scope of users (e.g., ['type' => 'chat', 'chat_id' => 123]).
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception If the request fails.
     */
    public function deleteMyCommands(array $options = []): array
    {
        $params = [];

        if (isset($options['scope'])) {
            $params['scope'] = json_encode($options['scope']);
        }

        return $this->request('deleteMyCommands', array_merge($params, $options));
    }

    /**
     * Deletes the list of bot commands (asynchronous).
     * Use this method to delete the list of the bot's commands for the given scope and user language in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters:
     *                       - scope (array): A JSON-serialized object for the target scope of users (e.g., ['type' => 'chat', 'chat_id' => 123]).
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function deleteMyCommandsAsync(array $options = []): ?PromiseInterface
    {
        $params = [];

        if (isset($options['scope'])) {
            $params['scope'] = json_encode($options['scope']);
        }

        $promise = $this->requestAsync('deleteMyCommands', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the current list of bot commands (synchronous).
     * Use this method to get the current list of the bot's commands.
     *
     * @param array $options Optional parameters:
     *                       - scope (array): A JSON-serialized object for the target scope of users (e.g., ['type' => 'chat', 'chat_id' => 123]).
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return array The response from Telegram containing an array of BotCommand objects (['ok' => true, 'result' => [BotCommand]]).
     * @throws Exception If the request fails.
     */
    public function getMyCommands(array $options = []): array
    {
        $params = [];

        if (isset($options['scope'])) {
            $params['scope'] = json_encode($options['scope']);
        }

        return $this->request('getMyCommands', array_merge($params, $options));
    }

    /**
     * Gets the current list of bot commands (asynchronous).
     * Use this method to get the current list of the bot's commands in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters:
     *                       - scope (array): A JSON-serialized object for the target scope of users (e.g., ['type' => 'chat', 'chat_id' => 123]).
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getMyCommandsAsync(array $options = []): ?PromiseInterface
    {
        $params = [];

        if (isset($options['scope'])) {
            $params['scope'] = json_encode($options['scope']);
        }

        $promise = $this->requestAsync('getMyCommands', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the bot's name (synchronous).
     * Use this method to change the bot's name.
     *
     * @param string $name New bot name, 0-64 characters.
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function setMyName(string $name, array $options = []): array
    {
        $params = [
            'name' => $name,
        ];

        return $this->request('setMyName', array_merge($params, $options));
    }

    /**
     * Sets the bot's name (asynchronous).
     * Use this method to change the bot's name in an async manner (Guzzle only).
     *
     * @param string $name New bot name, 0-64 characters.
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function setMyNameAsync(string $name, array $options = []): ?PromiseInterface
    {
        $params = [
            'name' => $name,
        ];

        $promise = $this->requestAsync('setMyName', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the bot's name (synchronous).
     * Use this method to get the current name of the bot.
     *
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return array The response from Telegram containing the bot's name (['ok' => true, 'result' => ['name' => 'BotName']]).
     * @throws Exception If the request fails.
     */
    public function getMyName(array $options = []): array
    {
        return $this->request('getMyName', $options);
    }

    /**
     * Gets the bot's name (asynchronous).
     * Use this method to get the current name of the bot in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getMyNameAsync(array $options = []): ?PromiseInterface
    {
        $promise = $this->requestAsync('getMyName', $options);
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the bot's description (synchronous).
     * Use this method to change the bot's description, which is shown in the chat with the bot if the chat is empty.
     *
     * @param string $description New bot description, 0-512 characters.
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function setMyDescription(string $description, array $options = []): array
    {
        $params = [
            'description' => $description,
        ];

        return $this->request('setMyDescription', array_merge($params, $options));
    }

    /**
     * Sets the bot's description (asynchronous).
     * Use this method to change the bot's description in an async manner (Guzzle only).
     *
     * @param string $description New bot description, 0-512 characters.
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function setMyDescriptionAsync(string $description, array $options = []): ?PromiseInterface
    {
        $params = [
            'description' => $description,
        ];

        $promise = $this->requestAsync('setMyDescription', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the bot's description (synchronous).
     * Use this method to get the current description of the bot.
     *
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return array The response from Telegram containing the bot's description (['ok' => true, 'result' => ['description' => 'Bot description']]).
     * @throws Exception If the request fails.
     */
    public function getMyDescription(array $options = []): array
    {
        return $this->request('getMyDescription', $options);
    }

    /**
     * Gets the bot's description (asynchronous).
     * Use this method to get the current description of the bot in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getMyDescriptionAsync(array $options = []): ?PromiseInterface
    {
        $promise = $this->requestAsync('getMyDescription', $options);
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the bot's short description (synchronous).
     * Use this method to change the bot's short description, which is shown on the bot's profile page and is sent together with the link when users share the bot.
     *
     * @param string $shortDescription New short description for the bot, 0-120 characters.
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function setMyShortDescription(string $shortDescription, array $options = []): array
    {
        $params = [
            'short_description' => $shortDescription,
        ];

        return $this->request('setMyShortDescription', array_merge($params, $options));
    }

    /**
     * Sets the bot's short description (asynchronous).
     * Use this method to change the bot's short description in an async manner (Guzzle only).
     *
     * @param string $shortDescription New short description for the bot, 0-120 characters.
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails or required parameters are missing.
     */
    public function setMyShortDescriptionAsync(string $shortDescription, array $options = []): ?PromiseInterface
    {
        $params = [
            'short_description' => $shortDescription,
        ];

        $promise = $this->requestAsync('setMyShortDescription', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the bot's short description (synchronous).
     * Use this method to get the current short description of the bot.
     *
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return array The response from Telegram containing the bot's short description (['ok' => true, 'result' => ['short_description' => 'Short description']]).
     * @throws Exception If the request fails.
     */
    public function getMyShortDescription(array $options = []): array
    {
        return $this->request('getMyShortDescription', $options);
    }

    /**
     * Gets the bot's short description (asynchronous).
     * Use this method to get the current short description of the bot in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters:
     *                       - language_code (string): A two-letter ISO 639-1 language code.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getMyShortDescriptionAsync(array $options = []): ?PromiseInterface
    {
        $promise = $this->requestAsync('getMyShortDescription', $options);
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the chat menu button (synchronous).
     * Use this method to change the bot's menu button in a private chat, or the default menu button.
     *
     * @param array $options Optional parameters:
     *                       - chat_id (int|string): Unique identifier for the target private chat. If not specified, the default bot's menu button will be changed.
     *                       - menu_button (array): A JSON-serialized object for the new menu button (e.g., ['type' => 'commands'] or ['type' => 'web_app', 'text' => 'Open', 'web_app' => ['url' => 'https://example.com']]).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception If the request fails.
     */
    public function setChatMenuButton(array $options = []): array
    {
        $params = [];

        if (isset($options['menu_button'])) {
            $params['menu_button'] = json_encode($options['menu_button']);
        }

        return $this->request('setChatMenuButton', array_merge($params, $options));
    }

    /**
     * Sets the chat menu button (asynchronous).
     * Use this method to change the bot's menu button in a private chat, or the default menu button, in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters:
     *                       - chat_id (int|string): Unique identifier for the target private chat. If not specified, the default bot's menu button will be changed.
     *                       - menu_button (array): A JSON-serialized object for the new menu button (e.g., ['type' => 'commands'] or ['type' => 'web_app', 'text' => 'Open', 'web_app' => ['url' => 'https://example.com']]).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setChatMenuButtonAsync(array $options = []): ?PromiseInterface
    {
        $params = [];

        if (isset($options['menu_button'])) {
            $params['menu_button'] = json_encode($options['menu_button']);
        }

        $promise = $this->requestAsync('setChatMenuButton', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the chat menu button (synchronous).
     * Use this method to get the current value of the bot's menu button in a private chat, or the default menu button.
     *
     * @param array $options Optional parameters:
     *                       - chat_id (int|string): Unique identifier for the target private chat. If not specified, the default bot's menu button will be returned.
     * @return array The response from Telegram containing the current menu button (['ok' => true, 'result' => MenuButton]).
     * @throws Exception If the request fails.
     */
    public function getChatMenuButton(array $options = []): array
    {
        return $this->request('getChatMenuButton', $options);
    }

    /**
     * Gets the chat menu button (asynchronous).
     * Use this method to get the current value of the bot's menu button in a private chat, or the default menu button, in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters:
     *                       - chat_id (int|string): Unique identifier for the target private chat. If not specified, the default bot's menu button will be returned.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getChatMenuButtonAsync(array $options = []): ?PromiseInterface
    {
        $promise = $this->requestAsync('getChatMenuButton', $options);
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the bot's default administrator rights (synchronous).
     * Use this method to change the default administrator rights requested by the bot when it's added as an administrator to groups or channels.
     *
     * @param array $options Optional parameters:
     *                       - rights (array): A JSON-serialized object describing new default administrator rights (e.g., ['can_manage_chat' => true, 'can_delete_messages' => true]).
     *                       - for_channels (bool): Pass True to change the rights for channels instead of groups.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception If the request fails.
     */
    public function setMyDefaultAdministratorRights(array $options = []): array
    {
        $params = [];

        if (isset($options['rights'])) {
            $params['rights'] = json_encode($options['rights']);
        }

        return $this->request('setMyDefaultAdministratorRights', array_merge($params, $options));
    }

    /**
     * Sets the bot's default administrator rights (asynchronous).
     * Use this method to change the default administrator rights requested by the bot in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters:
     *                       - rights (array): A JSON-serialized object describing new default administrator rights (e.g., ['can_manage_chat' => true, 'can_delete_messages' => true]).
     *                       - for_channels (bool): Pass True to change the rights for channels instead of groups.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setMyDefaultAdministratorRightsAsync(array $options = []): ?PromiseInterface
    {
        $params = [];

        if (isset($options['rights'])) {
            $params['rights'] = json_encode($options['rights']);
        }

        $promise = $this->requestAsync('setMyDefaultAdministratorRights', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the bot's default administrator rights (synchronous).
     * Use this method to get the current default administrator rights of the bot.
     *
     * @param array $options Optional parameters:
     *                       - for_channels (bool): Pass True to get the rights for channels instead of groups.
     * @return array The response from Telegram containing the current default administrator rights (['ok' => true, 'result' => ChatAdministratorRights]).
     * @throws Exception If the request fails.
     */
    public function getMyDefaultAdministratorRights(array $options = []): array
    {
        return $this->request('getMyDefaultAdministratorRights', $options);
    }

    /**
     * Gets the bot's default administrator rights (asynchronous).
     * Use this method to get the current default administrator rights of the bot in an async manner (Guzzle only).
     *
     * @param array $options Optional parameters:
     *                       - for_channels (bool): Pass True to get the rights for channels instead of groups.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getMyDefaultAdministratorRightsAsync(array $options = []): ?PromiseInterface
    {
        $promise = $this->requestAsync('getMyDefaultAdministratorRights', $options);
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}