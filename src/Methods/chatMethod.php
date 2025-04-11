<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Trait for handling Telegram Bot API chat-related methods.
 * Provides methods to manage chat members, permissions, settings, and invite links.
 * Based on Telegram Bot API version 7.3.
 */
trait chatMethod
{
    /**
     * Bans a user from a chat (synchronous).
     * Use this method to ban a user from a group, supergroup, or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - until_date (int): Date when the user will be unbanned (Unix timestamp). If 0 or omitted, the ban is permanent.
     *                       - revoke_messages (bool): Pass true to delete all messages from the user in the chat. Defaults to false.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function banChatMember(int|string $chatId, int $userId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        return $this->request('banChatMember', array_merge($params, $options));
    }

    /**
     * Bans a user from a chat (asynchronous).
     * Use this method to ban a user from a group, supergroup, or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - until_date (int): Date when the user will be unbanned (Unix timestamp). If 0 or omitted, the ban is permanent.
     *                       - revoke_messages (bool): Pass true to delete all messages from the user in the chat. Defaults to false.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function banChatMemberAsync(int|string $chatId, int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('banChatMember', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Unbans a user from a chat (synchronous).
     * Use this method to unban a previously banned user in a supergroup or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - only_if_banned (bool): Pass true to unban only if the user is currently banned. Defaults to false.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function unbanChatMember(int|string $chatId, int $userId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        return $this->request('unbanChatMember', array_merge($params, $options));
    }

    /**
     * Unbans a user from a chat (asynchronous).
     * Use this method to unban a previously banned user in a supergroup or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - only_if_banned (bool): Pass true to unban only if the user is currently banned. Defaults to false.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function unbanChatMemberAsync(int|string $chatId, int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('unbanChatMember', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Restricts a user in a chat (synchronous).
     * Use this method to restrict a user in a supergroup. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $permissions A JSON-serializable array for new user permissions (e.g., ['can_send_messages' => false, 'can_send_media_messages' => false]).
     * @param array $options Optional parameters:
     *                       - use_independent_chat_permissions (bool): Pass true if chat permissions are set independently. Defaults to false.
     *                       - until_date (int): Date when restrictions will be lifted (Unix timestamp). If 0 or omitted, the restrictions are permanent.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function restrictChatMember(int|string $chatId, int $userId, array $permissions, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'permissions' => json_encode($permissions),
        ];

        return $this->request('restrictChatMember', array_merge($params, $options));
    }

    /**
     * Restricts a user in a chat (asynchronous).
     * Use this method to restrict a user in a supergroup in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $permissions A JSON-serializable array for new user permissions (e.g., ['can_send_messages' => false, 'can_send_media_messages' => false]).
     * @param array $options Optional parameters:
     *                       - use_independent_chat_permissions (bool): Pass true if chat permissions are set independently. Defaults to false.
     *                       - until_date (int): Date when restrictions will be lifted (Unix timestamp). If 0 or omitted, the restrictions are permanent.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function restrictChatMemberAsync(int|string $chatId, int $userId, array $permissions, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'permissions' => json_encode($permissions),
        ];

        $promise = $this->requestAsync('restrictChatMember', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Promotes a user in a chat (synchronous).
     * Use this method to promote or demote a user in a supergroup or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - is_anonymous (bool): Pass true to promote the user anonymously. Defaults to false.
     *                       - can_manage_chat (bool): Pass true to allow the user to manage the chat. Defaults to false.
     *                       - can_post_messages (bool): Pass true to allow the user to post messages (channels only). Defaults to false.
     *                       - can_edit_messages (bool): Pass true to allow the user to edit messages (channels only). Defaults to false.
     *                       - can_delete_messages (bool): Pass true to allow the user to delete messages. Defaults to false.
     *                       - can_manage_video_chats (bool): Pass true to allow the user to manage video chats. Defaults to false.
     *                       - can_restrict_members (bool): Pass true to allow the user to restrict members. Defaults to false.
     *                       - can_promote_members (bool): Pass true to allow the user to promote other members. Defaults to false.
     *                       - can_change_info (bool): Pass true to allow the user to change chat info. Defaults to false.
     *                       - can_invite_users (bool): Pass true to allow the user to invite users. Defaults to false.
     *                       - can_pin_messages (bool): Pass true to allow the user to pin messages. Defaults to false.
     *                       - can_manage_topics (bool): Pass true to allow the user to manage topics. Defaults to false.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function promoteChatMember(int|string $chatId, int $userId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        return $this->request('promoteChatMember', array_merge($params, $options));
    }

    /**
     * Promotes a user in a chat (asynchronous).
     * Use this method to promote or demote a user in a supergroup or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - is_anonymous (bool): Pass true to promote the user anonymously. Defaults to false.
     *                       - can_manage_chat (bool): Pass true to allow the user to manage the chat. Defaults to false.
     *                       - can_post_messages (bool): Pass true to allow the user to post messages (channels only). Defaults to false.
     *                       - can_edit_messages (bool): Pass true to allow the user to edit messages (channels only). Defaults to false.
     *                       - can_delete_messages (bool): Pass true to allow the user to delete messages. Defaults to false.
     *                       - can_manage_video_chats (bool): Pass true to allow the user to manage video chats. Defaults to false.
     *                       - can_restrict_members (bool): Pass true to allow the user to restrict members. Defaults to false.
     *                       - can_promote_members (bool): Pass true to allow the user to promote other members. Defaults to false.
     *                       - can_change_info (bool): Pass true to allow the user to change chat info. Defaults to false.
     *                       - can_invite_users (bool): Pass true to allow the user to invite users. Defaults to false.
     *                       - can_pin_messages (bool): Pass true to allow the user to pin messages. Defaults to false.
     *                       - can_manage_topics (bool): Pass true to allow the user to manage topics. Defaults to false.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function promoteChatMemberAsync(int|string $chatId, int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('promoteChatMember', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Bans a sender chat in a chat (synchronous).
     * Use this method to ban a sender chat in a supergroup or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $senderChatId Unique identifier of the sender chat to ban.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function banChatSenderChat(int|string $chatId, int $senderChatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'sender_chat_id' => $senderChatId,
        ];

        return $this->request('banChatSenderChat', array_merge($params, $options));
    }

    /**
     * Bans a sender chat in a chat (asynchronous).
     * Use this method to ban a sender chat in a supergroup or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $senderChatId Unique identifier of the sender chat to ban.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function banChatSenderChatAsync(int|string $chatId, int $senderChatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'sender_chat_id' => $senderChatId,
        ];

        $promise = $this->requestAsync('banChatSenderChat', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Unbans a sender chat in a chat (synchronous).
     * Use this method to unban a previously banned sender chat in a supergroup or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $senderChatId Unique identifier of the sender chat to unban.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function unbanChatSenderChat(int|string $chatId, int $senderChatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'sender_chat_id' => $senderChatId,
        ];

        return $this->request('unbanChatSenderChat', array_merge($params, $options));
    }

    /**
     * Unbans a sender chat in a chat (asynchronous).
     * Use this method to unban a previously banned sender chat in a supergroup or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $senderChatId Unique identifier of the sender chat to unban.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function unbanChatSenderChatAsync(int|string $chatId, int $senderChatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'sender_chat_id' => $senderChatId,
        ];

        $promise = $this->requestAsync('unbanChatSenderChat', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Exports an invite link for a chat (synchronous).
     * Use this method to generate a new primary invite link for a chat. The previously generated link is revoked. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the new invite link (['ok' => true, 'result' => string]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function exportChatInviteLink(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('exportChatInviteLink', array_merge($params, $options));
    }

    /**
     * Exports an invite link for a chat (asynchronous).
     * Use this method to generate a new primary invite link for a chat in an async manner (Guzzle only). The previously generated link is revoked. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function exportChatInviteLinkAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('exportChatInviteLink', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Creates an invite link for a chat (synchronous).
     * Use this method to create an additional invite link for a chat. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters:
     *                       - name (string): Invite link name; 0-32 characters.
     *                       - expire_date (int): Point in time (Unix timestamp) when the link will expire.
     *                       - member_limit (int): Maximum number of users that can join using this link; 1-99999.
     *                       - creates_join_request (bool): Pass true if users joining via the link need to be approved by admins. Defaults to false.
     * @return array The response from Telegram containing the new invite link (['ok' => true, 'result' => ChatInviteLink]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function createChatInviteLink(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('createChatInviteLink', array_merge($params, $options));
    }

    /**
     * Creates an invite link for a chat (asynchronous).
     * Use this method to create an additional invite link for a chat in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters:
     *                       - name (string): Invite link name; 0-32 characters.
     *                       - expire_date (int): Point in time (Unix timestamp) when the link will expire.
     *                       - member_limit (int): Maximum number of users that can join using this link; 1-99999.
     *                       - creates_join_request (bool): Pass true if users joining via the link need to be approved by admins. Defaults to false.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function createChatInviteLinkAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('createChatInviteLink', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Edits an invite link for a chat (synchronous).
     * Use this method to edit a non-primary invite link created by the bot. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $inviteLink The invite link to edit.
     * @param array $options Optional parameters:
     *                       - name (string): Invite link name; 0-32 characters.
     *                       - expire_date (int): Point in time (Unix timestamp) when the link will expire.
     *                       - member_limit (int): Maximum number of users that can join using this link; 1-99999.
     *                       - creates_join_request (bool): Pass true if users joining via the link need to be approved by admins. Defaults to false.
     * @return array The response from Telegram containing the edited invite link (['ok' => true, 'result' => ChatInviteLink]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editChatInviteLink(int|string $chatId, string $inviteLink, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ];

        return $this->request('editChatInviteLink', array_merge($params, $options));
    }

    /**
     * Edits an invite link for a chat (asynchronous).
     * Use this method to edit a non-primary invite link created by the bot in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $inviteLink The invite link to edit.
     * @param array $options Optional parameters:
     *                       - name (string): Invite link name; 0-32 characters.
     *                       - expire_date (int): Point in time (Unix timestamp) when the link will expire.
     *                       - member_limit (int): Maximum number of users that can join using this link; 1-99999.
     *                       - creates_join_request (bool): Pass true if users joining via the link need to be approved by admins. Defaults to false.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function editChatInviteLinkAsync(int|string $chatId, string $inviteLink, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ];

        $promise = $this->requestAsync('editChatInviteLink', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets permissions for a chat (synchronous).
     * Use this method to set default chat permissions for all members. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $permissions A JSON-serializable array for new default chat permissions (e.g., ['can_send_messages' => true, 'can_send_media_messages' => false]).
     * @param array $options Optional parameters:
     *                       - use_independent_chat_permissions (bool): Pass true if permissions are set independently for different chat types. Defaults to false.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setChatPermissions(int|string $chatId, array $permissions, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'permissions' => json_encode($permissions),
        ];

        return $this->request('setChatPermissions', array_merge($params, $options));
    }

    /**
     * Sets permissions for a chat (asynchronous).
     * Use this method to set default chat permissions for all members in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param array $permissions A JSON-serializable array for new default chat permissions (e.g., ['can_send_messages' => true, 'can_send_media_messages' => false]).
     * @param array $options Optional parameters:
     *                       - use_independent_chat_permissions (bool): Pass true if permissions are set independently for different chat types. Defaults to false.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setChatPermissionsAsync(int|string $chatId, array $permissions, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'permissions' => json_encode($permissions),
        ];

        $promise = $this->requestAsync('setChatPermissions', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets a custom title for an administrator in a chat (synchronous).
     * Use this method to set a custom title for an administrator in a supergroup. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $userId Unique identifier of the target user.
     * @param string $customTitle New custom title for the administrator; 0-16 characters, emoji are not allowed.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setChatAdministratorCustomTitle(int|string $chatId, int $userId, string $customTitle, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'custom_title' => $customTitle,
        ];

        return $this->request('setChatAdministratorCustomTitle', array_merge($params, $options));
    }

    /**
     * Sets a custom title for an administrator in a chat (asynchronous).
     * Use this method to set a custom title for an administrator in a supergroup in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $userId Unique identifier of the target user.
     * @param string $customTitle New custom title for the administrator; 0-16 characters, emoji are not allowed.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setChatAdministratorCustomTitleAsync(int|string $chatId, int $userId, string $customTitle, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'custom_title' => $customTitle,
        ];

        $promise = $this->requestAsync('setChatAdministratorCustomTitle', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Creates a subscription invite link for a chat (synchronous).
     * Use this method to create a subscription invite link for a chat with a subscription fee. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $subscriptionPeriod The number of seconds the subscription will be active for before the next payment.
     * @param int $subscriptionPrice The amount of Telegram Stars a user must pay to join the chat for the specified period.
     * @param array $options Optional parameters:
     *                       - name (string): Invite link name; 0-32 characters.
     * @return array The response from Telegram containing the new invite link (['ok' => true, 'result' => ChatInviteLink]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function createChatSubscriptionInviteLink(int|string $chatId, int $subscriptionPeriod, int $subscriptionPrice, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'subscription_period' => $subscriptionPeriod,
            'subscription_price' => $subscriptionPrice,
        ];

        return $this->request('createChatSubscriptionInviteLink', array_merge($params, $options));
    }

    /**
     * Creates a subscription invite link for a chat (asynchronous).
     * Use this method to create a subscription invite link for a chat with a subscription fee in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param int $subscriptionPeriod The number of seconds the subscription will be active for before the next payment.
     * @param int $subscriptionPrice The amount of Telegram Stars a user must pay to join the chat for the specified period.
     * @param array $options Optional parameters:
     *                       - name (string): Invite link name; 0-32 characters.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function createChatSubscriptionInviteLinkAsync(int|string $chatId, int $subscriptionPeriod, int $subscriptionPrice, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'subscription_period' => $subscriptionPeriod,
            'subscription_price' => $subscriptionPrice,
        ];

        $promise = $this->requestAsync('createChatSubscriptionInviteLink', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Edits a subscription invite link for a chat (synchronous).
     * Use this method to edit a subscription invite link created by the bot. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param string $inviteLink The invite link to edit.
     * @param array $options Optional parameters:
     *                       - name (string): Invite link name; 0-32 characters.
     * @return array The response from Telegram containing the edited invite link (['ok' => true, 'result' => ChatInviteLink]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function editChatSubscriptionInviteLink(int|string $chatId, string $inviteLink, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ];

        return $this->request('editChatSubscriptionInviteLink', array_merge($params, $options));
    }

    /**
     * Edits a subscription invite link for a chat (asynchronous).
     * Use this method to edit a subscription invite link created by the bot in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername).
     * @param string $inviteLink The invite link to edit.
     * @param array $options Optional parameters:
     *                       - name (string): Invite link name; 0-32 characters.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function editChatSubscriptionInviteLinkAsync(int|string $chatId, string $inviteLink, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ];

        $promise = $this->requestAsync('editChatSubscriptionInviteLink', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Revokes an invite link for a chat (synchronous).
     * Use this method to revoke an invite link created by the bot. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $inviteLink The invite link to revoke.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram containing the revoked invite link (['ok' => true, 'result' => ChatInviteLink]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function revokeChatInviteLink(int|string $chatId, string $inviteLink, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ];

        return $this->request('revokeChatInviteLink', array_merge($params, $options));
    }

    /**
     * Revokes an invite link for a chat (asynchronous).
     * Use this method to revoke an invite link created by the bot in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $inviteLink The invite link to revoke.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function revokeChatInviteLinkAsync(int|string $chatId, string $inviteLink, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ];

        $promise = $this->requestAsync('revokeChatInviteLink', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Approves a chat join request (synchronous).
     * Use this method to approve a chat join request. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the user whose join request will be approved.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function approveChatJoinRequest(int|string $chatId, int $userId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        return $this->request('approveChatJoinRequest', array_merge($params, $options));
    }

    /**
     * Approves a chat join request (asynchronous).
     * Use this method to approve a chat join request in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the user whose join request will be approved.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function approveChatJoinRequestAsync(int|string $chatId, int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('approveChatJoinRequest', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Declines a chat join request (synchronous).
     * Use this method to decline a chat join request. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the user whose join request will be declined.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function declineChatJoinRequest(int|string $chatId, int $userId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        return $this->request('declineChatJoinRequest', array_merge($params, $options));
    }

    /**
     * Declines a chat join request (asynchronous).
     * Use this method to decline a chat join request in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $userId Unique identifier of the user whose join request will be declined.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function declineChatJoinRequestAsync(int|string $chatId, int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('declineChatJoinRequest', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets a photo for a chat (synchronous).
     * Use this method to set a new profile photo for the chat. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $photo Path to the new chat photo file (must be a file path for upload).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setChatPhoto(int|string $chatId, string $photo, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'photo' => $photo,
        ];

        return $this->request('setChatPhoto', array_merge($params, $options));
    }

    /**
     * Sets a photo for a chat (asynchronous).
     * Use this method to set a new profile photo for the chat in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $photo Path to the new chat photo file (must be a file path for upload).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setChatPhotoAsync(int|string $chatId, string $photo, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'photo' => $photo,
        ];

        $promise = $this->requestAsync('setChatPhoto', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Deletes the photo of a chat (synchronous).
     * Use this method to delete a chat's profile photo. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function deleteChatPhoto(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('deleteChatPhoto', array_merge($params, $options));
    }

    /**
     * Deletes the photo of a chat (asynchronous).
     * Use this method to delete a chat's profile photo in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function deleteChatPhotoAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('deleteChatPhoto', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the title of a chat (synchronous).
     * Use this method to change the title of a chat. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $title New chat title, 1-128 characters.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setChatTitle(int|string $chatId, string $title, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'title' => $title,
        ];

        return $this->request('setChatTitle', array_merge($params, $options));
    }

    /**
     * Sets the title of a chat (asynchronous).
     * Use this method to change the title of a chat in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $title New chat title, 1-128 characters.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setChatTitleAsync(int|string $chatId, string $title, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'title' => $title,
        ];

        $promise = $this->requestAsync('setChatTitle', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets the description of a chat (synchronous).
     * Use this method to change the description of a supergroup or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string|null $description New chat description, 0-255 characters (pass null to remove the description).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setChatDescription(int|string $chatId, ?string $description = null, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];
        if ($description !== null) {
            $params['description'] = $description;
        }

        return $this->request('setChatDescription', array_merge($params, $options));
    }

    /**
     * Sets the description of a chat (asynchronous).
     * Use this method to change the description of a supergroup or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string|null $description New chat description, 0-255 characters (pass null to remove the description).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setChatDescriptionAsync(int|string $chatId, ?string $description = null, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];
        if ($description !== null) {
            $params['description'] = $description;
        }

        $promise = $this->requestAsync('setChatDescription', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Pins a message in a chat (synchronous).
     * Use this method to pin a message in a group, supergroup, or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to pin.
     * @param array $options Optional parameters:
     *                       - disable_notification (bool): Pass true to pin the message silently. Defaults to false.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function pinChatMessage(int|string $chatId, int $messageId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        return $this->request('pinChatMessage', array_merge($params, $options));
    }

    /**
     * Pins a message in a chat (asynchronous).
     * Use this method to pin a message in a group, supergroup, or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to pin.
     * @param array $options Optional parameters:
     *                       - disable_notification (bool): Pass true to pin the message silently. Defaults to false.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function pinChatMessageAsync(int|string $chatId, int $messageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        $promise = $this->requestAsync('pinChatMessage', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Unpins a message in a chat (synchronous).
     * Use this method to unpin a message in a group, supergroup, or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to unpin.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function unpinChatMessage(int|string $chatId, int $messageId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        return $this->request('unpinChatMessage', array_merge($params, $options));
    }

    /**
     * Unpins a message in a chat (asynchronous).
     * Use this method to unpin a message in a group, supergroup, or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param int $messageId Identifier of the message to unpin.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function unpinChatMessageAsync(int|string $chatId, int $messageId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        $promise = $this->requestAsync('unpinChatMessage', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Unpins all messages in a chat (synchronous).
     * Use this method to unpin all pinned messages in a group, supergroup, or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function unpinAllChatMessages(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('unpinAllChatMessages', array_merge($params, $options));
    }

    /**
     * Unpins all messages in a chat (asynchronous).
     * Use this method to unpin all pinned messages in a group, supergroup, or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function unpinAllChatMessagesAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('unpinAllChatMessages', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Leaves a chat (synchronous).
     * Use this method for the bot to leave a group, supergroup, or channel.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function leaveChat(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('leaveChat', array_merge($params, $options));
    }

    /**
     * Leaves a chat (asynchronous).
     * Use this method for the bot to leave a group, supergroup, or channel in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function leaveChatAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('leaveChat', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Verifies a user in a chat (synchronous).
     * Use this method to verify a user on behalf of the organization which is represented by the bot. The bot must have appropriate permissions.
     *
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - custom_description (string): Custom description for the verification; 0-70 characters. Must be empty if the organization isn't allowed to provide a custom verification description.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function verifyUser(int $userId, array $options = []): array
    {
        $params = [
            'user_id' => $userId,
        ];

        return $this->request('verifyUser', array_merge($params, $options));
    }

    /**
     * Verifies a user in a chat (asynchronous).
     * Use this method to verify a user on behalf of the organization which is represented by the bot in an async manner (Guzzle only). The bot must have appropriate permissions.
     *
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters:
     *                       - custom_description (string): Custom description for the verification; 0-70 characters. Must be empty if the organization isn't allowed to provide a custom verification description.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function verifyUserAsync(int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('verifyUser', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Verifies a chat (synchronous).
     * Use this method to verify a chat on behalf of the organization which is represented by the bot. The bot must have appropriate permissions.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $options Optional parameters:
     *                       - custom_description (string): Custom description for the verification; 0-70 characters. Must be empty if the organization isn't allowed to provide a custom verification description.
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function verifyChat(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('verifyChat', array_merge($params, $options));
    }

    /**
     * Verifies a chat (asynchronous).
     * Use this method to verify a chat on behalf of the organization which is represented by the bot in an async manner (Guzzle only). The bot must have appropriate permissions.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $options Optional parameters:
     *                       - custom_description (string): Custom description for the verification; 0-70 characters. Must be empty if the organization isn't allowed to provide a custom verification description.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function verifyChatAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('verifyChat', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Removes verification from a user (synchronous).
     * Use this method to remove verification from a user who is currently verified on behalf of the organization represented by the bot. The bot must have appropriate permissions.
     *
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function removeUserVerification(int $userId, array $options = []): array
    {
        $params = [
            'user_id' => $userId,
        ];

        return $this->request('removeUserVerification', array_merge($params, $options));
    }

    /**
     * Removes verification from a user (asynchronous).
     * Use this method to remove verification from a user who is currently verified on behalf of the organization represented by the bot in an async manner (Guzzle only). The bot must have appropriate permissions.
     *
     * @param int $userId Unique identifier of the target user.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function removeUserVerificationAsync(int $userId, array $options = []): ?PromiseInterface
    {
        $params = [
            'user_id' => $userId,
        ];

        $promise = $this->requestAsync('removeUserVerification', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Removes verification from a chat (synchronous).
     * Use this method to remove verification from a chat that is currently verified on behalf of the organization represented by the bot. The bot must have appropriate permissions.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function removeChatVerification(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('removeChatVerification', array_merge($params, $options));
    }

    /**
     * Removes verification from a chat (asynchronous).
     * Use this method to remove verification from a chat that is currently verified on behalf of the organization represented by the bot in an async manner (Guzzle only). The bot must have appropriate permissions.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function removeChatVerificationAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('removeChatVerification', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Sets a sticker set for a chat (synchronous).
     * Use this method to set a sticker set for a supergroup or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $stickerSetName Name of the sticker set to set for the chat.
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function setChatStickerSet(int|string $chatId, string $stickerSetName, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'sticker_set_name' => $stickerSetName,
        ];

        return $this->request('setChatStickerSet', array_merge($params, $options));
    }

    /**
     * Sets a sticker set for a chat (asynchronous).
     * Use this method to set a sticker set for a supergroup or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param string $stickerSetName Name of the sticker set to set for the chat.
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function setChatStickerSetAsync(int|string $chatId, string $stickerSetName, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'sticker_set_name' => $stickerSetName,
        ];

        $promise = $this->requestAsync('setChatStickerSet', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Deletes the sticker set of a chat (synchronous).
     * Use this method to delete the sticker set of a supergroup or channel. The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return array The response from Telegram (usually ['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function deleteChatStickerSet(int|string $chatId, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
        ];

        return $this->request('deleteChatStickerSet', array_merge($params, $options));
    }

    /**
     * Deletes the sticker set of a chat (asynchronous).
     * Use this method to delete the sticker set of a supergroup or channel in an async manner (Guzzle only). The bot must be an administrator in the chat with appropriate rights.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target supergroup/channel (in the format @channelusername).
     * @param array $options Optional parameters (currently none).
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function deleteChatStickerSetAsync(int|string $chatId, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
        ];

        $promise = $this->requestAsync('deleteChatStickerSet', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Gets the list of chat members who joined via a specific invite link (synchronous).
     * Use this method to retrieve the list of users who joined a chat using a specific invite link.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $inviteLink The invite link to filter members by.
     * @param array $options Optional parameters:
     *                       - offset (int): Offset of the first member to return; defaults to 0.
     *                       - limit (int): Maximum number of members to return; 1-100, defaults to 100.
     * @return array The response from Telegram containing an array of ChatInviteLinkMember objects (['ok' => true, 'result' => [ChatInviteLinkMember]]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function getChatInviteLinkMembers(int|string $chatId, string $inviteLink, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ];

        return $this->request('getChatInviteLinkMembers', array_merge($params, $options));
    }

    /**
     * Gets the list of chat members who joined via a specific invite link (asynchronous).
     * Use this method to retrieve the list of users who joined a chat using a specific invite link in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $inviteLink The invite link to filter members by.
     * @param array $options Optional parameters:
     *                       - offset (int): Offset of the first member to return; defaults to 0.
     *                       - limit (int): Maximum number of members to return; 1-100, defaults to 100.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function getChatInviteLinkMembersAsync(int|string $chatId, string $inviteLink, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink,
        ];

        $promise = $this->requestAsync('getChatInviteLinkMembers', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}