<?php

namespace App\Livewire\Dashboard\Account;

use App\Domain\Withdrawal\WithdrawalRules;
use App\Models\ReferralReward;
use App\Models\WithdrawalCurrency;
use App\Models\WithdrawalNetwork;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Withdrawal extends Component {
    public $amount;
    public $asset;
    public $address;
    public $otp = null;
    public $showOtpForm = false;
    public $withdrawalPlaced = false;
    public \App\Models\Withdrawal $withdrawal;
    public $totalAvailable = 0;

    public $currencyId;
    public $networkId;
    public $networks = [];
    public $loading = false;


    protected $rules = [
        'amount' => 'required|numeric',
        'address' => 'required',
        'currencyId' => 'required|exists:withdrawal_currencies,id',
        'networkId' => 'required|exists:withdrawal_networks,id',
        'asset' => 'required|in:balance,referral_rewards',
    ];


    public function confirm() {
        $this->loading = true;
        $this->validate();
        $this->dispatch('confirm-withdrawal');
    }

    protected function prepareWithdrawal() {
        $user = auth()->user();
        try {
            WithdrawalRules::canCreate($user, $this->amount, $this->asset);
        } catch (\DomainException $e) {
            $this->addError('amount', $e->getMessage());
            return;
        }

        TwoFactorService::generateFor(Auth::user(), 'withdrawal', 4, 10);
        $this->showOtpForm = true;

    }

    public function updatedCurrencyId($value) {
        $this->networkId = null;

        $this->networks = WithdrawalNetwork::where('withdrawal_currency_id', $value)
            ->where('is_enabled', true)
            ->get();
    }


    public function withdraw() {
        $this->prepareWithdrawal();
        $this->loading = false;
    }

    public function makeAnotherWithdrawal(): void {
        $this->reset([
            'amount',
            'asset',
            'address',
            'otp',
            'showOtpForm',
            'withdrawalPlaced',
        ]);

        $this->resetErrorBag();
    }

    public function proceedWithdrawal() {
        $this->loading = true;
        if($this->otp === null) {
            $this->addError('otp', 'Your OTP is required.');
            return;
        }
        $ok = TwoFactorService::validate(Auth::user(), $this->otp, 'withdrawal');
        if(!$ok) {
            $this->addError('otp', 'Invalid or expired otp.');
            return;
        }

        DB::transaction(function () {
            $this->withdrawal = \App\Models\Withdrawal::create([
                'user_id' => auth()->id(),
                'amount' => $this->amount,
                'address' => $this->address,
                'asset' => $this->asset,
                'withdrawal_currency_id' => $this->currencyId,
                'withdrawal_network_id' => $this->networkId,
            ]);

            logWithdrawalTransaction($this->withdrawal, 'debit', $this->amount);

            $this->withdrawalPlaced = true;
        });

        $this->loading = false;
        

    }

    public function cancelProcess() {
        $this->showOtpForm = false;
    }

    public function mount() {
        $this->totalAvailable = ReferralReward::where('user_id', auth()->id())
            ->get()
            ->sum(fn ($reward) => $reward->amount - ($reward->withdrawn ?? 0));
    }


    public function render()
    {
        return view('livewire.dashboard.account.withdrawal', [
            'currencies' => WithdrawalCurrency::where('is_enabled', true)->get(),
        ]);
    }
}