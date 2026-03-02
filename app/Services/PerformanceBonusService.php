<?php
namespace App\Services;

use App\Models\Deposit;
use App\Models\PerformanceBonus;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;



class PerformanceBonusService {
    protected array $percentages = [
        1 => 3,
        2 => 2,
        3 => 1,
        4 => 0.8,
        5 => 0.5,
        6 => 0.4,
        7 => 0.3,
        8 => 0.25,
        9 => 0.2,
        10 => 0.15
    ];

    protected function meetsRequirements(User $user, $rank): bool {
        $deposits = Deposit::where([
            'user_id' => $user->id,
        ])->sum('amount_paid');

        if ($deposits < $rank->deposits) {
            return false;
        }

        $directs = Referral::where('level_1_id', $user->id)->count();

        if ($directs < $rank->direct_referrals) {
            return false;
        }

        return true;
    }

    public function distribute(User $user, float $roiAmount) {
        $ref = Referral::where('user_id', $user->id)->first();

        if (!$ref) return;

        for ($level = 1; $level <= 10; $level++) {
            $uplineId = $ref->{"level_{$level}_id"};

            if (!$uplineId) continue;

            $upline = User::find($uplineId);
            if (!$upline) continue;

            $rank = $upline->currentRank?->rank->load('percentages');
            if (!$rank) continue;

            if (!$this->meetsRequirements($upline, $rank)) continue;

            $percentage = $rank->percentages
                ->where('level', $level)
                ->first()?->percentage ?? 0;

            if ($percentage <= 0) continue;

            $bonus = ($percentage / 100) * $roiAmount;

            if ($level > $rank->level) {
                // calculate for missed
                PerformanceBonus::create([
                    'user_id' => $upline->id,
                    'source_user_id' => $user->id,
                    'amount' => $bonus,
                    'percentage' => $percentage,
                    'level' => $level,
                    'roi_amount' => $roiAmount,
                    'type' => 'missed'
                ]);

                continue;
            }

            // $percentage = $this->percentages[$level] ?? 0;


            $p_bonus = PerformanceBonus::create([
                'user_id' => $upline->id,
                'source_user_id' => $user->id,
                'amount' => $bonus,
                'percentage' => $percentage,
                'level' => $level,
                'roi_amount' => $roiAmount,
                'type' => 'roi'
            ]);

            Transaction::create([
                'related_type' => PerformanceBonus::class,
                'related_id' => $p_bonus->id,
                'amount' => $bonus,
                'type' => 'performance_bonus',
                'user_id' => $upline->id
            ]);

            // Credit wallet
            $upline->increment('balance', $bonus);
        }

        $this->handleGlobalBonus($ref, $roiAmount);
    }



    protected function handleGlobalBonus(Referral $ref, float $roiAmount): void {
        for ($level = 1; $level <= 10; $level++) {
            $uplineId = $ref->{"level_{$level}_id"};
            if (!$uplineId) continue;

            $upline = User::find($uplineId);
            if (!$upline) continue;

            $rank = $upline->currentRank?->rank;
            if (!$rank) continue;

            if (!$this->meetsRequirements($upline, $rank)) continue;

            //Rank 10 & 11 → 0.5% override
            if ($rank->level >= 10) {

                $bonus = (0.5 / 100) * $roiAmount;

                PerformanceBonus::create([
                    'user_id' => $upline->id,
                    'source_user_id' => $ref->user_id,
                    'amount' => $bonus,
                    'percentage' => 0.5,
                    'level' => $rank->level,
                    'roi_amount' => $roiAmount,
                    'type' => 'global_override'
                ]);

                $upline->increment('balance', $bonus);
            }

            if ($rank->level == 11 || $rank->level == 8) {

                $poolBonus = (1 / 100) * $roiAmount;

                PerformanceBonus::create([
                    'user_id' => $upline->id,
                    'source_user_id' => $ref->user_id,
                    'amount' => $poolBonus,
                    'percentage' => 1,
                    'level' => $rank->level,
                    'roi_amount' => $roiAmount,
                    'type' => 'global_pool'
                ]);

                $upline->increment('balance', $poolBonus);
            }
        }

    }

}
