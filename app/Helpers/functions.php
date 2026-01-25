<?php

use App\Models\Transaction;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

if (!function_exists('remaining_time_until')) {
    /**
     * Get remaining time (hours, minutes, seconds) until a given timestamp.
     *
     * @param  string|\DateTimeInterface|null  $is_suspended_until
     * @return string
     */
    function remaining_time_until($is_suspended_until)
    {
        if (!$is_suspended_until) {
            return '0s';
        }

        $tz = $timezone ?? config('app.timezone', 'UTC');

        $now = Carbon::now();
        $until = Carbon::parse($is_suspended_until)->setTimezone($tz);

        if ($until->isPast()) {
            return '0s';
        }

        $diffInSeconds = $until->diffInSeconds($now);
        $hours = floor($diffInSeconds / 3600);
        $minutes = floor(($diffInSeconds % 3600) / 60);
        $seconds = $diffInSeconds % 60;

        return sprintf('%02dh %02dm %02ds', $hours, $minutes, $seconds);
    }

    if (!function_exists('isRoute')) {
        /**
         * Check if the current route matches one or more route names.
         *
         * @param  string|array  $names
         * @return bool
         */
        function isRoute($names): bool {
            if (is_array($names)) {
                return in_array(Route::currentRouteName(), $names, true);
            }

            return Route::currentRouteName() === $names;
        }
    }
}

function generateReferralCode(string $email, int $length = 8): string {
    $base = strtolower(trim($email)) . config('app.key');

    // Create deterministic hash
    $hash = hash('sha256', $base);

    return strtoupper(substr(base_convert(substr($hash, 0, 16), 16, 36), 0, $length));
}


function logWithdrawalTransaction(
    Withdrawal $withdrawal,
    string $type,
    ?float $amount = null,
    array $meta = []
) {
    Transaction::create([
        'user_id' => $withdrawal->user_id,
        'type' => $type,
        'amount' => $amount ?? 0,
        'balance_after' => $withdrawal->user->balance,
        'related_type' => Withdrawal::class,
        'related_id' => $withdrawal->id,
        'meta' => $meta,
    ]);
}

