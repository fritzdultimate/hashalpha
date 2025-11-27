<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use App\Models\Stake;
use App\Models\Transaction;
use App\Services\RewardCalculator;
use Carbon\Carbon;

class StakeAccrueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * $intervalDays - number of days per accrual run (float, e.g. 1 for daily).
     */
    public $intervalDays;

    public function __construct(float $intervalDays = 1.0)
    {
        $this->intervalDays = $intervalDays;
    }

    public function handle()
    {
        // Process in chunks to avoid locking everything
        Stake::where('status', 'active')
            ->chunkById(100, function($stakes) {
                foreach ($stakes as $stake) {
                    $this->processStake($stake);
                }
            });
    }

    protected function processStake(Stake $stake)
    {
        // Use DB lock to prevent race
        DB::transaction(function() use ($stake) {
            // refresh locked
            $stake = Stake::where('id', $stake->id)->lockForUpdate()->first();

            // Calculate how many days since last_accrued_at
            $last = $stake->last_accrued_at ? Carbon::parse($stake->last_accrued_at) : Carbon::parse($stake->start_at);
            $now = Carbon::now();

            // If nothing to accrue (last >= now) skip
            if ($last->gte($now)) {
                return;
            }

            // Determine days to accrue (cap at intervalDays)
            $diffSeconds = $now->diffInSeconds($last);
            $days = $diffSeconds / 86400.0;

            // To avoid tiny fractional noise, round down to min intervalDays precision
            $daysToProcess = min($days, $this->intervalDays);

            if ($daysToProcess <= 0) return;

            // Use the RewardCalculator
            $principal = $stake->principal_decimal;
            $apy = $stake->plan->apy_decimal;

            $reward = RewardCalculator::rewardForDays($principal, $apy, $daysToProcess);

            if (bccomp($reward, '0', 8) <= 0) {
                // update last_accrued_at anyway
                $stake->last_accrued_at = $now;
                $stake->save();
                return;
            }

            // Add reward to accrued_rewards_decimal and withdrawable_decimal (we treat payout as withdrawable)
            $stake->accrued_rewards_decimal = bcadd($stake->accrued_rewards_decimal, $reward, 8);
            $stake->withdrawable_decimal = bcadd($stake->withdrawable_decimal, $reward, 8);
            $stake->last_accrued_at = $now;

            // If plan has auto_compound meta set on stake OR plan auto_renew logic, handle elsewhere
            $stake->save();

            // Create transaction ledger item for visibility (no change to user wallet yet)
            Transaction::create([
                'user_id' => $stake->user_id,
                'type' => 'stake_reward',
                'txable_id' => $stake->id,
                'txable_type' => get_class($stake),
                'amount_decimal' => $reward,
                'balance_before_decimal' => null,
                'balance_after_decimal' => null,
                'meta' => [
                    'reason' => 'accrual',
                    'days' => $daysToProcess,
                    'apy' => $apy
                ]
            ]);
        });
    }
}
