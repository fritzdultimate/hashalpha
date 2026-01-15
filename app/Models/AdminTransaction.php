<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminTransaction extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'reason',
        'admin_id',
        'created_at',
        'updated_at'
    ];

    public function setAmountAttribute($value) {
        $this->attributes['amount'] = (int) round($value * 100);
    }

    public function getAmountAttribute($value) {
        return $value / 100;
    }


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
