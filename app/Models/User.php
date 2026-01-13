<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'firstname',
        'lastname'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted() {
        static::creating(function ($user) {
            if (!$user->affiliate_code) {
                $user->affiliate_code = generateReferralCode($user->email);
            }
        });
    }
    
    public function getFullNameAttribute(): string {
        return trim($this->first_name . ' ' . $this->last_name);
    }   

    public function hasUnsettledDeposit(): bool {

        return $this->deposits()
            ->whereIn('status', ['pending', 'waiting', 'partially_paid'])
            ->exists();
    }

    public function referrer() {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referral() {
        return $this->hasOne(Referral::class);
    }

    public function referrals() {
        return $this->hasMany(Referral::class, 'referred_by_id');
    }

    public function referredUsers() {
        return $this->hasMany(User::class, 'referrer_id');
    }

    public function deposits() {
        return $this->hasMany(Deposit::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function stakes() {
        return $this->hasMany(Stake::class);
    }

    public function withdrawals() {
        return $this->hasMany(Withdrawal::class);
    }

    public function rewards() {
        return $this->hasMany(Reward::class);
    }

    public function wallets() {
        return $this->hasMany(Wallet::class);
    }

    public function rank() {
        return $this->hasOne(UserRank::class);
    }

}
