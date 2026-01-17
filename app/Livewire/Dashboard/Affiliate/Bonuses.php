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

    public float $totalAvailable = 0;
    public float $withdrawan = 0;

    public function mount() {
        $this->loadBonuses();
    }

    public function loadBonuses(): void {
        $userId = auth()->id();

        $this->totalAvailable = ReferralReward::where('user_id', $userId)
            ->selectRaw('SUM(amount - withdrawn) as total')
            ->value('total');

        $this->withdrawn = ReferralReward::where('user_id', $userId)
            ->sum('withdrawn');
    }

    public function claim(): void {
        return;
        if ($this->claimable <= 0) return;

        DB::transaction(function () {

            ReferralReward::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->where(function ($q) {
                    $q->whereNull('claimable_at')
                    ->orWhere('claimable_at', '<=', now());
                })
                ->update([
                    'status' => 'paid',
                    'claimed_at' => now(),
                ]);

            auth()->user()->increment('balance', $this->claimable);
        });

        $this->dispatch('toast', payload: [
            'type' => 'success',
            'message' => '$' . number_format($this->claimable, 2) . ' Referral bonus claimed successfully',
            'timeout' => 10000,
        ]);
        $this->loadBonuses();

    }

    public function render() {
        return view('livewire.dashboard.affiliate.bonuses', [
            'bonuses' => ReferralReward::with('fromUser')
                ->where('user_id', auth()->id())
                ->latest()
                ->limit(20)
                ->get(),
        ]);
    }
}
