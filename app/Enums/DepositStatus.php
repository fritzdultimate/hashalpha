<?php

namespace App\Enums;

enum DepositStatus: string
{
    case WAITING = 'waiting';
    case PENDING   = 'pending';
    case CONFIRMED    = 'confirmed';
    case PARTIALLYPAID = 'partially_paid';
    case FINISHED = 'finished';
    case FAILED    = 'failed';
    case CANCELLED = 'canceled';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::WAITING => 'waiting',
            self::PARTIALLYPAID => 'partially_paid',
            self::CONFIRMED => 'confirmed',
            self::FAILED => 'Failed',
            self::CANCELLED => 'Cancelled',
            self::FINISHED => 'finished',
            self::EXPIRED => 'expired'
        };
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::FINISHED,
            self::FAILED,
            self::CANCELLED,
            self::EXPIRED,
        ], true);
    }
}
