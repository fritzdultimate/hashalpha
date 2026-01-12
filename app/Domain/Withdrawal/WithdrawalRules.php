<?php

namespace App\Domain\Withdrawal;

use App\Enums\WithdrawalStatus;
use App\Models\Stake;
use App\Models\User;
use App\Models\Withdrawal;
use DomainException;

class WithdrawalRules {
    public static function canCreate(User $user, $amount): void {
        self::noPendingWithdrawal($user);
        self::checkBalance($user, $amount);
        self::minimumAmount($amount);
        self::maximumAmount($amount);

        // Future rules go here 👇
        // self::kycRequired($user);
        // self::cooldownCheck($user);
        // self::planAvailability($plan);
    }

    /**
     * Minimum withdrawal rule
     */
    protected static function minimumAmount(string $amount): void {
        $min = config('withdrawal.minimum', '50');

        if (bccomp($amount, $min, 8) === -1) {
            throw new DomainException(
                "Minimum withdrawal amount is {$min}."
            );
        }
    }

    /**
     * Maximum withdrawal rule (per request)
     */
    protected static function maximumAmount(string $amount): void {
        $max = config('withdrawal.maximum', '100000');

        if (bccomp($amount, $max, 8) === 1) {
            throw new DomainException(
                "Maximum withdrawal amount per request is {$max}."
            );
        }
    }

    protected static function noPendingWithdrawal(User $user): void {
        $hasPending = Withdrawal::query()
            ->where('user_id', $user->id)
            ->whereIn('status', [
                WithdrawalStatus::PENDING,
                WithdrawalStatus::PROCESSING,
            ])
            ->exists();

        // if ($hasPending) {
        //     throw new DomainException(
        //         'You already have a pending withdrawal. Please wait until it is processed.'
        //     );
        // }
    }

    protected static function checkBalance(User $user, $amount): void {
        if (bccomp($user->balance, $amount, 8) === -1) {
            throw new DomainException(
                'Insufficient account balance to complete this withdrawal.'
            );
        }
    }
}
