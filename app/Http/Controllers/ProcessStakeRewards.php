<?php

namespace App\Http\Controllers;

use App\Enums\DepositStatus;
use App\Models\Deposit;
use App\Models\Stake;
use App\Models\ValidatorReward;
use App\Services\NowPaymentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProcessStakeRewards extends Controller {
    public function handle($id, NowPaymentsService $np) {
        Stake::where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('last_payout_at')
                  ->orWhere('last_payout_at', '<=', now()->subDay());
            })
            ->chunkById(100, function ($stakes) {
                foreach ($stakes as $stake) {
                    $this->processStake($stake);
                }
            });
    }

    protected function processStake(Stake $stake): void
    {
        if (now()->gte($stake->expected_end_date)) {
            $stake->update(['status' => 'completed']);
            return;
        }

        $reward = bcmul(
            $stake->amount,
            bcdiv($stake->daily_roi, 100, 8),
            8
        );

        StakeReward::create([
            'user_id' => $stake->user_id,
            'stake_id' => $stake->id,
            'amount' => $reward,
            'status' => 'pending',
        ]);

        $stake->update([
            'last_reward_at' => now(),
        ]);
    }
}
