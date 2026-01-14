<?php
namespace App\Models;

use App\Enums\RewardStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model {
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'credited_at' => 'datetime',
        'status' => RewardStatus::class

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
