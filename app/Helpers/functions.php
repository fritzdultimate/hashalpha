<?php

use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
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
    do {
        $base = strtolower(trim($email)) . config('app.key') . bin2hex(random_bytes(4));

        
        $hash = hash('sha256', $base);

        $code = strtoupper(substr(base_convert(substr($hash, 0, 16), 16, 36), 0, $length));

        // Check if it exists in DB
        $exists = User::where('affiliate_code', $code)->exists();
    } while ($exists);

    return $code;
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

function getDownlineUserIds(int $userId, int $maxDepth = 10): array
{
    $currentLevel = [$userId];
    $all = [];

    for ($i = 0; $i < $maxDepth; $i++) {

        $nextLevel = Referral::whereIn('level_1_id', $currentLevel)
            ->pluck('user_id')
            ->toArray();

        if (empty($nextLevel)) {
            break;
        }

        $all = array_merge($all, $nextLevel);

        // move to next depth
        $currentLevel = $nextLevel;
    }

    return array_values(array_unique($all));
}

function mask($target) {
    if (!$target) return '—';

    $length = strlen($target);

    if ($length <= 2) {
        return substr($target, 0, 1) . '*';
    }
    return substr($target, 0, 2) . str_repeat('*', max(0, $length - 4)) . substr($target, -2);
}

if (!function_exists('mask_email')) {
    function mask_email($email)
    {
        if (!$email || !str_contains($email, '@')) {
            return '—';
        }

        [$name, $domain] = explode('@', $email);

        $nameLength = strlen($name);

        $visible = min(5, max(3, floor($nameLength / 2)));

        $masked = substr($name, 0, $visible)
            . str_repeat('*', max(2, $nameLength - $visible));

        return $masked . '@' . $domain;
    }
}

