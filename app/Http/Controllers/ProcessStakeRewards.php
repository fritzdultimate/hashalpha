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

        $reward = bcmul(
            $stake->amount,
            bcdiv($stake->plan->daily_roi, 100, 8),
            8
        );

        Reward::create([
            'user_id' => $stake->user_id,
            'stake_id' => $stake->id,
            'amount' => $reward,
            'status' => 'pending',
            'credited_at' => now(),
            'reward_type' => 'staking'
        ]);

        $stake->update([
            'last_payout_at' => now(),
        ]);
    }
}
