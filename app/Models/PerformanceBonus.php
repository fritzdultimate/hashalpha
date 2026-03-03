<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceBonus extends Model {
    protected $fillable = [
        'user_id',
        'source_user_id',
        'amount',
        'percentage',
        'level',
        'roi_amount',
        'type',
        'synced_bonus',
        'bonus_date',
        'stake_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sourceUser() {
        return $this->belongsTo(User::class, 'source_user_id');
    }
}
