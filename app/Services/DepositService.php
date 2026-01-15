<?php

namespace App\Services;

use App\Enums\DepositStatus;
use App\Models\CustomSetting;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DepositService {
    public static function markAsFinished(Deposit $deposit) {
       if ($deposit->status === DepositStatus::FINISHED) {
            return;
        }

        DB::transaction(function () use ($deposit) {

            $deposit->markFinished();

            // 2. Credit user balance
            $user = $deposit->user;
            $user->increment('balance', $deposit->amount);

            // send email
        });
    }

    public static function depositBonus(User $user, Deposit $deposit) {
        $depositAmount = $deposit->amount_paid;
        $bonusPercent = (float) CustomSetting::get('deposit_bonus_percentage', 0);
        $bonusDuration = (int) CustomSetting::get('deposit_bonus_duration_days', 0);

        $bonusAmount = $depositAmount * ($bonusPercent / 100);

        $deposit->update([
            'bonus' => $bonusAmount,
            'bonus_expires_at' => now()->addDays($bonusDuration),
        ]);
    }
}
