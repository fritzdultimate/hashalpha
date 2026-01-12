<?php

namespace App\Domain\Staking;

use App\Models\Stake;
use App\Models\User;

class StakeRules {
    public static function canCreate(User $user, $stake_amount): void {
        self::maxActiveStakesPerPlan($user);
        self::checkBalance($user, $stake_amount);

        // Future rules go here 👇
        // self::kycRequired($user);
        // self::cooldownCheck($user);
        // self::planAvailability($plan);
    }

    protected static function maxActiveStakesPerPlan(User $user): void {
        $count = Stake::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        if ($count >= 4) {
            throw new \DomainException(
                'You can only have a maximum of 4 active stakes.'
            );
        }
    }

    protected static function checkBalance(User $user, $stake_amount): void {
        if (bccomp($user->balance, $stake_amount, 8) === -1) {
            throw new \DomainException(
                'Insufficient account balance to stake this amount.'
            );
        }
    }
}
