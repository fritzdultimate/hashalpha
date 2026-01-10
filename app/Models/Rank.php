<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model {
    protected $fillable = [
        'name',
        'level',
        'required_volume',
        'required_active_referrals',
        'required_earnings',
    ];
}
