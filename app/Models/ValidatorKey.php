<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidatorKey extends Model
{
    protected $fillable = [
        'public_key',
        'validator_index',
        'label',
        'total_eth_staked',
        'apr',
        'status',
        'last_reported_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'last_reported_at' => 'datetime',
    ];
}
