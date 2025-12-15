<?php

namespace App\Livewire\Dashboard\Account;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Withdrawal extends Component {
    public $amount;
    public $walletId;


    protected $rules = [
        'amount' => 'required|numeric|min:10',
        'walletId' => 'required'
    ];


    public function confirm()
    {
        $this->validate();
        $this->dispatch('confirm-withdrawal');
    }


    public function withdraw()
    {
        // OTP + cooldown checks here
    }


    public function render()
    {
        return view('livewire.dashboard.account.withdrawal', [
            'wallets' => auth()->user()->wallets
        ]);
    }
}