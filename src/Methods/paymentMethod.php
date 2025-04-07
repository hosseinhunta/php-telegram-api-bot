<?php

namespace Hosseinhunta\PhpTelegramBotApi\Methods;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Trait for handling Telegram Bot API payment-related methods.
 * Provides methods to send invoices and handle payment queries.
 * Based on Telegram Bot API version 7.3.
 */
trait paymentMethod
{
    /**
     * Sends an invoice (synchronous).
     * Use this method to send an invoice to a user.
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $title Product name, 1-32 characters.
     * @param string $description Product description, 1-255 characters.
     * @param string $payload Bot-defined invoice payload, 1-128 bytes.
     * @param string $currency Three-letter ISO 4217 currency code (e.g., 'USD').
     * @param array $prices Array of LabeledPrice objects (e.g., [['label' => 'Product', 'amount' => 1000]]).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) of the forum.
     *                       - provider_token (string): Payment provider token (required for some providers).
     *                       - max_tip_amount (int): Maximum allowed tip amount in the smallest units of the currency.
     *                       - suggested_tip_amounts (array): Array of suggested tip amounts in the smallest units of the currency.
     *                       - start_parameter (string): Unique deep-linking parameter.
     *                       - provider_data (string): JSON-serialized data for the payment provider.
     *                       - photo_url (string): URL of the product photo.
     *                       - photo_size (int): Size of the photo in bytes.
     *                       - photo_width (int): Width of the photo.
     *                       - photo_height (int): Height of the photo.
     *                       - need_name (bool): Pass true if user's full name is required.
     *                       - need_phone_number (bool): Pass true if user's phone number is required.
     *                       - need_email (bool): Pass true if user's email is required.
     *                       - need_shipping_address (bool): Pass true if user's shipping address is required.
     *                       - send_phone_number_to_provider (bool): Pass true to send phone number to provider.
     *                       - send_email_to_provider (bool): Pass true to send email to provider.
     *                       - is_flexible (bool): Pass true if the final price depends on the shipping method.
     *                       - disable_notification (bool): Pass true to send the message silently.
     *                       - protect_content (bool): Pass true to protect the content from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => int]).
     *                       - reply_markup (array): Inline keyboard markup for the invoice.
     *                       - business_connection_id (string): Unique identifier of the business connection.
     * @return array The response from Telegram containing the sent Message object with the invoice (['ok' => true, 'result' => Message]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function sendInvoice(int|string $chatId, string $title, string $description, string $payload, string $currency, array $prices, array $options = []): array
    {
        $params = [
            'chat_id' => $chatId,
            'title' => $title,
            'description' => $description,
            'payload' => $payload,
            'currency' => $currency,
            'prices' => json_encode($prices),
        ];

        if (isset($options['suggested_tip_amounts'])) {
            $params['suggested_tip_amounts'] = json_encode($options['suggested_tip_amounts']);
        }
        if (isset($options['provider_data'])) {
            $params['provider_data'] = json_encode($options['provider_data']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->request('sendInvoice', array_merge($params, $options));
    }

    /**
     * Sends an invoice (asynchronous).
     * Use this method to send an invoice to a user in an async manner (Guzzle only).
     *
     * @param int|string $chatId Unique identifier for the target chat or username of the target channel (in the format @channelusername).
     * @param string $title Product name, 1-32 characters.
     * @param string $description Product description, 1-255 characters.
     * @param string $payload Bot-defined invoice payload, 1-128 bytes.
     * @param string $currency Three-letter ISO 4217 currency code (e.g., 'USD').
     * @param array $prices Array of LabeledPrice objects (e.g., [['label' => 'Product', 'amount' => 1000]]).
     * @param array $options Optional parameters:
     *                       - message_thread_id (int): Unique identifier for the target message thread (topic) of the forum.
     *                       - provider_token (string): Payment provider token (required for some providers).
     *                       - max_tip_amount (int): Maximum allowed tip amount in the smallest units of the currency.
     *                       - suggested_tip_amounts (array): Array of suggested tip amounts in the smallest units of the currency.
     *                       - start_parameter (string): Unique deep-linking parameter.
     *                       - provider_data (string): JSON-serialized data for the payment provider.
     *                       - photo_url (string): URL of the product photo.
     *                       - photo_size (int): Size of the photo in bytes.
     *                       - photo_width (int): Width of the photo.
     *                       - photo_height (int): Height of the photo.
     *                       - need_name (bool): Pass true if user's full name is required.
     *                       - need_phone_number (bool): Pass true if user's phone number is required.
     *                       - need_email (bool): Pass true if user's email is required.
     *                       - need_shipping_address (bool): Pass true if user's shipping address is required.
     *                       - send_phone_number_to_provider (bool): Pass true to send phone number to provider.
     *                       - send_email_to_provider (bool): Pass true to send email to provider.
     *                       - is_flexible (bool): Pass true if the final price depends on the shipping method.
     *                       - disable_notification (bool): Pass true to send the message silently.
     *                       - protect_content (bool): Pass true to protect the content from forwarding and saving.
     *                       - reply_parameters (array): Parameters for replying to a message (e.g., ['message_id' => int]).
     *                       - reply_markup (array): Inline keyboard markup for the invoice.
     *                       - business_connection_id (string): Unique identifier of the business connection.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function sendInvoiceAsync(int|string $chatId, string $title, string $description, string $payload, string $currency, array $prices, array $options = []): ?PromiseInterface
    {
        $params = [
            'chat_id' => $chatId,
            'title' => $title,
            'description' => $description,
            'payload' => $payload,
            'currency' => $currency,
            'prices' => json_encode($prices),
        ];

        if (isset($options['suggested_tip_amounts'])) {
            $params['suggested_tip_amounts'] = json_encode($options['suggested_tip_amounts']);
        }
        if (isset($options['provider_data'])) {
            $params['provider_data'] = json_encode($options['provider_data']);
        }
        if (isset($options['reply_parameters'])) {
            $params['reply_parameters'] = json_encode($options['reply_parameters']);
        }
        if (isset($options['reply_markup'])) {
            $params['reply_markup'] = json_encode($options['reply_markup']);
        }

        $promise = $this->requestAsync('sendInvoice', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Creates a link for an invoice (synchronous).
     * Use this method to create a shareable link for an invoice.
     *
     * @param string $title Product name, 1-32 characters.
     * @param string $description Product description, 1-255 characters.
     * @param string $payload Bot-defined invoice payload, 1-128 bytes.
     * @param string $currency Three-letter ISO 4217 currency code (e.g., 'USD').
     * @param array $prices Array of LabeledPrice objects (e.g., [['label' => 'Product', 'amount' => 1000]]).
     * @param array $options Optional parameters:
     *                       - provider_token (string): Payment provider token (required for some providers).
     *                       - max_tip_amount (int): Maximum allowed tip amount in the smallest units of the currency.
     *                       - suggested_tip_amounts (array): Array of suggested tip amounts in the smallest units of the currency.
     *                       - provider_data (string): JSON-serialized data for the payment provider.
     *                       - photo_url (string): URL of the product photo.
     *                       - photo_size (int): Size of the photo in bytes.
     *                       - photo_width (int): Width of the photo.
     *                       - photo_height (int): Height of the photo.
     *                       - need_name (bool): Pass true if user's full name is required.
     *                       - need_phone_number (bool): Pass true if user's phone number is required.
     *                       - need_email (bool): Pass true if user's email is required.
     *                       - need_shipping_address (bool): Pass true if user's shipping address is required.
     *                       - send_phone_number_to_provider (bool): Pass true to send phone number to provider.
     *                       - send_email_to_provider (bool): Pass true to send email to provider.
     *                       - is_flexible (bool): Pass true if the final price depends on the shipping method.
     * @return array The response from Telegram containing the invoice link (['ok' => true, 'result' => string]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function createInvoiceLink(string $title, string $description, string $payload, string $currency, array $prices, array $options = []): array
    {
        $params = [
            'title' => $title,
            'description' => $description,
            'payload' => $payload,
            'currency' => $currency,
            'prices' => json_encode($prices),
        ];

        if (isset($options['suggested_tip_amounts'])) {
            $params['suggested_tip_amounts'] = json_encode($options['suggested_tip_amounts']);
        }
        if (isset($options['provider_data'])) {
            $params['provider_data'] = json_encode($options['provider_data']);
        }

        return $this->request('createInvoiceLink', array_merge($params, $options));
    }

    /**
     * Creates a link for an invoice (asynchronous).
     * Use this method to create a shareable link for an invoice in an async manner (Guzzle only).
     *
     * @param string $title Product name, 1-32 characters.
     * @param string $description Product description, 1-255 characters.
     * @param string $payload Bot-defined invoice payload, 1-128 bytes.
     * @param string $currency Three-letter ISO 4217 currency code (e.g., 'USD').
     * @param array $prices Array of LabeledPrice objects (e.g., [['label' => 'Product', 'amount' => 1000]]).
     * @param array $options Optional parameters:
     *                       - provider_token (string): Payment provider token (required for some providers).
     *                       - max_tip_amount (int): Maximum allowed tip amount in the smallest units of the currency.
     *                       - suggested_tip_amounts (array): Array of suggested tip amounts in the smallest units of the currency.
     *                       - provider_data (string): JSON-serialized data for the payment provider.
     *                       - photo_url (string): URL of the product photo.
     *                       - photo_size (int): Size of the photo in bytes.
     *                       - photo_width (int): Width of the photo.
     *                       - photo_height (int): Height of the photo.
     *                       - need_name (bool): Pass true if user's full name is required.
     *                       - need_phone_number (bool): Pass true if user's phone number is required.
     *                       - need_email (bool): Pass true if user's email is required.
     *                       - need_shipping_address (bool): Pass true if user's shipping address is required.
     *                       - send_phone_number_to_provider (bool): Pass true to send phone number to provider.
     *                       - send_email_to_provider (bool): Pass true to send email to provider.
     *                       - is_flexible (bool): Pass true if the final price depends on the shipping method.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function createInvoiceLinkAsync(string $title, string $description, string $payload, string $currency, array $prices, array $options = []): ?PromiseInterface
    {
        $params = [
            'title' => $title,
            'description' => $description,
            'payload' => $payload,
            'currency' => $currency,
            'prices' => json_encode($prices),
        ];

        if (isset($options['suggested_tip_amounts'])) {
            $params['suggested_tip_amounts'] = json_encode($options['suggested_tip_amounts']);
        }
        if (isset($options['provider_data'])) {
            $params['provider_data'] = json_encode($options['provider_data']);
        }

        $promise = $this->requestAsync('createInvoiceLink', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Answers a shipping query (synchronous).
     * Use this method to reply to shipping queries from users.
     *
     * @param string $shippingQueryId Unique identifier for the shipping query.
     * @param bool $ok Pass true if delivery to the specified address is possible.
     * @param array $options Optional parameters:
     *                       - shipping_options (array): Required if ok is true. Array of ShippingOption objects.
     *                       - error_message (string): Required if ok is false. Error message, 1-120 characters.
     * @return array The response from Telegram (['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function answerShippingQuery(string $shippingQueryId, bool $ok, array $options = []): array
    {
        $params = [
            'shipping_query_id' => $shippingQueryId,
            'ok' => $ok,
        ];

        if ($ok && !isset($options['shipping_options'])) {
            throw new Exception('shipping_options is required when ok is true.');
        }
        if (!$ok && !isset($options['error_message'])) {
            throw new Exception('error_message is required when ok is false.');
        }

        if (isset($options['shipping_options'])) {
            $params['shipping_options'] = json_encode($options['shipping_options']);
        }

        return $this->request('answerShippingQuery', array_merge($params, $options));
    }

    /**
     * Answers a shipping query (asynchronous).
     * Use this method to reply to shipping queries from users in an async manner (Guzzle only).
     *
     * @param string $shippingQueryId Unique identifier for the shipping query.
     * @param bool $ok Pass true if delivery to the specified address is possible.
     * @param array $options Optional parameters:
     *                       - shipping_options (array): Required if ok is true. Array of ShippingOption objects.
     *                       - error_message (string): Required if ok is false. Error message, 1-120 characters.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function answerShippingQueryAsync(string $shippingQueryId, bool $ok, array $options = []): ?PromiseInterface
    {
        $params = [
            'shipping_query_id' => $shippingQueryId,
            'ok' => $ok,
        ];

        if ($ok && !isset($options['shipping_options'])) {
            throw new Exception('shipping_options is required when ok is true.');
        }
        if (!$ok && !isset($options['error_message'])) {
            throw new Exception('error_message is required when ok is false.');
        }

        if (isset($options['shipping_options'])) {
            $params['shipping_options'] = json_encode($options['shipping_options']);
        }

        $promise = $this->requestAsync('answerShippingQuery', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }

    /**
     * Answers a pre-checkout query (synchronous).
     * Use this method to respond to pre-checkout queries from users.
     *
     * @param string $preCheckoutQueryId Unique identifier for the pre-checkout query.
     * @param bool $ok Pass true if everything is alright and the payment can proceed.
     * @param array $options Optional parameters:
     *                       - error_message (string): Required if ok is false. Error message, 1-255 characters.
     * @return array The response from Telegram (['ok' => true, 'result' => true]).
     * @throws Exception|GuzzleException If the request fails or required parameters are missing.
     */
    public function answerPreCheckoutQuery(string $preCheckoutQueryId, bool $ok, array $options = []): array
    {
        $params = [
            'pre_checkout_query_id' => $preCheckoutQueryId,
            'ok' => $ok,
        ];

        if (!$ok && !isset($options['error_message'])) {
            throw new Exception('error_message is required when ok is false.');
        }

        return $this->request('answerPreCheckoutQuery', array_merge($params, $options));
    }

    /**
     * Answers a pre-checkout query (asynchronous).
     * Use this method to respond to pre-checkout queries from users in an async manner (Guzzle only).
     *
     * @param string $preCheckoutQueryId Unique identifier for the pre-checkout query.
     * @param bool $ok Pass true if everything is alright and the payment can proceed.
     * @param array $options Optional parameters:
     *                       - error_message (string): Required if ok is false. Error message, 1-255 characters.
     * @return PromiseInterface|null The promise for the response (Guzzle only).
     * @throws Exception If the request fails.
     */
    public function answerPreCheckoutQueryAsync(string $preCheckoutQueryId, bool $ok, array $options = []): ?PromiseInterface
    {
        $params = [
            'pre_checkout_query_id' => $preCheckoutQueryId,
            'ok' => $ok,
        ];

        if (!$ok && !isset($options['error_message'])) {
            throw new Exception('error_message is required when ok is false.');
        }

        $promise = $this->requestAsync('answerPreCheckoutQuery', array_merge($params, $options));
        return $promise?->then(function ($response) {
            return json_decode($response, true);
        });
    }
}