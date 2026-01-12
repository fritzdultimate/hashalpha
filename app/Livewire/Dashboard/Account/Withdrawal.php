<?php

namespace App\Livewire\Dashboard\Account;

use App\Domain\Withdrawal\WithdrawalRules;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Withdrawal extends Component {
    public $amount;
    public $walletId;
    public $address;
    public $otp = null;
    public $showOtpForm = false;
    public $withdrawalPlaced = false;
    public \App\Models\Withdrawal $withdrawal;


    protected $rules = [
        'amount' => 'required|numeric|min:10',
        'address' => 'required',
        'walletId' => 'required'
    ];


    public function confirm() {
        $this->validate();
        $this->dispatch('confirm-withdrawal');
    }

    protected function prepareWithdrawal() {
        $user = auth()->user();
        try {
            WithdrawalRules::canCreate($user, $this->amount);
        } catch (\DomainException $e) {
            $this->addError('amount', $e->getMessage());
            return;
        }

        TwoFactorService::generateFor(Auth::user(), 'withdrawal', 4, 10);
        $this->showOtpForm = true;

    }


    public function withdraw() {
        $this->prepareWithdrawal();
    }

    public function makeAnotherWithdrawal(): void {
        $this->reset([
            'amount',
            'walletId',
            'address',
            'otp',
            'showOtpForm',
            'withdrawalPlaced',
        ]);

        $this->resetErrorBag();
    }

    public function proceedWithdrawal() {

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
                'wallet_id' => $this->walletId,
                'amount' => $this->amount,
                'address' => $this->address,
            ]);

            $this->withdrawalPlaced = true;
        });
        

    }

    public function cancelProcess() {
        $this->showOtpForm = false;
    }


    public function render()
    {
        return view('livewire.dashboard.account.withdrawal', [
            'wallets' => auth()->user()->wallets
        ]);
    }
}