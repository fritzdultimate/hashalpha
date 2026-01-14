<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReferralLevel extends Model {
    protected $fillable = [
        'level',
        'percent_bps',
        'lock_days',
        'is_active',
    ];
}
