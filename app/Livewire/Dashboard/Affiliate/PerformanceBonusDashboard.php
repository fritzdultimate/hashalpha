<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\PerformancePercentage;
use App\Models\Referral;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PerformanceBonus;

#[Layout('layouts.app')]
class PerformanceBonusDashboard extends Component
{
    public $rank;
    public $nextRank;

    public float $totalBonus = 0;
    public float $todayBonus = 0;

    public array $levels = [];
    public $bonuses = [];

    public int $progress = 0;
    public float $missedTotal = 0;
    public array $missedBreakdown = [];

    public function mount() {
        $user = auth()->user();

        // Current rank
        $this->rank = $user->currentRank?->rank;

        // Total bonus
        $this->totalBonus = PerformanceBonus::where([
            'user_id' => $user->id,
            'type' => 'roi'
        ])->sum('amount');

        // Today bonus
        $this->todayBonus = PerformanceBonus::where([
            'user_id' => $user->id,
            'type' => 'roi'
        ])
            ->whereDate('created_at', now())
            ->sum('amount');


        $percentages = PerformancePercentage::pluck('percentage', 'level');
        $levelEarnings = PerformanceBonus::where('user_id', $user->id)
            ->where('type', 'roi')
            ->selectRaw('level, SUM(amount) as total')
            ->groupBy('level')
            ->pluck('total', 'level');
        // Level breakdown
        $this->levels = collect(range(1, 10))->map(function ($level) use ($levelEarnings, $percentages) {


            return [
                'level' => $level,
                'percent' => $percentages[$level] ?? 0,
                'amount' => $levelEarnings[$level] ?? 0
            ];
        })->toArray();

        // Activity feed
        $this->bonuses = PerformanceBonus::with('sourceUser')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(20)
            ->get();

        
        $this->progress = min(100, round((98 / 1000) * 100));

        $this->missedBreakdown = PerformanceBonus::where('user_id', auth()->id())
            ->where('type', 'missed')
            ->get()->toArray();

        $this->missedTotal = collect($this->missedBreakdown)->sum('amount');
    }

    public function render() {
        return view('livewire.dashboard.affiliate.performance-bonus-dashboard');
    }
}