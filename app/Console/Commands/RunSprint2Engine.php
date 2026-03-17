<?php

namespace App\Console\Commands;

use App\Models\Challenge;
use App\Models\ChallengeCategory;
use App\Models\User;
use App\Services\Sprint2\LeaderboardEngineService;
use App\Services\Sprint2\MilestoneService;
use App\Services\Sprint2\QualificationService;
use Illuminate\Console\Command;

class RunSprint2Engine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-sprint2-engine';

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
        $categories = ChallengeCategory::where('phase', 2)->whereHas('challenge', function ($q) {
            $q->where('is_active', true);
        })->get();

        foreach ($categories as $category) {

            app(LeaderboardEngineService::class)
                ->calculate($category);
        }

        $users = User::all();
        $challenge = Challenge::where('is_active', true)->first();

        foreach ($users as $user) {

            app(MilestoneService::class)
                ->check($user, $challenge);

            app(QualificationService::class)
                ->check($user, $challenge);
        }
    }
}
