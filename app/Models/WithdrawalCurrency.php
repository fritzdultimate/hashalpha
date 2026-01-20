<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalCurrency extends Model {
    protected $fillable = ['code', 'name', 'is_enabled'];

    public function networks() {
        return $this->hasMany(WithdrawalNetwork::class);
    }

    public function withdrawals() {
        return $this->hasMany(Withdrawal::class);
    }
}
