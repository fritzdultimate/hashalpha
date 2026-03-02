<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model {
    protected $fillable = [
        'name',
        'level',
        'required_volume',
        'required_active_referrals',
        'required_earnings',
        'bonus',
        'deposits',
        'direct_referrals',
        'global_pool_share',
        'global_override'
    ];

    public function ranks() {
        return $this->hasMany(UserRank::class);
    }

    public function percentages() {
        return $this->hasMany(PerformancePercentage::class);
    }
}
