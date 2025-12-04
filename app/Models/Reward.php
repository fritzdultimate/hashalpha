<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model {
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'credited_at' => 'datetime'
    ];

    public function stake() {
        return $this->belongsTo(Stake::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function fromUser() {
        return $this->belongsTo(User::class, 'source_user_id');
    }
}
