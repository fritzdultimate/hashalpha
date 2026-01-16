<?php

namespace App\Livewire;

use App\Models\ReferralReward;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ReferralRewards extends Component {
    public $search = '';
    public $filter = '';
    public $loading = false;
    public $confirmingClaimAll = false;
    public $confirmingRewardId = null;
    public $totalClaimed = 0;
    public $totalEarned = 0;
    public $claimable = 0;

    public function mount() {
        $rewards = ReferralReward::where('user_id', auth()->id());

        $this->claimable = $rewards->where('status', 'pending')
            ->sum('amount');

        $this->totalEarned = $rewards->where('status', '!=', 'failed')
            ->sum('amount');
    }

    public function getRewardsProperty() {
        return ReferralReward::where('user_id', auth()->id())
            ->when($this->filter === 'claimable', fn ($q) =>
                $q->where('status', 'pending')->where(fn($q) =>
                    $q->whereNull('claimable_at')->orWhere('claimable_at', '<=', now())
                )
            )
            ->when($this->filter === 'claimed', fn ($q) =>
                $q->where('status', 'paid')
            )
            ->latest()
            ->paginate(10);
    }

    public function claim($id) {
        $reward = ReferralReward::where('user_id', auth()->id())->findOrFail($id);

        if (! $reward->isClaimable()) {
            $this->dispatch('toast', type: 'error', message: 'Reward not claimable yet');
            return;
        }

        DB::transaction(function () use ($reward) {
            auth()->user()->increment('balance', $reward->amount);

            $reward->update([
                'status' => 'paid',
                'claimed_at' => now(),
            ]);
        });

        $this->dispatch('toast', payload: [
            'message' => 'Reward claimed',
            'timeout' => 5000,
            'type' => 'success'
        ]);
    }

    public function claimAll() {
        $rewards = ReferralReward::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->where(fn($q) =>
                $q->whereNull('claimable_at')->orWhere('claimable_at', '<=', now())
            )
            ->lockForUpdate()
            ->get();

        if ($rewards->isEmpty()) {
            $this->dispatch('toast', payload: [
                'message' => 'No claimable rewards',
                'timeout' => 5000,
                'type' => 'info'
            ]);
            return;
        }

        DB::transaction(function () use ($rewards) {
            $total = $rewards->sum('amount');

            auth()->user()->increment('balance', $total);

            ReferralReward::whereIn('id', $rewards->pluck('id'))
                ->update([
                    'status' => 'paid',
                    'claimed_at' => now(),
                ]);
        });

        $this->dispatch('toast', payload: [
            'message' => 'All rewards claimed',
            'timeout' => 5000,
        ]);
    }

    public function render() {
        return view('livewire.referral-rewards', [
            'rewards' => $this->rewards,
        ]);
    }
}
