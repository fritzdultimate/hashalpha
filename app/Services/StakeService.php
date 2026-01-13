<?php

namespace App\Services;

use App\Enums\DepositStatus;
use App\Enums\StakeStatus;
use App\Models\Deposit;
use App\Models\Stake;
use Illuminate\Support\Facades\DB;

class StakeService {
    public static function markAsFinished(Stake $stake) {
       if ($stake->status === StakeStatus::FINISHED) {
            return;
        }

        DB::transaction(function () use ($stake) {

            $stake->markFinished();

            // 2. Credit user balance
            $user = $stake->user;
            $user->increment('balance', $stake->amount);

            // send email
        });
    }
}
