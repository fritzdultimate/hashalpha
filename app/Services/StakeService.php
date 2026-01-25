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

    public static function lockReward(Stake $stake): void {
        abort_if($stake->lock_roi, 403);

        DB::transaction(function () use ($stake) {

            // Lock the stake
            $stake->update([
                'lock_roi' => true,
            ]);

            $stake->rewards()
                ->whereNull('rewards_locked_at')
                ->update([
                    'rewards_locked_at' => now(),
                    'status' => 'locked',
                ]);
        });
    }

    public static function unlockReward(Stake $stake): void {
        abort_if(! $stake->lock_roi, 403);

        DB::transaction(function () use ($stake) {

            $stake->update([
                'lock_roi' => false,
            ]);

            $stake->rewards()
                ->whereNotNull('rewards_locked_at')
                ->where('status', 'locked')
                ->update([
                    'rewards_locked_at' => null,
                    'status' => 'pending',
                ]);
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
