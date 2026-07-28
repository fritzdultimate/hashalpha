<?php

namespace App\Services;

use App\Models\PaymentSetting;

class PaymentSettingService {
    public static function activeProvider(): string {
        return PaymentSetting::where('is_active', true)->value('provider') ?? 'nowpayments';
    }
}