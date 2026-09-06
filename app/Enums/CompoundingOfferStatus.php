<?php

namespace App\Enums;

enum CompoundingOfferStatus: string
{
    case OFFERED = 'offered';
    case ACCEPTED = 'accepted';
    case DECLINED = 'declined';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::OFFERED => 'Offered',
            self::ACCEPTED => 'Accepted',
            self::DECLINED => 'Declined',
            self::EXPIRED => 'Expired',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::OFFERED => 'warning',
            self::ACCEPTED => 'success',
            self::DECLINED => 'gray',
            self::EXPIRED => 'danger',
        };
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::ACCEPTED,
            self::DECLINED,
            self::EXPIRED,
        ], true);
    }
}
