<?php

namespace App\Console\Commands;

use App\Models\PerformanceBonus;
use App\Models\Stake;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PerformanceBonusService;
use Illuminate\Console\Command;

class ProcessPerformanceBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-performance-bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        \Log::info('Job is scheduling...');
        return;

        Stake::where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('last_payout_at')
                    ->where('expected_end_date', '>=', now());
            })
            ->chunkById(100, function ($stakes) {
                foreach ($stakes as $stake) {
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
                    // Performance bonus distribution
                    PerformanceBonusService::distribute($stake->user, $reward);
                }
            });

        User::chunkById(100, function ($users) {
            foreach ($users as $user) {
                $unsyncedBonuses = PerformanceBonus::where('user_id', $user->id)
                    ->where('synced_bonus', false)
                    ->get();
                if ($unsyncedBonuses->isEmpty()) {
                    continue;
                }

                $bonus = $unsyncedBonuses->sum('amount');
                PerformanceBonus::whereIn('id', $unsyncedBonuses->pluck('id'))
                    ->update(['synced_bonus' => true]);

                Transaction::create([
                    'related_type' => PerformanceBonus::class,
                    // 'related_id' => null,
                    'amount' => $bonus,
                    'type' => 'performance_bonus',
                    'user_id' => $user->id
                ]);
                $user->increment('balance', $bonus);
            }
        });

    }
}
