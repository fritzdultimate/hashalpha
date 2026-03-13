<?php

namespace App\Enums;

enum DepositStatus: string
{
    case WAITING = 'waiting';
    case PENDING   = 'pending';
    case CONFIRMED    = 'confirmed';
    case CONFIRMING    = 'confirming';
    case SENDING    = 'sending';
    case PARTIALLYPAID = 'partially_paid';
    case FINISHED = 'finished';
    case FAILED    = 'failed';
    case CANCELLED = 'canceled';
    case REFUNDED = 'refunded';
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
            self::EXPIRED => 'expired',

            self::SENDING => 'Sending',
            self::REFUNDED => 'Refunded',
            self::CONFIRMING => 'Confirming',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::WAITING => 'warning',
            self::PARTIALLYPAID => 'info',
            self::CONFIRMED => 'info',
            self::FAILED => 'danger',
            self::CANCELLED => 'danger',
            self::FINISHED => 'success',
            self::EXPIRED => 'danger',

            self::SENDING => 'info',
            self::REFUNDED => 'danger',
            self::CONFIRMING => 'info',
        };
    }

    public function isFinal(): bool{
        return in_array($this, [
            self::FINISHED,
            self::FAILED,
            self::CANCELLED,
            self::EXPIRED,
        ], true);
    }
}
