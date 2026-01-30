<?php

namespace App\Services;

use App\Enums\DepositStatus;
use App\Enums\WithdrawalStatus;
use App\Mail\WithdrawalCompletedMail;
use App\Models\Deposit;
use App\Models\ReferralReward;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
            $totalToDebit = $withdrawal->meta['total_to_debit'] ?? $withdrawal->amount;
            if($withdrawal->asset === 'referral_rewards') {
                
                $totalAvailable = ReferralReward::where('user_id', $withdrawal->user->id)
                    ->get()
                    ->sum(fn ($reward) => $reward->amount - ($reward->withdrawn ?? 0));

                if ($totalToDebit > $totalAvailable) {
                    throw new \Exception('Insufficient referral balance');
                }

                $remaining = $totalToDebit;


                $rewards = ReferralReward::where('user_id', $withdrawal->user->id)
                    ->whereColumn('withdrawn', '<', 'amount')
                    ->orderBy('created_at')
                    ->lockForUpdate()
                    ->get();

                foreach ($rewards as $reward) {
                    if ($remaining <= 0) {
                        break;
                    }
                    $available = $reward->amount - $reward->withdrawn;

                    if ($available <= 0) {
                        continue;
                    }

                    if ($available >= $remaining) {
                        $reward->withdrawn += $remaining;
                        $reward->save();

                        $remaining = 0;
                        break;
                    }
                    $reward->withdrawn += $available;
                    $reward->save();

                    $remaining -= $available;
                }
                $withdrawal->markCompleted('-');
            } else {
                $user = $withdrawal->user()->lockForUpdate()->first();
                if (bccomp($user->balance, (string) $totalToDebit, 8) < 0) {
                    throw new \Exception('Insufficient balance');
                }
                $user->decrement('balance', $totalToDebit);
                $withdrawal->markCompleted('-');
            }

            if($withdrawal->status === WithdrawalStatus::COMPLETED) {
                Mail::to($withdrawal->user->email)->send(new WithdrawalCompletedMail($withdrawal));
            }
        });
    }

    public static function markAsProcessing(Withdrawal $withdrawal) {
        if ($withdrawal->status === WithdrawalStatus::COMPLETED || $withdrawal->status === WithdrawalStatus::FAILED) {
            return;
        }

        DB::transaction(function () use ($withdrawal) {

            $withdrawal->markProcessing();

            // send email
        });
    }

    public static function markAsFailed(Withdrawal $withdrawal) {

    }
}
