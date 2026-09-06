<?php

namespace App\Models;

use App\Enums\CompoundingOfferStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompoundingOffer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => CompoundingOfferStatus::class,
        'notify_daily' => 'boolean',
        'offered_at' => 'datetime',
        'expires_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The matured stake this offer was generated from.
    public function stake()
    {
        return $this->belongsTo(Stake::class, 'stake_id');
    }

    public function plan()
    {
        return $this->belongsTo(StakingPlan::class, 'plan_id');
    }

    // The new locked stake created once the user accepts.
    public function newStake()
    {
        return $this->belongsTo(Stake::class, 'new_stake_id');
    }

    public function isPending(): bool
    {
        return $this->status === CompoundingOfferStatus::OFFERED
            && (! $this->expires_at || $this->expires_at->isFuture());
    }
}
