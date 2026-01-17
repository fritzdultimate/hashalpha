<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidatorBlock extends Model
{
    protected $fillable = [
        'validator_id',
        'block_hash',
        'status',
        'validated_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    public function validator()
    {
        return $this->belongsTo(StakingPlan::class, 'validator_id');
    }
}
