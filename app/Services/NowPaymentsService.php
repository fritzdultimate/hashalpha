<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NowPaymentsService {
    protected static $endpoint = 'https://api.nowpayments.io/v1';
    protected static $apiKey;
    protected static $ipnSecret;

    public function __construct() {
        self::$apiKey = config('services.nowpayments.api_key');
        self::$ipnSecret = config('services.nowpayments.ipn_secret');
    }

    /**
     * Create invoice
     */
    public static function createInvoice($deposit) {
        $payload = [
            'price_amount'   => (float)$deposit->amount,
            'price_currency' => strtoupper($deposit->currency),
            'order_id'       => $deposit->id,
            'pay_currency'   => strtoupper($deposit->currency),
            'ipn_callback_url' => route('webhooks.nowpayments'),
        ];

        $res = Http::withHeaders([
            'x-api-key' => self::$apiKey,
        ])->post(self::$endpoint . '/invoice', $payload);

        if (!$res->successful()) {
            throw new \Exception("NOWPayments invoice error: " . $res->body());
        }

        return $res->json();
    }

    /**
     * Check invoice status
     */
    public static function checkInvoice($invoiceId) {
        $res = Http::withHeaders([
            'x-api-key' => self::$apiKey,
        ])->get(self::$endpoint . "/invoice/{$invoiceId}");

        if (!$res->successful()) {
            throw new \Exception("NOWPayments invoice check error: " . $res->body());
        }

        return $res->json();
    }

    /**
     * Verify webhook signature (HMAC-SHA512)
     */
    public static function verifySignature($rawPayload, $receivedSignature) {
        $expected = hash_hmac('sha512', $rawPayload, self::$ipnSecret);

        return hash_equals($expected, $receivedSignature);
    }
}
