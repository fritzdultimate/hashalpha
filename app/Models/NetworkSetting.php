<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NetworkSetting extends Model {
    protected $fillable = [
        'total_validators',
        'active_validators',
        'network_uptime',
        'uptime_90_days',
    ];
}
