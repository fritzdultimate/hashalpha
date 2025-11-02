<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model {
    protected $fillable = ['user_id','subject','message','type','priority','status','platform','meta','attachment_path'];
    protected $casts = ['meta'=>'array'];
}
