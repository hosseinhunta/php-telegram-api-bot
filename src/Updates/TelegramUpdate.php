<?php

namespace Hosseinhunta\PhpTelegramBotApi\Updates;

use Hosseinhunta\PhpTelegramBotApi\Core\Exception\ValidationException;

/**
 * Class representing a single Telegram update with comprehensive support for all update types.
 */
class TelegramUpdate
{
    private array $data;

    public function __construct(array $data)
    {
        if (empty($data) || !isset($data['update_id'])) {
            throw new ValidationException("Invalid update data: update_id is missing or data is empty.");
        }
        $this->data = $data;
    }

    /**
     * Gets the update ID.
     *
     * @return int The update ID.
     * @throws ValidationException If update_id is invalid.
     */
    public function getUpdateId(): int
    {
        $updateId = filter_var($this->data['update_id'], FILTER_VALIDATE_INT);
        if ($updateId === false) {
            throw new ValidationException("Invalid update_id format.");
        }
        return $updateId;
    }

    /**
     * Gets the message from the update, if available.
     *
     * @return array|null The message data or null if not present.
     */
    public function getMessage(): ?array
    {
        return $this->data['message'] ?? null;
    }

    /**
     * Gets the edited message from the update, if available.
     *
     * @return array|null The edited message data or null if not present.
     */
    public function getEditedMessage(): ?array
    {
        return $this->data['edited_message'] ?? null;
    }

    /**
     * Gets the channel post from the update, if available.
     *
     * @return array|null The channel post data or null if not present.
     */
    public function getChannelPost(): ?array
    {
        return $this->data['channel_post'] ?? null;
    }

    /**
     * Gets the edited channel post from the update, if available.
     *
     * @return array|null The edited channel post data or null if not present.
     */
    public function getEditedChannelPost(): ?array
    {
        return $this->data['edited_channel_post'] ?? null;
    }

    /**
     * Gets the inline query from the update, if available.
     *
     * @return array|null The inline query data or null if not present.
     */
    public function getInlineQuery(): ?array
    {
        return $this->data['inline_query'] ?? null;
    }

    /**
     * Gets the chosen inline result from the update, if available.
     *
     * @return array|null The chosen inline result data or null if not present.
     */
    public function getChosenInlineResult(): ?array
    {
        return $this->data['chosen_inline_result'] ?? null;
    }

    /**
     * Gets the callback query from the update, if available.
     *
     * @return array|null The callback query data or null if not present.
     */
    public function getCallbackQuery(): ?array
    {
        return $this->data['callback_query'] ?? null;
    }

    /**
     * Gets the shipping query from the update, if available.
     *
     * @return array|null The shipping query data or null if not present.
     */
    public function getShippingQuery(): ?array
    {
        return $this->data['shipping_query'] ?? null;
    }

    /**
     * Gets the pre-checkout query from the update, if available.
     *
     * @return array|null The pre-checkout query data or null if not present.
     */
    public function getPreCheckoutQuery(): ?array
    {
        return $this->data['pre_checkout_query'] ?? null;
    }

    /**
     * Gets the poll from the update, if available.
     *
     * @return array|null The poll data or null if not present.
     */
    public function getPoll(): ?array
    {
        return $this->data['poll'] ?? null;
    }

    /**
     * Gets the poll answer from the update, if available.
     *
     * @return array|null The poll answer data or null if not present.
     */
    public function getPollAnswer(): ?array
    {
        return $this->data['poll_answer'] ?? null;
    }

    /**
     * Gets the chat member update from the update, if available.
     *
     * @return array|null The chat member update data or null if not present.
     */
    public function getChatMember(): ?array
    {
        return $this->data['chat_member'] ?? null;
    }

    /**
     * Gets the my chat member update from the update, if available.
     *
     * @return array|null The my chat member update data or null if not present.
     */
    public function getMyChatMember(): ?array
    {
        return $this->data['my_chat_member'] ?? null;
    }

    /**
     * Gets the chat join request from the update, if available.
     *
     * @return array|null The chat join request data or null if not present.
     */
    public function getChatJoinRequest(): ?array
    {
        return $this->data['chat_join_request'] ?? null;
    }

    /**
     * Gets the raw update data.
     *
     * @return array The raw update data.
     */
    public function getRawData(): array
    {
        return $this->data;
    }

    /**
     * Gets a specific field from the update using dot notation.
     *
     * @param string $path The path to the field (e.g., 'message.text').
     * @param mixed|null $default Default value if field is not found.
     * @return mixed The field value or default if not present.
     */
    public function getField(string $path, mixed $default = null)
    {
        $keys = explode('.', $path);
        $value = $this->data;

        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                return $default;
            }
            $value = $value[$key];
        }

        return $value;
    }
}