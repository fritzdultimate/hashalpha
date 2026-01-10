<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\Referral;
use App\Models\ReferralBonus;
use App\Models\ReferralReward;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Bonuses extends Component {
    public float $claimable = 0;
    public float $pending = 0;

    public function mount() {
        $this->loadBonuses();
    }

    public function loadBonuses(): void {
        $userId = auth()->id();

        $this->claimable = ReferralReward::where('user_id', $userId)
            ->where('status', 'claimable')
            ->sum('amount');

        $this->pending = ReferralReward::where('user_id', $userId)
            ->where('status', 'pending')
            ->sum('amount');
    }

    public function claim(): void {
        if ($this->claimable <= 0) return;

        DB::transaction(function () {
            ReferralReward::where('user_id', auth()->id())
                ->where('status', 'claimable')
                ->update([
                    'status' => 'claimed',
                    'claimed_at' => now(),
                ]);

            auth()->user()->increment('balance', $this->claimable);
        });

        $this->loadBonuses();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Referral bonus claimed successfully',
        ]);
    }

    public function render() {
        return view('livewire.dashboard.affiliate.bonuses', [
            'bonuses' => ReferralReward::with('referralUser')
                ->where('user_id', auth()->id())
                ->latest()
                ->limit(20)
                ->get(),
        ]);
    }
}
