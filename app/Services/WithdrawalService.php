<?php

namespace App\Services;

use App\Enums\DepositStatus;
use App\Enums\WithdrawalStatus;
use App\Models\Deposit;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class  WithdrawalService {
    public static function review(Withdrawal $withdrawal) {
       if ($withdrawal->status === WithdrawalStatus::COMPLETED) {
            return;
        }

        DB::transaction(function () use ($withdrawal) {

            $withdrawal->markReview();

            // send email
        });
    }

    public static function complete(Withdrawal $withdrawal) {
       if ($withdrawal->status === WithdrawalStatus::COMPLETED || $withdrawal->status === WithdrawalStatus::FAILED || $withdrawal->status === WithdrawalStatus::CANCELLED) {
            return;
        }

        DB::transaction(function () use ($withdrawal) {

            $withdrawal->user()->decrement('balance', $withdrawal->amount);
            $withdrawal->markCompleted('djssdoas');

            // send email
        });
    }

    public static function markAsProcessing(Withdrawal $withdrawal) {

    }

    public static function markAsFailed(Withdrawal $withdrawal) {

    }
}
