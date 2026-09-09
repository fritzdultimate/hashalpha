<?php

namespace App\Services;

use App\Enums\CompoundingOfferStatus;
use App\Mail\CompoundingOfferAcceptedMail;
use App\Mail\CompoundingOfferCreatedMail;
use App\Models\CompoundingOffer;
use App\Models\Stake;
use App\Models\StakingPlan;
use App\Models\Transaction;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Handles the opt-in "compounding offer" flow: once a stake matures, the
 * user is offered the chance to voluntarily reinvest its principal into a
 * new locked stake for a fixed term, using the rate/duration terms of the
 * matured stake's own plan (snapshotted at offer time, never admin-typed).
 *
 * Nothing here force-ends an active stake or charges a fee to unlock funds
 * early -- acceptance is the user's choice, terms are disclosed up front,
 * and the lock is simply the normal staking-term lock already used
 * elsewhere in the app (see WithdrawalRules).
 */
class CompoundingOfferService
{
    // How long the user has to decide before the offer expires.
    protected const DECISION_WINDOW_DAYS = 7;

    public static function createForMaturedStake(Stake $stake, ?StakingPlan $plan): ?CompoundingOffer
    {
        if (CompoundingOffer::where('stake_id', $stake->id)->exists()) {
            return null;
        }

        $plan = $plan ?? $stake->plan;

        if (! $plan) {
            return null;
        }

        $offer = CompoundingOffer::create([
            'user_id' => $stake->user_id,
            'stake_id' => $stake->id,
            'plan_id' => $plan->id,
            'min_roi' => $plan->min_roi,
            'max_roi' => $plan->max_roi,
            'duration_days' => $plan->duration,
            'status' => CompoundingOfferStatus::OFFERED->value,
            'notify_daily' => false,
            'offered_at' => now(),
            'expires_at' => now()->addDays(self::DECISION_WINDOW_DAYS),
        ]);

        Mail::to($stake->user->email)->send(new CompoundingOfferCreatedMail($offer));

        return $offer;
    }

    public static function accept(CompoundingOffer $offer, bool $notifyDaily = false): Stake
    {
        if ($offer->status !== CompoundingOfferStatus::OFFERED) {
            throw new DomainException('This compounding offer is no longer available.');
        }

        if ($offer->expires_at && now()->gt($offer->expires_at)) {
            $offer->update([
                'status' => CompoundingOfferStatus::EXPIRED->value,
                'responded_at' => now(),
            ]);

            throw new DomainException('This compounding offer has expired.');
        }

        return DB::transaction(function () use ($offer, $notifyDaily) {
            $originalStake = $offer->stake;
            $amount = $originalStake->user->balance;

            $originalStake->user->balance = bcsub($originalStake->user->balance, (string)$amount, 8);
            $originalStake->user->save();


            $newStake = Stake::create([
                'user_id' => $offer->user_id,
                'plan_id' => $offer->plan_id,
                'amount' => $amount,
                'status' => 'active',
                'started_at' => now(),
                'expected_end_date' => now()->addDays((int) $offer->duration_days),
                'compounding' => true,
                'is_compounding_offer' => true,
                'notify_daily' => $notifyDaily,
                'meta' => [
                    'source' => 'compounding_offer',
                    'compounding_offer_id' => $offer->id,
                    'source_stake_id' => $originalStake->id,
                    'min_roi' => $offer->min_roi,
                    'max_roi' => $offer->max_roi,
                ],
            ]);

            Transaction::create([
                'user_id' => $originalStake->user->id,
                'type' => 'hold',
                'amount' => $amount,
                'balance_after' => $originalStake->user->balance,
                'related_type' => 'App\Models\Stake',
                'related_id' => $newStake->id,
                'meta' => [
                    'note' => 'Staked',
                    'used_bonus' => 0,
                    'used_balance' => $amount,
                ],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $offer->update([
                'status' => CompoundingOfferStatus::ACCEPTED->value,
                'new_stake_id' => $newStake->id,
                'notify_daily' => $notifyDaily,
                'responded_at' => now(),
            ]);

            Mail::to($offer->user->email)->send(new CompoundingOfferAcceptedMail($offer->fresh(), $newStake, $amount));

            return $newStake;
        });
    }

    public static function decline(CompoundingOffer $offer): void
    {
        if ($offer->status !== CompoundingOfferStatus::OFFERED) {
            throw new DomainException('This compounding offer is no longer available.');
        }

        $offer->update([
            'status' => CompoundingOfferStatus::DECLINED->value,
            'responded_at' => now(),
        ]);
    }

    // Sweep offers whose decision window has passed without a response.
    public static function expireStaleOffers(): int
    {
        return CompoundingOffer::where('status', CompoundingOfferStatus::OFFERED->value)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->update([
                'status' => CompoundingOfferStatus::EXPIRED->value,
                'responded_at' => now(),
            ]);
    }
}
