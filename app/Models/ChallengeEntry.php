<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeEntry extends Model {
    public $fillable = [
        'challenge_id',
        'challenge_category_id',
        'user_id',
        'score',
        'rank',
        'completed_at'
    ];

    public $casts = [
        'completed_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function challenge() {
        return $this->belongsTo(Challenge::class);
    }

    public function category() {
        return $this->belongsTo(ChallengeCategory::class);
    }
}
