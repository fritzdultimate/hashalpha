<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\Stake;
use App\Services\PerformanceBonusService;
use Carbon\Carbon;

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
            $stake->update(['status' => 'completed']);
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

        $stake->update([
            'last_payout_at' => now(),
        ]);
    }

    public function manualRoiDistribution() {
        $r = Stake::where('status', 'active')
                ->where('created_at', '<=', now()->subHours(48))
                ->chunkById(100, function ($stakes) {
                    foreach ($stakes as $stake) {
                        $this->processStakeManually($stake);
                    }
                });
    }

    protected function processStakeManually(Stake $stake): void {
        if($stake->user->id !== 1) return;
        $referenceTime = Carbon::parse($stake->created_at);
        if ($referenceTime->gt(now()->subHours(48))) {
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
