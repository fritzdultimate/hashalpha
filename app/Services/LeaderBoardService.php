<?php

namespace App\Services;
use App\Models\ChallengeCategory;
use App\Models\ChallengeEntry;
use App\Models\LeaderboardReferralBreakage;
use App\Models\Referral;
use App\Models\Stake;
use App\Models\User;

class LeaderBoardService {
    public static function scoreLeaderBoard() {
        $categories = ChallengeCategory::with('challenge')->get()->keyBy('type');

        // dd(getDownlineUserIds(1));

        User::where('is_suspended', false)
            ->chunk(100, function ($users) use ($categories) {
                // dd($users);

                foreach ($users as $user) {

                    // 🥇 VOLUME
                    self::scoreForVolume($user, $categories['volume'] ?? null);
                    

                    // 🚀 New Members
                    self::scoreForTopNewMembers($user, $categories['new_members'] ?? null);

                    self::scoreForFastestNewUserActivators($user, $categories['fastest'] ?? null);
                }
        });

        foreach ($categories as $category) {

            $entries = ChallengeEntry::where('challenge_category_id', $category->id)
                ->orderByDesc('score')
                ->orderByRaw('completed_at IS NULL')
                ->orderBy('completed_at')
                ->get();

            foreach ($entries as $index => $entry) {
                $entry->rank = $index + 1;
                $entry->save();
            }
        }
    }

    private static function scoreForVolume($user, $category) {
        if (!$category) return;
        $downline = getDownlineUserIds($user->id, 1);

        // dd(getDownlineUserIds(23, 1));



        $score = Stake::whereIn('user_id', $downline)
            ->whereBetween('created_at', [$category->challenge->start_at, $category->challenge->end_at])
            ->sum('amount');

        // $score = 0;

        // for ($level = 1; $level <= 10; $level++) {

        //     $usersAtLevel = getDownlineUsersByLevel($user->id, $level);

        //     if (empty($usersAtLevel)) continue;

        //     $percentage = LeaderboardReferralBreakage::where('level', $level)->value('percentage') ?? 0;

        //     $volume = Stake::whereIn('user_id', $usersAtLevel)
        //         ->whereBetween('created_at', [
        //             $category->challenge->start_at,
        //             $category->challenge->end_at
        //         ])
        //         ->sum('amount');

        //     $score += ($volume * ($percentage / 100));
        // }



        ChallengeEntry::updateOrCreate(
            [
                'challenge_id' => $category->challenge->id,
                'challenge_category_id' => $category->id,
                'user_id' => $user->id
            ],
            [
                'score' => $score,
                'completed_at' => null
            ]
        );
    }

    private static function scoreForTopNewMembers($user, $category) {
        if (!$category) return;
        $score = Referral::where('level_1_id', $user->id)
            ->whereHas('user', function ($q) use ($category) {
                $q->whereBetween('created_at', [
                    $category->challenge->start_at,
                    $category->challenge->end_at
                ])
                ->whereHas('stakes', function ($q) use ($category) {
                    $q->whereBetween('created_at', [
                        $category->challenge->start_at,
                        $category->challenge->end_at
                    ]);
                })
                ->withSum(['stakes as total_staked' => function ($q) use ($category) {
                    $q->whereBetween('created_at', [
                        $category->challenge->start_at,
                        $category->challenge->end_at
                    ]);
                }], 'amount')
                ->having('total_staked', '>=', $category->min_activation_amount ?? 200);
            })
            ->count();

        ChallengeEntry::updateOrCreate(
            [
                'challenge_id' => $category->challenge->id,
                'challenge_category_id' => $category->id,
                'user_id' => $user->id
            ],
            [
                'score' => $score,
                'completed_at' => null
            ]
        );
    }

    private static function scoreForFastestNewUserActivators($user, $category) {
        if (!$category) return;
        $score = 0;
        $completedAt = null;

        $refs = Referral::where('level_1_id', $user->id)
            ->with(['user.stakes' => function ($q) use ($category) {
                // $q->where('amount', '>=', $category->min_activation_amount ?? 500)
                $q->whereBetween('created_at', [
                    $category->challenge->start_at,
                    $category->challenge->end_at
                ])
                ->orderBy('created_at');
            }])
            ->get()
            ->filter(function ($ref) {
                return $ref->user &&
                    $ref->user->stakes->isNotEmpty();
            })
            ->filter(function ($ref) use ($category) {

                if (!$ref->user || $ref->user->stakes->isEmpty()) {
                    return false;
                }

                $total = $ref->user->stakes->sum('amount');

                return $total >= ($category->min_activation_amount ?? 500);
            })
            ->map(function ($ref) {
                return optional($ref->user->stakes->first())->created_at;
            })
            ->sort()
            ->values();

            if ($refs->count() >= 7) {
                $first7 = $refs->take(7);
                $completedAt = $first7->max();
                $score = 7;
            }

        ChallengeEntry::updateOrCreate(
            [
                'challenge_id' => $category->challenge->id,
                'challenge_category_id' => $category->id,
                'user_id' => $user->id
            ],
            [
                'score' => $score,
                'completed_at' => $completedAt
            ]
        );
    }
}
