<?php

namespace App\Services;

use App\Models\Deposit;
use Illuminate\Support\Str;

class ManualPaymentService {
    public static function createInvoice(Deposit $deposit, $network = null): array {
        $wallet = app(ManualWalletService::class)->find($deposit->currency, $network);

        // Fallback: match by whatever currency was passed in even without exact network hit
        if (!$wallet) {
            $wallet = \App\Models\ManualWallet::where('currency', $deposit->currency)
                ->where('is_active', true)
                ->first();
        }

        abort_if(!$wallet, 422, "No manual wallet configured for this currency.  . $deposit->currency");

        return [
            'payment_id' => 'MAN-' . strtoupper(Str::random(10)),
            'pay_address' => $wallet->address,
            'pay_amount' => (float) $deposit->amount,
            'pay_currency' => $wallet->currency,
            'payment_status' => 'waiting',
            'created_at' => now()->toISOString(),
            'expiration_estimate_date' => null,
            'is_manual' => true, // internal flag only, harmless extra key for the JS/blade
        ];
    }
}