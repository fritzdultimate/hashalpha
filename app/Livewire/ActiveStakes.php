<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Stake;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Services\RewardCalculator;

#[Layout('layouts.app')]
class ActiveStakes extends Component {
    public $stakes;

    protected $listeners = ['stakeCreated' => 'loadStakes', 'refreshDashboard' => 'loadStakes'];

    public function mount()
    {
        $this->loadStakes();
    }

    public function loadStakes()
    {
        $this->stakes = auth()->user()->stakes()->where('status','active')->orderBy('start_at','desc')->get();
    }

    /**
     * Claim withdrawable rewards into user's wallet balance
     */
    public function claim($stakeId)
    {
        $stake = Stake::where('id', $stakeId)->where('user_id', auth()->id())->firstOrFail();
        $amount = (string) $stake->withdrawable_decimal;

        if (bccomp($amount, '0', 8) <= 0) {
            $this->dispatchBrowserEvent('toast', ['message' => 'No withdrawable rewards']);
            return;
        }

        DB::transaction(function () use ($stake, $amount) {
            $user = $stake->user()->lockForUpdate()->first();
            $before = $user->balance_decimal;
            $after = bcadd($before, $amount, 8);

            // update user balance
            $user->balance_decimal = $after;
            $user->save();

            // zero withdrawable rewards on stake; keep accrued_rewards for record
            $stake->withdrawable_decimal = bcsub($stake->withdrawable_decimal, $amount, 8);
            $stake->save();

            // ledger
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'stake_reward_claim',
                'txable_id' => $stake->id,
                'txable_type' => get_class($stake),
                'amount_decimal' => $amount,
                'balance_before_decimal' => $before,
                'balance_after_decimal' => $after,
                'meta' => ['stake_id' => $stake->id]
            ]);
        });

        $this->loadStakes();
        $this->dispatchBrowserEvent('toast', ['message' => 'Rewards claimed']);
        $this->emit('refreshDashboard');
    }

    /**
     * Compound: move withdrawable rewards into stake principal (if allowed)
     */
    public function compound($stakeId)
    {
        $stake = Stake::where('id', $stakeId)->where('user_id', auth()->id())->firstOrFail();
        if (!$stake->plan->compound_allowed) {
            $this->dispatchBrowserEvent('toast', ['message' => 'Compound not allowed for this plan']);
            return;
        }
        $amt = (string) $stake->withdrawable_decimal;
        if (bccomp($amt,'0',8) <= 0) {
            $this->dispatchBrowserEvent('toast', ['message' => 'No rewards to compound']);
            return;
        }

        DB::transaction(function() use ($stake, $amt) {
            // increase principal_decimal
            $stake = $stake->lockForUpdate();
            $beforePrincipal = $stake->principal_decimal;
            $stake->principal_decimal = bcadd($stake->principal_decimal, $amt, 8);
            // reduce withdrawable
            $stake->withdrawable_decimal = bcsub($stake->withdrawable_decimal, $amt, 8);
            $stake->save();

            // ledger entry to show compounding inside stake (user balance not touched)
            Transaction::create([
                'user_id' => $stake->user_id,
                'type' => 'stake_compound',
                'txable_id' => $stake->id,
                'txable_type' => get_class($stake),
                'amount_decimal' => $amt,
                'balance_before_decimal' => null,
                'balance_after_decimal' => null,
                'meta' => ['from' => 'withdrawable', 'to' => 'principal']
            ]);
        });

        $this->loadStakes();
        $this->dispatchBrowserEvent('toast', ['message' => 'Rewards compounded']);
        $this->emit('refreshDashboard');
    }

    public function render()
    {
        return view('livewire.active-stakes');
    }
}
