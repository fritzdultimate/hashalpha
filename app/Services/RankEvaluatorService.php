<?php
namespace App\Services;

use App\Models\Rank;
use App\Models\ReferralReward;
use App\Models\Stake;
use App\Models\User;
use App\Models\UserRank;

class RankEvaluatorService {
    public static function evaluate(User $user): void {
        $volume = Stake::where('referrer_id', $user->id)->sum('amount');

        $activeReferrals = ReferralReward::where('user_id', $user->id)
            ->whereHas('referralUser', fn($q) => $q->where('is_suspended', false))
            ->distinct('from_user_id')
            ->count('from_user_id');

        $earnings = ReferralReward::where('user_id', $user->id)
            ->where('status', 'claimed')
            ->sum('amount');

        $eligibleRank = Rank::orderBy('level')
            ->get()
            ->last(fn($rank) =>
                $volume >= $rank->required_volume &&
                $activeReferrals >= $rank->required_active_referrals &&
                $earnings >= $rank->required_earnings
            );

        if (!$eligibleRank) return;

        UserRank::updateOrCreate(
            ['user_id' => $user->id],
            [
                'rank_id' => $eligibleRank->id,
                'achieved_at' => now(),
            ]
        );
    }
}
