<?php

namespace App\Enums;

enum RewardStatus: string
{
    case CLAIMED = 'claimed';
    case PENDING   = 'pending';
    case COMPOUNDED    = 'compounded';
    case LOCKED    = 'locked';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CLAIMED => 'claimed',
            self::COMPOUNDED => 'compounded',
            self::LOCKED => 'locked'
        };
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::CLAIMED,
            self::COMPOUNDED,
        ], true);
    }
}
