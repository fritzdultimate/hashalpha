<?php

namespace App\Livewire;

use App\Domain\Staking\StakeRules;
use App\Mail\StakeCreatedMail;
use App\Models\CustomSetting;
use App\Models\Deposit;
use App\Models\StakingPlan;
use App\Services\ReferralBonusService;
use Illuminate\Support\Facades\Mail;
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

    public function getPoolFeePercentProperty() {
        return max(0, (float) CustomSetting::get('pool_fee_percent', 0));
    }

    public function getPoolFeeProperty() {
        if (!$this->amount || $this->amount <= 0) {
            return 0;
        }

        return ($this->amount * $this->poolFeePercent) / 100;
    }

    public function getTotalDebitProperty() {
        return $this->amount + $this->poolFee;
    }


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
        $amt = (string) number_format((float)$this->totalDebit, 8, '.', '');

        try {
            StakeRules::canCreate($user, $amt, $this->totalDebit);
        } catch (\DomainException $e) {
            $this->addError('amount', $e->getMessage());
            return;
        }

        

        DB::beginTransaction();
        try {

            $remaining = (float) $amt;
            $deposits = Deposit::where('user_id', $user->id)
                ->where('bonus', '>', 0)
                ->where('status', 'finished')
                ->orderBy('created_at')
                ->lockForUpdate()
                ->get();

            foreach ($deposits as $deposit) {
                if ($remaining <= 0) {
                    break;
                }

                if ($deposit->bonus >= $remaining) {
                    $deposit->bonus -= $remaining;
                    $deposit->save();
                    $remaining = 0;
                    break;
                }

                $remaining -= $deposit->bonus;
                $deposit->bonus = 0;
                $deposit->save();
            }

            if ($remaining > 0) {
                if (bccomp($user->balance, (string)$remaining, 8) < 0) {
                    throw new \Exception('Insufficient balance after bonus deduction.');
                }

                $user->balance = bcsub($user->balance, (string)$remaining, 8);
                $user->save();
            }

            
            $stake = Stake::create([
                'user_id' => $user->id,
                'plan_id' => $this->plan->id,
                'amount' => $this->amount,
                'capital' => $this->amount,
                'status' => 'active',
                'started_at' => now(),
                'wallet_id' => '1',
                'expected_end_date' => now()->addDays($this->plan->duration),
                'meta' => [
                    'auto_compound' => (bool) $this->autoCompound,
                    'fee' => $this->poolFee,
                    'fee_percent' => $this->poolFeePercent,
                    'total_debited' => $this->totalDebit,
                ]
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'hold',
                'amount' => $this->amount,
                'balance_after' => $user->balance,
                'related_type' => 'App\Models\Stake',
                'related_id' => $stake->id,
                'meta' => [
                    'note' => 'Staked',
                    'used_bonus' => (float) $this->amount - $remaining,
                    'used_balance' => $remaining,
                ],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            ReferralBonusService::distribute($user, $stake);

            Mail::to($stake->user->email)
            ->send(new StakeCreatedMail($stake));



            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->addError(
            'amount',
            'Unable to complete stake at the moment. Please try again.'
            );
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

    public function getAvailableBonusProperty(): float {
        return (float) Deposit::where('user_id', auth()->id())
            ->where('bonus', '>', 0)
            ->where('status', 'finished')
            ->sum('bonus');
    }

    public function render() {
        return view('livewire.stake-modal');
    }
}
