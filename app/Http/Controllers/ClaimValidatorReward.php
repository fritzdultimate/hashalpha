<?php

namespace App\Http\Controllers;

use App\Models\ValidatorReward;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClaimValidatorReward extends Controller {
    /**
     * Claim pending validator rewards after 1–10 minutes of creation
     */
    public function handle()
    {
        $now = now();

        
        $rewards = ValidatorReward::where('status', 'pending')
            ->whereRaw('TIMESTAMPDIFF(MINUTE, created_at, ?) >= 1', [$now])
            ->get();

        foreach ($rewards as $reward) {
            $minutesSinceCreation = $now->diffInMinutes($reward->created_at);
            $randomDelay = rand(1, 10);

            if ($minutesSinceCreation >= $randomDelay) {
                $reward->update([
                    'status' => 'distributed',
                ]);

                Log::info("Validator reward {$reward->id} claimed ({$reward->amount})");
            }
        }
    }
}
