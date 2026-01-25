<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\RankEvaluatorService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class EvaluateUserRanks {
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::query()
            ->where('is_suspended', false)
            ->chunkById(200, function ($users) {
                foreach ($users as $user) {
                    RankEvaluatorService::evaluate($user);
                }
            });
    }
}
