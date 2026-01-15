<?php
namespace App\Models;

use App\Enums\StakeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stake extends Model {
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'started_at' => 'datetime',
        'next_payout_at' => 'datetime',
        'meta' => 'array',
        'status' => StakeStatus::class,
        'expected_end_date' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function plan() {
        return $this->belongsTo(StakingPlan::class, 'plan_id');
    }

    public function rewards() {
        return $this->hasMany(Reward::class);
    }

    public function getTotalClaimedAttribute() {
        return $this->rewards()
            ->where('status', 'claimed')
            ->sum('amount');
    }

    public function getTotalClaimableAttribute() {
        return $this->rewards()
            ->where('status', 'pending')
            ->sum('amount');
    }

    public function pause(): self {
        return $this->setStatus(StakeStatus::PAUSED);
    }

    public function resume(): self {
        return $this->setStatus(StakeStatus::ACTIVE);
    }

    public function markCompleted(): self {
        return $this->setStatus(StakeStatus::COMPLETED);
    }

    public function cancel(): self {
        return $this->setStatus(StakeStatus::CANCELLED);
    }

    protected function setStatus(StakeStatus $status): self {
        if ($this->status->isFinal()) {
            throw new \LogicException('Cannot change a finalized stake.');
        }

        $this->update(['status' => $status]);

        return $this;
    }
}
