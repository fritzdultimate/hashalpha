<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id', 
        'amount', 
        'meta', 
        'currency', 
        'wallet_id', 
        'nowpayments_invoice_id',
        'amount_paid',
        'note'
    ];
    protected $casts = [
        'meta' => 'array',
        'processed_at' => 'datetime',
    ];

    public function wallet() {
        return $this->belongsTo(Wallet::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
