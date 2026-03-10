<?php

namespace App\Services;

use App\Models\AdminTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BalanceService {
    public static function credit(User $user, float $amount, ?string $reason, User $admin): void
    {
        DB::transaction(function () use ($user, $amount, $reason, $admin) {
            $user->increment('balance', $amount);

            AdminTransaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'credit',
                'reason' => $reason,
                'admin_id' => $admin->id,
            ]);
        });
    }

    public static function leaderboard(User $user, float $amount): void
    {
        DB::transaction(function () use ($user, $amount) {
            $user->increment('balance', $amount);

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'Sprint-1 Reward',
                'related_type' => User::class,
                'related_id' => $user->id,
                'meta' => [
                    'status' => 'credited'
                ]
            ]);
        });
    }

    public static function debit(User $user, float $amount, ?string $reason, User $admin): void
    {
        if ($user->balance < $amount) {
            throw new \Exception('Insufficient balance');
        }

        DB::transaction(function () use ($user, $amount, $reason, $admin) {
            $user->decrement('balance', $amount);

            AdminTransaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'debit',
                'reason' => $reason,
                'admin_id' => $admin->id,
            ]);
        });
    }
}
