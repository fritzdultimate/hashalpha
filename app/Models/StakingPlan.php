<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StakingPlan extends Model {
    use HasFactory;
    protected $guarded = [];

    public function setMinAmountAttribute($value) {
        $this->attributes['min_amount'] = (int) round($value * 100);
    }

    public function getMinAmountAttribute($value) {
        return $value / 100;
    }

    public function setMaxAmountAttribute($value) {
        $this->attributes['max_amount'] = (int) round($value * 100);
    }

    public function getMaxAmountAttribute($value) {
        return $value / 100;
    }


    public function stakes() {
        return $this->hasMany(Stake::class, 'plan_id');
    }
}
