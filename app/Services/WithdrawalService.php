<?php

namespace App\Services;

use App\Enums\DepositStatus;
use App\Enums\WithdrawalStatus;
use App\Mail\WithdrawalCompletedMail;
use App\Models\Deposit;
use App\Models\RankBonus;
use App\Models\ReferralReward;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
       if (in_array($withdrawal->status, [
            WithdrawalStatus::COMPLETED,
            WithdrawalStatus::FAILED,
            WithdrawalStatus::CANCELLED,
        ])) {
            return;
        }

        DB::transaction(function () use ($withdrawal) {
            $totalToDebit = $withdrawal->meta['total_to_debit'] ?? $withdrawal->amount;
            if($withdrawal->asset === 'referral_rewards') {
                self::withdrawFromBonuses($withdrawal->user->id, $totalToDebit);
            } else {
                self::withdrawFromWallet($withdrawal, $totalToDebit);
            }
            $withdrawal->markCompleted('-');

            if($withdrawal->status === WithdrawalStatus::COMPLETED) {
                Mail::to($withdrawal->user->email)->send(new WithdrawalCompletedMail($withdrawal));
            }
        });
    }

    private static function withdrawFromBonuses(int $userId, float $amount): void {
        $totalAvailable =
            self::availableRankBonus($userId) +
            self::availableReferralBonus($userId);

        if ($amount > $totalAvailable) {
            throw new \Exception('Insufficient bonus balance');
        }

        // Rank bonus first
        $amount = self::debitRankBonus($userId, $amount);

        // Then referral rewards
        if ($amount > 0) {
            self::debitReferralRewards($userId, $amount);
        }
    }

    private static function availableRankBonus(int $userId): float {
        return RankBonus::where('user_id', $userId)
            ->sum(DB::raw('amount - withdrawn'));
    }

    private static function debitRankBonus(int $userId, float $amount): float {
        $bonuses = RankBonus::where('user_id', $userId)
            ->whereColumn('withdrawn', '<', 'amount')
            ->orderBy('created_at')
            ->lockForUpdate()
            ->get();

        foreach ($bonuses as $bonus) {
            if ($amount <= 0) break;

            $available = $bonus->amount - $bonus->withdrawn;

            $deduct = min($available, $amount);
            $bonus->increment('withdrawn', $deduct);

            $amount -= $deduct;
        }

        return $amount;
    }

    private static function availableReferralBonus(int $userId): float {
        return ReferralReward::where('user_id', $userId)
            ->sum(DB::raw('amount - withdrawn'));
    }

    private static function debitReferralRewards(int $userId, float $amount): void {
        $rewards = ReferralReward::where('user_id', $userId)
            ->whereColumn('withdrawn', '<', 'amount')
            ->orderBy('created_at')
            ->lockForUpdate()
            ->get();

        foreach ($rewards as $reward) {
            if ($amount <= 0) break;

            $available = $reward->amount - $reward->withdrawn;

            $deduct = min($available, $amount);
            $reward->increment('withdrawn', $deduct);

            $amount -= $deduct;
        }
    }

    private static function withdrawFromWallet(Withdrawal $withdrawal, float $amount): void {
        $user = $withdrawal->user()->lockForUpdate()->first();

        if (bccomp($user->balance, (string) $amount, 8) < 0) {
            throw new \Exception('Insufficient balance');
        }

        $user->decrement('balance', $amount);
    }

    public static function markAsProcessing(Withdrawal $withdrawal) {
        if ($withdrawal->status === WithdrawalStatus::COMPLETED || $withdrawal->status === WithdrawalStatus::FAILED) {
            return;
        }

        DB::transaction(function () use ($withdrawal) {

            $withdrawal->markProcessing();

            // send email
        });
    }

    public static function markAsFailed(Withdrawal $withdrawal) {

    }
}
