<?php

namespace App\Services;

use App\Enums\DepositStatus;
use App\Models\Deposit;
use Illuminate\Support\Facades\DB;

class DepositService {
    public static function markAsFinished(Deposit $deposit) {
       if ($deposit->status === DepositStatus::FINISHED) {
            return;
        }

        DB::transaction(function () use ($deposit) {

            $deposit->markFinished();

            // 2. Credit user balance
            $user = $deposit->user;
            $user->increment('balance', $deposit->amount);

            // send email
        });
    }
}
