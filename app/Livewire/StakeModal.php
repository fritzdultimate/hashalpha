<?php

namespace App\Livewire;

use App\Models\StakingPlan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Stake;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Services\RewardCalculator;

#[Layout('layouts.app')]
class StakeModal extends Component
{
    public $show = false;
    public ?StakingPlan $plan = null;
    public $amount;
    public $autoCompound = false; // user chooses if plan allows
    public $termDays = null; // optional override for duration
    public $user; // current user instance

    protected $listeners = [
        'openStakeModal' => 'open'
    ];

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function open($planId)
    {
        $this->plan = StakingPlan::findOrFail($planId);
        $this->amount = null;
        $this->autoCompound = $this->plan->compound_allowed ? false : false;
        $this->termDays = $this->plan->duration_days ?: null;
        $this->show = true;
        $this->resetValidation();
    }

    protected function rules()
    {
        $min = (string)($this->plan->min_amount_decimal ?? 0);
        return [
            'amount' => ['required','numeric','min:'.$min],
            'autoCompound' => ['boolean']
        ];
    }

    public function updated($prop)
    {
        $this->resetValidation($prop);
    }

    public function stake()
    {
        if (!$this->plan) {
            $this->addError('plan', 'Invalid plan selected.');
            return;
        }

        $this->validate();

        $user = auth()->user();
        $amt = (string) number_format((float)$this->amount, 8, '.', '');

        // quick guard
        if (bccomp($user->balance_decimal, $amt, 8) === -1) {
            $this->addError('amount', 'Insufficient account balance to stake this amount.');
            return;
        }

        DB::beginTransaction();
        try {
            // Subtract from user wallet balance
            $before = $user->balance_decimal;
            $newBalance = bcsub($before, $amt, 8);
            $user->balance_decimal = $newBalance;
            $user->save();

            // Create stake
            $stake = Stake::create([
                'user_id' => $user->id,
                'plan_id' => $this->plan->id,
                'principal_decimal' => $amt,
                'status' => 'active',
                'start_at' => now(),
                'last_accrued_at' => now(),
                'accrued_rewards_decimal' => '0',
                'withdrawable_decimal' => '0',
                'meta' => [
                    'auto_compound' => (bool) $this->autoCompound
                ]
            ]);

            // Ledger entry
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'stake_create',
                'txable_id' => $stake->id,
                'txable_type' => get_class($stake),
                'amount_decimal' => bcmul('-1', $amt, 8),
                'balance_before_decimal' => $before,
                'balance_after_decimal' => $newBalance,
                'meta' => ['plan_id' => $this->plan->id]
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        // notify components and close
        $this->emit('stakeCreated', $stake->id);
        $this->show = false;
        $this->dispatchBrowserEvent('toast', ['message' => 'Stake created successfully']);
    }

    public function render()
    {
        return view('livewire.stake-modal');
    }
}
