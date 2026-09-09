<?php

namespace App\Domain\Withdrawal;

use App\Enums\CompoundingOfferStatus;
use App\Enums\WithdrawalStatus;
use App\Models\CompoundingOffer;
use App\Models\CustomSetting;
use App\Models\ReferralReward;
use App\Models\Stake;
use App\Models\User;
use App\Models\Withdrawal;
use DomainException;

class WithdrawalRules {
    public static function canCreate(User $user, $amount, $asset = 'balance'): void {
        self::noPendingWithdrawal($user);
        // self::checkBalance($user, $amount, $asset);
        self::minimumAmount($amount);
        self::maximumAmount($amount);
        self::kycRequired($user);
        self::cooldownCheck($user);
        self::compoundingOfferLock($user);
        self::enhancedVerificationRequired($user, $amount);
        self::onCompounding($user);
    }

    protected static function kycRequired($user) {
        if($user->kyc_status !== 'approved') {
            throw new DomainException(
                "For security and compliance reasons, you must complete KYC verification before proceeding."
            );
        }
    }

    protected static function onCompounding($user) {
        $activeCompounding = CompoundingOffer::where('user_id', $user->id)
            ->whereIn('status', [CompoundingOfferStatus::ACCEPTED, CompoundingOfferStatus::OFFERED])
            ->exists();

        if ($activeCompounding) {
            throw new DomainException(
                "You have an active compounding offer on your account. Please resolve it before making a withdrawal."
            );
        }
    }

    protected static function cooldownCheck($user): void {
        $lastWithdrawal = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->first();

        if (! $lastWithdrawal) {
            return;
        }

        if ($lastWithdrawal->created_at->diffInMinutes(now()) < 30) {
            throw new DomainException(
                'Please wait 30 minutes before making another withdrawal.'
            );
        }
    }

    /**
     * Minimum withdrawal rule
     */
    protected static function minimumAmount(string $amount): void {
        $min = config('withdrawal.minimum', '50');

        if (bccomp($amount, $min, 8) === -1) {
            throw new DomainException(
                "Minimum withdrawal amount is $" . number_format($min, 2)
            );
        }
    }

    protected static function existingReferralRewardWithdrawal(): void {
        $exist = Withdrawal::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->where('asset', 'referral_rewards')
            ->exists();

        if ($exist) {
            throw new DomainException(
                "Please wait for your initial pending referral bonus withdrawal to be resolved."
            );
        }
    }

    protected static function userOnCompounding(User $user): void {
        $compounded = $user->stakes()
            ->where('status', 'active')
            ->where('compounding', true)
            ->exists();
        
        if($compounded) {
            throw new DomainException(
                "Account has active compounding stakes. Withdrawals are not allowed."
            );
        }
    }

    /**
     * Locks withdrawals while the user has an active stake created by
     * accepting a compounding offer -- the amount is locked for the term
     * the user agreed to when they opted in, per the plan's own duration.
     * Deliberately scoped to `is_compounding_offer` rather than the
     * generic `compounding` flag above, so it never affects ordinary
     * reward reinvestment (e.g. Compound All on the earnings page).
     */
    protected static function compoundingOfferLock(User $user): void {
        $lockedStake = $user->stakes()
            ->where('status', 'active')
            ->where('is_compounding_offer', true)
            ->first();

        if ($lockedStake) {
            $endDate = $lockedStake->expected_end_date?->format('M d, Y');

            throw new DomainException(
                "You have an active compounding term locked until"
                . ($endDate ? " {$endDate}." : " it completes.")
            );
        }
    }

    /**
     * Requires an approved, company-issued enhanced verification for
     * withdrawal amounts above a configurable threshold. No external
     * certificate or third-party provider is ever involved -- the
     * threshold and the review are both handled internally.
     */
    protected static function enhancedVerificationRequired(User $user, $amount): void {
        $threshold = CustomSetting::get('enhanced_verification_threshold', '5000');

        if (bccomp((string) $amount, (string) $threshold, 8) === -1) {
            return;
        }

        if ($user->enhanced_verification_status !== 'approved') {
            throw new DomainException(
                "Withdrawals above $" . number_format((float) $threshold, 2)
                . " require enhanced verification. Please submit your documents for review."
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
                'Maximum withdrawal amount per request is $' . number_format($max, 2)
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

        if ($hasPending) {
            throw new DomainException(
                'You already have a pending withdrawal. Please wait until it is processed.'
            );
        }
    }

    protected static function checkBalance(User $user, $amount, $asset = 'balance'): void {
        // dd($asset);
        if($asset === 'referral_rewards') {

            $totalAvailable = ReferralReward::where('user_id', auth()->id())
                ->get()
                ->sum(fn ($reward) => $reward->amount - ($reward->withdrawn ?? 0));

            if ($amount > $totalAvailable) {
                throw new DomainException(
                    'Insufficient referral balance'
                );
            }
        } else {

            if (bccomp($user->balance, $amount, 8) === -1) {
                throw new DomainException(
                    'Insufficient account balance to complete this withdrawal.'
                );
            }
        }
    }
}
