<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ValidatorReward extends Model {
    protected $fillable = [
        'reward_date',
        'amount',
        'status',
        'source',
    ];

    protected $casts = [
        'reward_date' => 'date',
        'amount' => 'decimal:8',
    ];
}
