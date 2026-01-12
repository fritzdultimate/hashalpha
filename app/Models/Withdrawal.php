<?php

namespace App\Models;

use App\Enums\WithdrawalStatus;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model {
    protected $fillable = [
        'user_id',
        'wallet_id',
        'amount',
        'address',
        'network',
        'status',
        'tx_hash',
        'failure_reason',
        'processed_at',
    ];

    protected $casts = [
        'status' => WithdrawalStatus::class,
        'processed_at' => 'datetime',
    ];

    /* --------------------
     | STATUS TRANSITIONS
     -------------------- */

    public function markReview(): self {
        return $this->setStatus(WithdrawalStatus::REVIEW);
    }

    public function markProcessing(): self
    {
        return $this->setStatus(WithdrawalStatus::PROCESSING);
    }

    public function markCompleted(string $txHash): self {
        $this->update([
            'tx_hash' => $txHash,
            'processed_at' => now(),
        ]);
        return $this->setStatus(WithdrawalStatus::COMPLETED);
    }

    public function markFailed(string $reason): self {
        $this->update([
            'failure_reason' => $reason,
            'processed_at' => now(),
        ]);

        return $this->setStatus(WithdrawalStatus::FAILED);
    }

    public function cancel(): self {
        return $this->setStatus(WithdrawalStatus::CANCELLED);
    }

    protected function setStatus(WithdrawalStatus $status): self {
        if ($this->status->isFinal()) {
            throw new \LogicException('Cannot change a finalized withdrawal.');
        }

        $this->update(['status' => $status]);

        return $this;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
