<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class RankBonus extends Model {
    protected $fillable = [
        'user_id',
        'rank_id',
        'amount',
        'title',
        'description',
        'status',
        'credited_at',
        'locked_at',
        'withdrawn'
    ];

    protected $cast = [
        'credited_at' => 'datetime',
        'locked_at' => 'datetime'
    ];

    public function getAvailableAttribute() {
        return bcsub($this->amount, $this->withdrawn, 8);
    }


    protected static function booted() {
        static::deleting(function ($rankBonus) {
            $rankBonus->transaction()?->delete();
        });

        static::saving(function ($rankBonus) {
            if (bccomp(
                (string) $rankBonus->withdrawn,
                (string) $rankBonus->amount,
                8
            ) === 1) {
                throw ValidationException::withMessages([
                    'withdrawn' => 'Withdrawn amount cannot be greater than bonus amount.',
                ]);
            }
        });
    }

    public function transaction() {
        return $this->morphOne(Transaction::class, 'related');
    }
}
