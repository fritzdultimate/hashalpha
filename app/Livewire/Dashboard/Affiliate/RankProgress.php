<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\Rank;
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
    public Rank $currentRank;
    public ?Rank $nextRank = null;
    public int $progressPercent = 0;

    public function mount()
    {
        RankEvaluatorService::evaluate(auth()->user());
        $this->loadBonuses();
        $this->loadRank();
    }

    public function loadBonuses(): void
    {
        $userId = auth()->id();

        $this->claimable = ReferralReward::where('user_id', $userId)
            ->where('status', 'claimable')
            ->sum('amount');

        $this->pending = ReferralReward::where('user_id', $userId)
            ->where('status', 'pending')
            ->sum('amount');
    }

    public function loadRank(): void
    {
        $user = auth()->user();
        $this->currentRank = $user->rank->rank ?? Rank::first();

        $this->nextRank = Rank::where('level', '>', $this->currentRank->level)
            ->orderBy('level')
            ->first();

        if (!$this->nextRank) {
            $this->progressPercent = 100;
            return;
        }

        $downlineIds = $this->getDownlineUserIds($user->id);

        $volume = Stake::whereIn('user_id', $downlineIds)->sum('amount');

        $this->progressPercent = min(
            100,
            intval(($volume / $this->nextRank->required_volume) * 100)
        );
    }

    private function getDownlineUserIds(int $userId, int $maxDepth = 10): array
    {
        $currentLevel = [$userId];
        $all = [];

        for ($i = 0; $i < $maxDepth; $i++) {
            $currentLevel = User::whereIn('referrer_id', $currentLevel)
                ->pluck('id')
                ->toArray();

            if (empty($currentLevel))
                break;

            $all = array_merge($all, $currentLevel);
        }

        return $all;
    }


    public function render()
    {
        return view('livewire.dashboard.affiliate.rank-progress', [
            'ranks' => Rank::orderBy('level')->get(),
        ]);
    }
}
