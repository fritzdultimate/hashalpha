<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralReward extends Model {
    protected $fillable = ['user_id','from_user_id','level','amount','stake_id','status','meta'];
    protected $casts = ['meta'=>'array'];

    public function referralUser() {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}
