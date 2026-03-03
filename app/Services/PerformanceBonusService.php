<?php
namespace App\Services;

use App\Models\Deposit;
use App\Models\PerformanceBonus;
use App\Models\PerformancePercentage;
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

    protected static function meetsRequirements(User $user, $rank): bool {
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

    public static function distribute(User $user, float $roiAmount) {
        $ref = Referral::where('user_id', $user->id)->first();


        if (!$ref) return;

        for ($level = 1; $level <= 10; $level++) {
            $uplineId = $ref->{"level_{$level}_id"};


            if (!$uplineId) continue;

            $upline = User::find($uplineId);
            if (!$upline) continue;


            $rank = $upline->currentRank?->rank->load('percentages');
            if (!$rank) continue;


            if (!self::meetsRequirements($upline, $rank)) continue;

            $percentage = PerformancePercentage::where('level', $level)
                ->first()?->percentage ?? 0;

            if ($percentage <= 0) continue;

            $bonus = ($percentage / 100) * $roiAmount;

            if ($level > $rank->level) {
                // calculate for missed

                PerformanceBonus::firstOrCreate(
                    [
                        'user_id' => $upline->id,
                        'source_user_id' => $user->id,
                        'level' => $level,
                        'bonus_date' => now()->toDateString(),
                    ],
                    [
                        'amount' => $bonus,
                        'percentage' => $percentage,
                        'roi_amount' => $roiAmount,
                        'type' => 'missed'
                    ]
                );

                continue;
            }

            // $percentage = $this->percentages[$level] ?? 0;

            PerformanceBonus::firstOrCreate(
                [
                    'user_id' => $upline->id,
                    'source_user_id' => $user->id,
                    'level' => $level,
                    'bonus_date' => now()->toDateString(),
                ],
                [
                    'amount' => $bonus,
                    'percentage' => $percentage,
                    'roi_amount' => $roiAmount,
                    'type' => 'roi'
                ]
            );
        }

        self::handleGlobalBonus($ref, $roiAmount);
    }



    protected static function handleGlobalBonus(Referral $ref, float $roiAmount): void {
        for ($level = 1; $level <= 10; $level++) {
            $uplineId = $ref->{"level_{$level}_id"};
            if (!$uplineId) continue;

            $upline = User::find($uplineId);
            if (!$upline) continue;

            $rank = $upline->currentRank?->rank;
            if (!$rank) continue;

            if (!self::meetsRequirements($upline, $rank)) continue;

            //Rank 10 & 11 → 0.5% override
            if ($rank->level >= 10) {

                $bonus = (0.5 / 100) * $roiAmount;

                PerformanceBonus::firstOrCreate(
                    [
                        'user_id' => $upline->id,
                        'source_user_id' => $ref->user_id,
                        'level' => $rank->level,
                        'bonus_date' => now()->toDateString(),
                    ],
                    [
                        'amount' => $bonus,
                        'percentage' => 0.5,
                        'roi_amount' => $roiAmount,
                        'type' => 'global_override'
                    ]
                );

                // $upline->increment('balance', $bonus);
            }

            if ($rank->level == 11 || $rank->level == 8) {

                $poolBonus = (1 / 100) * $roiAmount;

                PerformanceBonus::firstOrCreate(
                    [
                        'user_id' => $upline->id,
                        'source_user_id' => $ref->user_id,
                        'level' => $rank->level,
                        'bonus_date' => now()->toDateString(),
                    ],
                    [
                        'amount' => $poolBonus,
                        'percentage' => 1,
                        'roi_amount' => $roiAmount,
                        'type' => 'global_pool'
                    ]
                );

                // $upline->increment('balance', $poolBonus);
            }
        }

    }

}
