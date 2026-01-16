<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'amount_usd_cents',
        'balance_after',
        'related_type',
        'related_id',
        'meta',
        'created_at',
        'updated_at'
    ];
    protected $casts = ['meta' => 'array'];

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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function related() {
        return $this->morphTo(
            name: 'related',
            type: 'related_type',
            id: 'related_id'
        );
    }


}
