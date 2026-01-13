<?php

namespace App\Services;

use App\Enums\DepositStatus;
use App\Enums\StakeStatus;
use App\Models\Deposit;
use App\Models\Stake;
use Illuminate\Support\Facades\DB;

class StakeService {
    public static function pause(Stake $stake) {
        if ($stake->status === StakeStatus::COMPLETED || $stake->status === StakeStatus::CANCELLED) {
            return;
        }

        DB::transaction(function () use ($stake) {

            $stake->pause();

            // send email
        });
    }

    public static function resume(Stake $stake) {
        if ($stake->status === StakeStatus::COMPLETED || $stake->status === StakeStatus::CANCELLED) {
            return;
        }

        DB::transaction(function () use ($stake) {

            $stake->resume();

            // send email
        });
    }
}
