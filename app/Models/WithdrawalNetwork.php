<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalNetwork extends Model {
    protected $fillable = [
        'withdrawal_currency_id',
        'name',
        'network',
        'fee',
        'is_enabled'
    ];

    public function currency() {
        return $this->belongsTo(WithdrawalCurrency::class, 'withdrawal_currency_id');
    }

    public function withdrawals() {
        return $this->hasMany(Withdrawal::class);
    }
}
