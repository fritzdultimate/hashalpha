<?php
namespace App\Services;

use App\Models\Deposit;
use App\Models\PerformanceBonus;
use App\Models\PerformancePercentage;
use App\Models\Referral;
use App\Models\User;



class PerformanceBonusService {

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

    public static function distribute(User $user, float $roiAmount, $stakeId) {
        $ref = Referral::where('user_id', $user->id)->first();
        $percentages = PerformancePercentage::pluck('percentage', 'level');
        if (!$ref) return;

        $uplineIds = collect(range(1, 10))
            ->map(fn($level) => $ref->{"level_{$level}_id"})
            ->filter()
            ->values();

        $uplines = User::whereIn('id', $uplineIds)
            ->with('currentRank.rank')
            ->get()
            ->keyBy('id');

        for ($level = 1; $level <= 10; $level++) {
            $uplineId = $ref->{"level_{$level}_id"};


            if (!$uplineId) continue;

            // $upline = User::find($uplineId);
            $upline = $uplines[$uplineId] ?? null;
            if (!$upline) continue;


            $rank = $upline->currentRank?->rank->load('percentages');
            if (!$rank) continue;


            // if (!self::meetsRequirements($upline, $rank)) continue;

            // $percentage = PerformancePercentage::where('level', $level)
            //     ->first()?->percentage ?? 0;

            $percentage = $percentages[$level] ?? 0;

            if ($percentage <= 0) continue;

            $bonus = bcmul(
                $roiAmount,
                bcdiv((string)$percentage, '100', 8),
                8
            );

            if ($level > $rank->level) {
                // calculate for missed

                PerformanceBonus::firstOrCreate(
                    [
                        'user_id' => $upline->id,
                        'source_user_id' => $user->id,
                        'stake_id' => $stakeId,
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


            PerformanceBonus::firstOrCreate(
                [
                    'user_id' => $upline->id,
                    'source_user_id' => $user->id,
                    'stake_id' => $stakeId,
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

        self::handleGlobalBonus($ref, $roiAmount, $uplines, $stakeId);
    }



    protected static function handleGlobalBonus(Referral $ref, float $roiAmount, $uplines, $stakeId): void {
        foreach ($uplines as $upline) {

            $rank = $upline->currentRank?->rank;
            if (!$rank) continue;

            if (!self::meetsRequirements($upline, $rank)) continue;

            if ($rank->level >= 10) {

                $bonus = bcmul(
                    $roiAmount,
                    bcdiv('0.5', '100', 8),
                    8
                );

                PerformanceBonus::firstOrCreate(
                    [
                        'user_id' => $upline->id,
                        'source_user_id' => $ref->user_id,
                        'stake_id' => $stakeId,
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
            }

            if ($rank->level == 8 || $rank->level == 11) {
                $poolBonus = bcmul(
                    $roiAmount,
                    bcdiv('1', '100', 8),
                    8
                );

                PerformanceBonus::firstOrCreate(
                    [
                        'user_id' => $upline->id,
                        'source_user_id' => $ref->user_id,
                        'stake_id' => $stakeId,
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
            }
        }

    }

}
