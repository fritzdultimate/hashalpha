<?php

namespace App\Http\Controllers;

use App\Enums\StakeStatus;
use App\Mail\CompoundingDailyProgressMail;
use App\Mail\CompoundingEndedAdminMail;
use App\Models\Reward;
use App\Models\Stake;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessStakeRewards extends Controller {
    public function handle() {

            $r = Stake::where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('last_payout_at')
                    ->where('created_at', '<=', now()->subHours(24))
                    ->orWhere(function ($q) {
                        $q->whereNotNull('last_payout_at')
                            ->where('last_payout_at', '<=', now()->subHours(24));
                    });
                })
                ->chunkById(100, function ($stakes) {
                    foreach ($stakes as $stake) {
                        $this->processStake($stake);
                    }
                });

    }

    protected function processStake(Stake $stake): void {
        $referenceTime = Carbon::parse(
            $stake->last_payout_at ?? $stake->created_at
        );
        if ($referenceTime->gt(now()->subHours(24))) {
            return;
        }

        if ($stake->expected_end_date && now()->gte($stake->expected_end_date)) {
            DB::transaction(function () use ($stake) {
                $user = $stake->user()->lockForUpdate()->first();

                $user->balance = bcadd($user->balance, (string) $stake->amount, 8);
                $user->save();

                $stake->update(['status' => StakeStatus::COMPLETED->value]);
            });

            // Give the user the option to voluntarily reinvest this matured
            // stake's principal into a new locked compounding term, using
            // the terms of the plan it was staked under. This is purely an
            // opt-in offer -- nothing is force-locked here.
            // CompoundingOfferService::createForMaturedStake($stake);

            // Notify admins immediately when a user's compounding stake completes.
            if ($stake->is_compounding_offer) {
                try {
                    $admins = User::admins();
                    if ($admins->isNotEmpty()) {
                        Mail::to($admins->pluck('email')->all())
                            ->send(new CompoundingEndedAdminMail($stake));
                    }
                } catch (\Throwable $e) {
                    Log::warning('Failed to send compounding-ended admin notification for stake #' . $stake->id . ': ' . $e->getMessage());
                }
            }

            return;
        }

        $minRoi = (string) $stake->plan->min_roi;
        $maxRoi = (string) $stake->plan->max_roi;

        $minInt = (int) bcmul($minRoi, '10000');
        $maxInt = (int) bcmul($maxRoi, '10000');
        $randomInt = random_int($minInt, $maxInt);
        $fluctuatedRoi = bcdiv((string) $randomInt, '10000', 8);

        $reward = bcmul(
            $stake->amount,
            bcdiv($fluctuatedRoi, 100, 8),
            8
        );

        $lock_rewards = $stake->user->shouldLockRewards() || $stake->lock_roi;
        $isCompoundedStake = $stake->is_compounding_offer;

        Reward::create([
            'user_id' => $stake->user_id,
            'stake_id' => $stake->id,
            'amount' => $reward,
            'status' => $isCompoundedStake ? 'compounded' : ($lock_rewards ? 'locked' : 'pending'),
            'credited_at' => now(),
            'reward_type' => 'staking',
            'rewards_locked_at' => $isCompoundedStake ? null : ($lock_rewards ? now() : null),
            'compounded_at' => $isCompoundedStake ? now() : null,
            'meta' => [
                'roi_used' => $fluctuatedRoi,
                'plan_min_roi' => $stake->plan->min_roi,
                'plan_max_roi' => $stake->plan->max_roi,
                'generated_at' => now()->toDateTimeString(),
            ]
            // 'lock_reason' => ''
        ]);

        if ($isCompoundedStake) {
            DB::transaction(function () use ($stake, $reward) {

                $stake->lockForUpdate()->first();

                $stake->update([
                    'amount' => bcadd($stake->amount, (string) $reward, 8),
                    'last_payout_at' => now()
                ]);

                Mail::to($stake->user->email)->send(new CompoundingDailyProgressMail($stake, $reward));
            });

            
        }

        // Performance bonus distribution
        // PerformanceBonusService::distribute($stake->user, $reward);

        $stake->update([
            'last_payout_at' => now()
        ]);
    }

    public function manualRoiDistribution() {
        $r = Stake::where('status', 'active')
                // ->where('created_at', '<=', now()->subHours(96))
                ->chunkById(100, function ($stakes) {
                    foreach ($stakes as $stake) {
                        $this->processStakeManually($stake);
                    }
                });
    }

    protected function processStakeManually(Stake $stake): void {
        $referenceTime = Carbon::parse($stake->created_at);
        // if ($referenceTime->gt(now()->subHours(48))) {
        //     return;
        // }

        $minRoi = (string) $stake->plan->min_roi;
        $maxRoi = (string) $stake->plan->max_roi;

        $minInt = (int) bcmul($minRoi, '10000');
        $maxInt = (int) bcmul($maxRoi, '10000');
        $randomInt = random_int($minInt, $maxInt);
        $fluctuatedRoi = bcdiv((string) $randomInt, '10000', 8);

        $reward = bcmul(
            $stake->amount,
            bcdiv($fluctuatedRoi, 100, 8),
            8
        );

        $lock_rewards = $stake->user->shouldLockRewards() || $stake->lock_roi;

        Reward::create([
            'user_id' => $stake->user_id,
            'stake_id' => $stake->id,
            'amount' => $reward,
            'status' => $lock_rewards ? 'locked' : 'pending',
            'credited_at' => now(),
            'reward_type' => 'staking',
            'rewards_locked_at' => $lock_rewards ? now() : null,
            'meta' => [
                'roi_used' => $fluctuatedRoi,
                'plan_min_roi' => $stake->plan->min_roi,
                'plan_max_roi' => $stake->plan->max_roi,
                'generated_at' => now()->toDateTimeString(),
            ]
            // 'lock_reason' => ''
        ]);

        // Performance bonus distribution
        // PerformanceBonusService::distribute($stake->user, $reward);

        // $stake->update([
        //     'last_payout_at' => now(),
        // ]);
    }
}
