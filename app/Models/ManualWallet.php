<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualWallet extends Model {
    protected $fillable = [
        'currency', 'label', 'network', 'address', 'qr_code_path', 'min_amount', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];
}
