<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\Rank;
use App\Models\RankBonus;
use App\Models\ReferralReward;
use App\Models\Stake;
use App\Models\User;
use App\Services\RankEvaluatorService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class RankProgress extends Component
{
    public float $claimable = 0;
    public float $pending = 0;
    public Rank|null $currentRank;
    public ?Rank $nextRank = null;
    public int $progressPercent = 0;
    public $totalAvailable = 0;
    public $withdrawn = 0;

    public ?Rank $selectedRank = null;
    public bool $showRankModal = false;

    public $userVolume = 0;
    public $userActiveReferrals = 0;
    public $userEarnings = 0;

    public function mount() {
        RankEvaluatorService::evaluate(auth()->user());
        $this->loadBonuses();
        $this->loadRank();
        // $this->showRankDetails(2);
    }

    public function showRankDetails(int $rankId): void {
        $this->selectedRank = Rank::findOrFail($rankId);
        $this->showRankModal = true;
    }

    public function closeRankModal(): void {
        $this->reset(['showRankModal', 'selectedRank']);
    }

    public function loadBonuses(): void
    {
        $userId = auth()->id();

        $this->totalAvailable = RankBonus::where('user_id', $userId)
            ->get()
            ->sum(fn ($reward) => $reward->amount - ($reward->withdrawn ?? 0));

        $this->withdrawn = RankBonus::where('user_id', $userId)
            ->sum('withdrawn');

    }

    public function loadRank(): void
    {
        $user = auth()->user();
        $this->currentRank = $user?->rank?->rank;
        $level = $user?->rank?->rank?->level ?? 0;

        $this->nextRank = Rank::where('level', '>', $level)
            ->orderBy('level')
            ->first();



        if (!$this->nextRank) {
            $this->progressPercent = 100;
            return;
        }

        $downlineIds = getDownlineUserIds($user->id);

        $volume = Stake::whereIn('user_id', $downlineIds)->sum('amount');
        $this->userVolume = $volume;

        $activeReferrals = ReferralReward::where('user_id', $user->id)
            ->whereHas('fromUser', fn($q) => $q->where('is_suspended', false))
            ->distinct('from_user_id')
            ->count('from_user_id');

        $this->userActiveReferrals = $activeReferrals;

        $earnings = ReferralReward::where('user_id', $user->id)
            ->sum('amount');
        
        $this->userEarnings = $earnings;

        $refPct = min(100, intval(($activeReferrals/$this->nextRank->required_active_referrals) * 100));
        $earningsPct = min(100, intval(($earnings/$this->nextRank->required_earnings) * 100));
        $volPct = min(100, intval(($volume / $this->nextRank->required_volume) * 100));

        $actualPct = intval(($refPct + $earningsPct + $volPct)/3);

        // dd($actualPct);

        $this->progressPercent = min(
            100,
            intval($actualPct)
        );
    }


    public function render()
    {
        return view('livewire.dashboard.affiliate.rank-progress', [
            'ranks' => Rank::orderBy('level')->get(),
        ]);
    }
}
