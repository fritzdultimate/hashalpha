<?php

namespace App\Livewire;

use App\Domain\Staking\StakeRules;
use App\Models\StakingPlan;
use App\Services\ReferralBonusService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
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
    public $autoCompound = false;
    public $termDays = null;
    public $user;


    public function mount() {
        $this->user = auth()->user();
    }

    #[On('openStakeModal')]
    public function open($planId) {
        $this->plan = StakingPlan::findOrFail($planId);
        $this->amount = null;
        $this->autoCompound = $this->plan->compound_allowed ? false : false;
        $this->termDays = $this->plan->duration_days ?: null;
        $this->show = true;
        $this->resetValidation();
    }

    protected function rules() {
        $min = (string)($this->plan->min_amount ?? 0);
        $max = (string)($this->plan->max_amount ?? 0);
        return [
            'amount' => ['required','numeric','min:'.$min, 'max:'.$max],
            'autoCompound' => ['boolean']
        ];
    }

    protected function messages() {
        $min = (string)($this->plan->min_amount ?? 0);
        $max = (string)($this->plan->max_amount ?? 0);
        return [
            'amount.min' => "Minimum amount for this plan is $$min",
            'amount.max' => "Maximum amount for this plan is $$max",
        ];
    }

    public function updated($prop)
    {
        $this->resetValidation($prop);
    }

    public function stake() {
        $this->resetErrorBag();
        if (!$this->plan) {
            $this->addError('amount', 'Invalid plan selected.');
            return;
        }

        $this->validate();

        $user = auth()->user();
        $amt = (string) number_format((float)$this->amount, 8, '.', '');

        try {
            StakeRules::canCreate($user, $amt);
        } catch (\DomainException $e) {
            $this->addError('amount', $e->getMessage());
            return;
        }

        DB::beginTransaction();
        try {
            // Subtract from user wallet balance
            $before = $user->balance;
            $newBalance = bcsub($before, $amt, 8);
            $user->balance = $newBalance;
            $user->save();

            
            $stake = Stake::create([
                'user_id' => $user->id,
                'plan_id' => $this->plan->id,
                'amount' => $amt,
                'capital' => $amt,
                'status' => 'active',
                'started_at' => now(),
                'wallet_id' => '1',
                'meta' => [
                    'auto_compound' => (bool) $this->autoCompound
                ]
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'hold',
                'amount' => $amt,
                'balance_after' => $user->balance,
                'related_type' => 'App\Models\Stake',
                'related_id' => $stake->id,
                'meta' => [
                    'note' => 'Staked'
                ],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            ReferralBonusService::distribute($user, $stake);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        // notify components and close
        // $this->emit('stakeCreated', $stake->id);
        $this->show = false;
        $this->dispatch('toast', payload: [
            'message' => 'Stake created successfully.',
            'timeout' => 5000,
            'stake_id' => $stake->id
        ]);
    }

    public function render() {
        return view('livewire.stake-modal');
    }
}
