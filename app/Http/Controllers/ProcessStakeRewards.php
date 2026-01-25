<?php

namespace App\Http\Controllers;

use App\Enums\DepositStatus;
use App\Models\Deposit;
use App\Models\Reward;
use App\Models\Stake;
use App\Models\ValidatorReward;
use App\Services\NowPaymentsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    protected function processStake(Stake $stake): void
    {
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

        $minFactor = 9500;
        $maxFactor = 10500;
        $randomFactor = random_int($minFactor, $maxFactor);
        $factor = bcdiv((string) $randomFactor, '10000', 8);
        $baseRoi = (string) $stake->plan->daily_roi;
        $fluctuatedRoi = bcmul($baseRoi, $factor, 8);

        $reward = bcmul(
            $stake->amount,
            bcdiv($fluctuatedRoi, 100, 8),
            8
        );

        $lock_rewards = $stake->user->shouldLockRewards();

        Reward::create([
            'user_id' => $stake->user_id,
            'stake_id' => $stake->id,
            'amount' => $reward,
            'status' => $lock_rewards ? 'locked' : 'pending',
            'credited_at' => now(),
            'reward_type' => 'staking',
            'rewards_locked_at' => $lock_rewards ? now() : null,
            // 'lock_reason' => ''
        ]);

        $stake->update([
            'last_payout_at' => now(),
        ]);
    }
}
