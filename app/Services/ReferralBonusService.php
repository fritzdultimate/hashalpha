<?php

namespace App\Services;

use App\Models\ReferralLevel;
use App\Models\User;
use App\Models\Stake;
use App\Models\ReferralReward;

class ReferralBonusService {
    public static function distribute(User $staker, Stake $stake): void {
        $levels = config('referrals.levels');
        $delayDays = config('referrals.claim_delay_days');

        $levels = ReferralLevel::where('is_active', true)
            ->orderBy('level')
            ->get()
            ->keyBy('level');

        if ($levels->isEmpty()) {
            return;
        }


        $currentUser = $staker;
        $level = 1;

        while ($level <= 10 && $currentUser->referred_by_id) {
            $referrer = User::find($currentUser->referred_by_id);

            if (! $referrer || ! isset($levels[$level])) {
                break;
            }

            $bps = (int) $levels[$level]; // basis points
            $amount = bcmul($stake->amount, bcdiv((string)$bps, '10000', 8), 8);

            if (bccomp($amount, '0', 8) <= 0) {
                $level++;
                $currentUser = $referrer;
                continue;
            }

            ReferralReward::create([
                'user_id' => $referrer->id,
                'from_user_id' => $staker->id,
                'stake_id' => $stake->id,
                'level' => $level,
                'percent_bps' => $bps,
                'amount' => $amount,
                'status' => 'pending',
                'lock_reason' => 'Stake cooling period',
                'claimable_at' => now()->addDays($delayDays),
                'calculated_for' => now()->startOfDay(),
                'meta' => [
                    'stake_amount' => $stake->amount,
                    'plan_id' => $stake->plan_id,
                ],
            ]);

            // notify referrer
            // Notification::send($referrer, new ReferralBonusEarned(
            //     $staker,
            //     $amount,
            //     $level,
            //     $stake
            // ));

            $currentUser = $referrer;
            $level++;
        }
    }
}

