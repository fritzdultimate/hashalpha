<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\Deposit;
use App\Models\PerformancePercentage;
use App\Models\Rank;
use App\Models\Referral;
use App\Models\ReferralReward;
use App\Models\Stake;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PerformanceBonus;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class PerformanceBonusDashboard extends Component {
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public $rank;
    public $nextRank;

    public float $totalBonus = 0;
    public float $todayBonus = 0;

    public array $levels = [];

    public int $progress = 0;
    public float $missedTotal = 0;
    public array $missedBreakdown = [];

    public $allRanks;

    public $currentPersonalVolume;
    public $userDirects;

    public function mount() {
        $user = auth()->user();

        $this->currentPersonalVolume = $user->deposits()->sum('amount_paid');

        $this->userDirects = Referral::where('level_1_id', $user->id)->count();

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

        

        $this->missedBreakdown = PerformanceBonus::where('user_id', auth()->id())
            ->whereIn('type', ['missed', 'missed_rank'])
            ->get()->toArray();

        $this->missedTotal = collect($this->missedBreakdown)->sum('amount');

        $this->loadRankProgress($user);

        $this->allRanks = Rank::orderBy('level')->get();
        
    }

    public function loadRankProgress(User $user) {
        $downlineIds = getDownlineUserIds($user->id);
        $activeReferrals = ReferralReward::where('user_id', $user->id)
            ->whereHas('fromUser', fn($q) => $q->where('is_suspended', false))
            ->distinct('from_user_id')
            ->count('from_user_id');
        $volume = Stake::whereIn('user_id', $downlineIds)->sum('amount');
        $earnings = ReferralReward::where('user_id', $user->id)
            ->sum('amount');

        $level = $user?->rank?->rank?->level ?? 0;

        $this->nextRank = Rank::where('level', '>', $level)
            ->orderBy('level')
            ->first();

        if($level > 0 && !$this->nextRank) {
            $this->progress = 100;
        } else {
            $refPct = min(100, intval(($activeReferrals/$this->nextRank->required_active_referrals) * 100));
            $earningsPct = min(100, intval(($earnings/$this->nextRank->required_earnings) * 100));
            $volPct = min(100, intval(($volume / $this->nextRank->required_volume) * 100));

            $actualPct = intval(($refPct + $earningsPct + $volPct)/3);

            $this->progress = min(
                100,
                intval($actualPct)
            );
        }
    }

    public function render() {
        return view('livewire.dashboard.affiliate.performance-bonus-dashboard', [
            'bonuses' => PerformanceBonus::with('sourceUser')
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10),
        ]);
    }
}