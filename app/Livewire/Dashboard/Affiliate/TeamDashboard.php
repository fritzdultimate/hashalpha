<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\Referral;
use App\Models\ReferralReward;
use App\Models\Stake;
use App\Models\UnilevelPercentage;
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
        $user = auth()->user();
        $levelColumn = "level_{$level}_id";
        
        $ids = getDownlineUsersByLevel($user->id, $level);
        $percentages = UnilevelPercentage::pluck('percentage', 'level');
        $percentage = $percentages[$level] ?? 0;

        $volume = Stake::whereIn('user_id', $ids)->sum('amount');

        $weighted = ($volume * $percentage) / 100;

        $this->volume = $weighted;

        $this->team = Referral::where($levelColumn, $user->id)
            ->with('user')
            ->get()
            ->pluck('user')
            ->filter()
            ->values();

        // Stats
        $this->members = $this->team->count();

        $this->activeMembers = $this->team
            ->where('is_suspended', false)
            ->count();

        $this->earnings = ReferralReward::where('user_id', auth()->id())->where('level', $level)->sum('amount');
    }

    public function render()
    {
        return view('livewire.dashboard.affiliate.team-dashboard');
    }
}
