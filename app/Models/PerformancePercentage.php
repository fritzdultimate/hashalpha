<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformancePercentage extends Model
{
    public $fillable = [
        'rank_id',
        'level',
        'percentage'
    ];

    public function rank() {
        return $this->belongsTo(Rank::class);
    }
}
