<?php

namespace App\Services\Sprint2;

use App\Models\Stake;
use App\Models\UnilevelPercentage;

class TeamVolumeService {
    public function getTotalTeamVolume($userId, $start, $end) {
        $percentages = UnilevelPercentage::pluck('percentage', 'level');

        $total = 0;

        for ($level = 1; $level <= 10; $level++) {

            $ids = getDownlineUsersByLevel($userId, $level);

            if (empty($ids)) continue;

            $volume = Stake::whereIn('user_id', $ids)
                ->whereBetween('created_at', [$start, $end])
                ->sum('amount');

            $percentage = $percentages[$level] ?? 0;

            $weighted = ($volume * $percentage) / 100;

            $total += $weighted;
        }

        return $total;
    }

    public function getLevelOneVolume($userId, $start, $end) {
        $ids = getDownlineUserIds($userId, 1);

        return Stake::whereIn('user_id', $ids)
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');
    }

    public function getPersonalVolume($userId, $start, $end) {
        return Stake::where('user_id', $userId)
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');
    }

    public function countHighActivations($userId, $start, $end) {
        return Stake::whereIn('user_id', getDownlineUserIds($userId, 1))
            ->where('amount', '>=', 1000)
            ->whereBetween('created_at', [$start, $end])
            ->count();
    }
}