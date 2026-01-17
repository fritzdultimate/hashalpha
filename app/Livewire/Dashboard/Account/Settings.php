<?php

namespace App\Livewire\Dashboard\Account;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Settings extends Component {
    public $twoFactor;
    public $loginAlerts;
    public $withdrawalConfirmation;


    public function mount() {
        $user = auth()->user();

        $this->twoFactor = $user->two_factor_enabled;
        $this->loginAlerts = $user->login_alerts;
        $this->withdrawalConfirmation = $user->withdrawal_confirmation;
    }

    public function logoutAll() {
        dd('logout');
    }


    public function save() {
        auth()->user()->update([
            'two_factor_enabled' => $this->twoFactor,
            'login_alerts' => $this->loginAlerts,
            'withdrawal_confirmation' => $this->withdrawalConfirmation,
        ]);

        $this->dispatch('toast', payload: ['type' => 'success', 'message' => 'Security settings updated']);
    }


    public function render()
    {
        return view('livewire.dashboard.account.settings');
    }
}