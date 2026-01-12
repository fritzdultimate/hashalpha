<?php

namespace App\Enums;

enum WithdrawalStatus: string
{
    case PENDING   = 'pending';
    case REVIEW    = 'review';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case FAILED    = 'failed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::REVIEW => 'Under Review',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::COMPLETED,
            self::FAILED,
            self::CANCELLED,
        ], true);
    }
}
