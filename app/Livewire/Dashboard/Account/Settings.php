<?php

namespace App\Livewire\Dashboard\Account;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Settings extends Component {
    public $twoFactor;


    public function mount()
    {
        $this->twoFactor = auth()->user()->two_factor_enabled;
    }


    public function save()
    {
        auth()->user()->update(['two_factor_enabled' => $this->twoFactor]);
    }


    public function render()
    {
        return view('livewire.dashboard.account.settings');
    }
}