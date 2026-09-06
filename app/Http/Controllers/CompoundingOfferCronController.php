<?php

namespace App\Http\Controllers;

use App\Mail\CompoundingDailyProgressMail;
use App\Models\Stake;
use App\Services\CompoundingOfferService;
use Illuminate\Support\Facades\Mail;

class CompoundingOfferCronController extends Controller
{
    // Sends the optional "here's what you earned today" email for stakes
    // created from an accepted compounding offer that opted in to it.
    public function sendDailyProgress()
    {
        Stake::where('status', 'active')
            ->where('is_compounding_offer', true)
            ->where('notify_daily', true)
            ->chunkById(100, function ($stakes) {
                foreach ($stakes as $stake) {
                    $todaysReward = $stake->rewards()
                        ->where('credited_at', '>=', now()->subHours(24))
                        ->latest('credited_at')
                        ->first();

                    if (! $todaysReward) {
                        continue;
                    }

                    Mail::to($stake->user->email)->send(
                        new CompoundingDailyProgressMail($stake, (string) $todaysReward->amount)
                    );
                }
            });
    }

    // Sweeps offers whose decision window passed with no response from the user.
    public function expireOffers()
    {
        CompoundingOfferService::expireStaleOffers();
    }
}
