<?php

namespace App\Services;

use App\Enums\DepositStatus;
use App\Enums\WithdrawalStatus;
use App\Models\Deposit;
use App\Models\ReferralReward;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class  WithdrawalService {
    public static function review(Withdrawal $withdrawal) {
       if ($withdrawal->status === WithdrawalStatus::COMPLETED) {
            return;
        }

        DB::transaction(function () use ($withdrawal) {

            $withdrawal->markReview();

            // send email
        });
    }

    public static function complete(Withdrawal $withdrawal) {
       if ($withdrawal->status === WithdrawalStatus::COMPLETED || $withdrawal->status === WithdrawalStatus::FAILED || $withdrawal->status === WithdrawalStatus::CANCELLED) {
            return;
        }

        DB::transaction(function () use ($withdrawal) {
            if($withdrawal->asset === 'referral_rewards') {
                $totalAvailable = ReferralReward::where('user_id', $withdrawal->user->id)
                    ->get()
                    ->sum(fn ($reward) => $reward->amount - ($reward->withdrawn ?? 0));

                if ($withdrawal->amount > $totalAvailable) {
                    throw new \Exception('Insufficient referral balance');
                }

                $remaining = $withdrawal->amount;

                $rewards = ReferralReward::where('user_id', $withdrawal->user->id)
                    ->whereColumn('withdrawn', '<', 'amount')
                    ->orderBy('created_at')
                    ->lockForUpdate()
                    ->get();

                foreach ($rewards as $reward) {
                    if ($remaining <= 0) {
                        break;
                    }
                    $available = $reward->amount - $reward->withdrawn;

                    if ($available <= 0) {
                        continue;
                    }

                    if ($available >= $remaining) {
                        $reward->withdrawn += $remaining;
                        $reward->save();

                        $remaining = 0;
                        break;
                    }
                    $reward->withdrawn += $available;
                    $reward->save();

                    $remaining -= $available;
                }
            } else {
                if($withdrawal->amount > $withdrawal->user->balance) {
                    return; //insufficient
                }
                $withdrawal->user()->decrement('balance', $withdrawal->amount);
                $withdrawal->markCompleted('djssdoas');
            }

            // send email
        });
    }

    public static function markAsProcessing(Withdrawal $withdrawal) {

    }

    public static function markAsFailed(Withdrawal $withdrawal) {

    }
}
