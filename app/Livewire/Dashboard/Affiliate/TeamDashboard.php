<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\Referral;
use App\Models\ReferralReward;
use App\Models\Stake;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TeamDashboard extends Component
{
    public int $activeLevel = 1;

    public $team = [];

    public int $members = 0;
    public int $activeMembers = 0;
    public float $volume = 0;
    public float $earnings = 0;

    public function mount()
    {
        $this->loadLevel(1);
    }

    public function loadLevel(int $level): void {
        $this->activeLevel = $level;

        // Get referrals on this level
        $referrals = Referral::with('user')
            ->where('referrer_id', auth()->id())
            ->where('level', $level)
            ->get();

        $this->team = $referrals
            ->pluck('user')
            ->filter()
            ->values();

        // Stats
        $this->members = $this->team->count();

        $this->activeMembers = $this->team
            ->where('is_suspended', false)
            ->count();

        $this->volume = Stake::whereIn(
            'user_id',
            $this->team->pluck('id')
        )->sum('amount');

        $this->earnings = ReferralReward::where('user_id', auth()->id())->sum('amount');
    }

    public function render()
    {
        return view('livewire.dashboard.affiliate.team-dashboard');
    }
}
