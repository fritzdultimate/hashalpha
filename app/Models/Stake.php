<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stake extends Model {
    protected $fillable = ['user_id', 'amount', 'meta'];
    protected $casts = ['meta'=>'array'];
}
