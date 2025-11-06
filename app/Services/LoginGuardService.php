<?php
namespace App\Services;

use Illuminate\Support\Carbon;

class LoginGuardService
{
    // call when a login fails
    public static function recordFailedAttempt($user) {
        $user->failed_logins++;
        $user->last_failed_at = Carbon::now();
        if ($user->failed_logins >= 5) {
            $user->is_suspended = true;
            $user->suspended_until = Carbon::now()->addMinutes(1); // hold 30 minutes
        }
        $user->save();
    }

    public static function resetFailures($user) {
        $user->failed_logins = 0;
        $user->last_failed_at = null;
        $user->is_suspended = false;
        $user->suspended_until = null;
        $user->save();
    }

    public static function isSuspended($user) {
        if (!$user->is_suspended) return false;
        if ($user->suspended_until && Carbon::now()->greaterThan($user->suspended_until)) {
            // auto-unsuspend
            $user->is_suspended = false;
            $user->suspended_until = null;
            $user->failed_logins = 0;
            $user->save();
            return false;
        }
        return true;
    }
}
