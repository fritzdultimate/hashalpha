<?php

namespace App\Services;

use App\Models\User;

class AudienceResolver {
    public static function resolve(array $filters) {
        $query = User::query();

        if (in_array('active', $filters)) {
            $query->where('is_suspended', false);
        }

        if (in_array('suspended', $filters)) {
            $query->where(function ($q) {
                $q->where('is_suspended', true)
                  ->orWhere('suspended_until', '>', now());
            });
        }

        if (in_array('leaders', $filters)) {
            $query->where('is_leader', true);
        }

        if (in_array('recent', $filters)) {
            $days = request('recent_days', 7);
            $query->where('created_at', '>=', now()->subDays($days));
        }

        if (in_array('funded', $filters)) {
            $query->whereHas('wallets', fn ($q) =>
                $q->where('balance', '>', 0)
            );
        }

        if (in_array('kyc', $filters)) {
            $query->whereHas('kycVerification', fn ($q) =>
                $q->where('status', 'approved')
            );
        }

        // dd($query->whereNotNull('email')->pluck('email')->toArray());
        return $query->whereNotNull('email')->pluck('email')->toArray();
    }
}
