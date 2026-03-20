<?php

namespace App\Http\Controllers;
use App\Models\Challenge;
use App\Models\ChallengeCategory;
use App\Models\User;
use App\Services\LeaderBoardService;
use App\Services\Sprint2\LeaderboardEngineService;
use App\Services\Sprint2\MilestoneService;
use App\Services\Sprint2\QualificationService;


class LeaderBoardController extends Controller {
    public function leaderBoardEntry() {
        LeaderBoardService::scoreLeaderBoard();
    }

    public function sprintTwoEntry() {
        $categories = ChallengeCategory::where('phase', 2)->whereHas('challenge', function ($q) {
            $q->where('is_active', true);
        })->get();

        foreach ($categories as $category) {

            app(LeaderboardEngineService::class)
                ->calculate($category);
        }

        // $challenge = Challenge::where('is_active', true)->first();

        // User::chunk(200, function ($users) use ($challenge) {
        //     foreach ($users as $user) {
        //         app(MilestoneService::class)
        //         ->check($user, $challenge);

        //         app(QualificationService::class)
        //             ->check($user, $challenge);
        //     }
        // });

        
    }

    public function scoreMilestone() {
        $challenge = Challenge::where('is_active', true)->first();

        User::chunk(200, function ($users) use ($challenge) {
            foreach ($users as $user) {
                app(MilestoneService::class)
                    ->check($user, $challenge);
            }
        });
    }

    public function scoreQualification() {
        $challenge = Challenge::where('is_active', true)->first();

        User::chunk(200, function ($users) use ($challenge) {
            foreach ($users as $user) {
                app(QualificationService::class)
                    ->check($user, $challenge);
            }
        });
    }
}
