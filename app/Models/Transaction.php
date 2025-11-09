<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $fillable = ['user_id', 'amount', 'meta', 'balance_after'];
    protected $casts = ['meta'=>'array'];

    public function setAmountAttribute($value) {
        $this->attributes['amount'] = (int) round($value * 100);
    }

    public function getAmountAttribute($value) {
        return $value / 100;
    }

    public function setBalanceAfterAttribute($value) {
        $this->attributes['balance_after'] = (int) round($value * 100);
    }

    public function getBalanceAfterAttribute($value) {
        return $value / 100;
    }
}
