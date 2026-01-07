<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\Stake;
use App\Models\StakingPlan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class ReferralCenter extends Component {

    public $referralLink;

    public function mount() {
        $user = Auth::user();
        $this->referralLink = Cache::remember("user{$user->id}:affiliate_link", 6000, function() use($user)  {
            $code = $user->affiliate_code ?? generateReferralCode($user->email);
            return route('register', ['ref' => $code]); 
        });
    }

    public function render() {
        return view('livewire.dashboard.affiliate.referral-center');
    }
}
