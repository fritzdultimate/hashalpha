<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\Referral;
use App\Models\ReferralReward;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ReferralCenter extends Component {

    public $referralLink;
    public int $totalReferrals = 0;
    public int $activeReferrals = 0;
    public float $totalEarnings = 0;
    public float $thisMonth = 0;
    public $referrals = [];

    public function mount() {
        $user = Auth::user();
        $userId = auth()->id();
        $this->referralLink = Cache::remember("user{$user->id}:affiliate_link", 6000, function() use($user)  {
            $code = $user->affiliate_code ?? generateReferralCode($user->email);
            return route('register', ['ref' => $code]); 
        });

        $this->totalReferrals = Referral::where('referred_by_id', auth()->id())->count();

        $this->activeReferrals = Referral::where('referred_by_id', auth()->id())
            ->whereHas('user.stakes', function ($q) {
                $q->where('status', 'active');
            })
            ->count();

        $this->totalEarnings = ReferralReward::where('user_id', auth()->id())->sum('amount');

        $this->thisMonth = ReferralReward::where('user_id', auth()->id())
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->sum('amount');
        
        $rawReferrals = Referral::with(['user', 'user.stakes'])
            ->where(function ($q) use ($userId) {
                $q->where('level_1_id', $userId)
                  ->orWhere('level_2_id', $userId)
                  ->orWhere('level_3_id', $userId)
                  ->orWhere('level_4_id', $userId)
                  ->orWhere('level_5_id', $userId)
                  ->orWhere('level_6_id', $userId)
                  ->orWhere('level_7_id', $userId)
                  ->orWhere('level_8_id', $userId)
                  ->orWhere('level_9_id', $userId)
                  ->orWhere('level_10_id', $userId);
            })
            ->latest()
            ->get();

        $this->referrals = $rawReferrals->map(function ($referral) use ($userId) {
            return [
                'user' => $referral->user,
                'level' => $this->detectLevel($referral, $userId),
                'active' => $referral->user?->stakes
                    ?->where('status', 'active')
                    ->count() > 0,
            ];
        });
    }

    private function detectLevel(Referral $referral, int $userId): int {
        for ($i = 1; $i <= 10; $i++) {
            if ($referral->{'level_'.$i.'_id'} === $userId) {
                return $i;
            }
        }

        return 0;
    }

    public function render() {
        return view('livewire.dashboard.affiliate.referral-center');
    }
}
