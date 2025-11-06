<?php

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
