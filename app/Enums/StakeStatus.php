<?php

namespace App\Enums;

enum StakeStatus: string
{
    case ACTIVE = 'active';
    case COMPLETED   = 'completed';
    case CANCELLED = 'canceled';
    case PAUSED = 'paused';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'active',
            self::COMPLETED => 'completed',
            self::CANCELLED => 'cancelled',
            self::PAUSED => 'paused',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::COMPLETED => 'info',
            self::PAUSED => 'warning',
            self::CANCELLED => 'danger',
        };
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::COMPLETED,
            self::CANCELLED,
        ], true);
    }
}
