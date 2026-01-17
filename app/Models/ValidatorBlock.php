<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidatorBlock extends Model
{
    protected $fillable = [
        'validator_id',
        'block_hash',
        'block_number',
        'status',
        'validated_at',
    ];

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    public function validator()
    {
        return $this->belongsTo(StakingPlan::class, 'validator_id');
    }
}
