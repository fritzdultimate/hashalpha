<?php

namespace App\Livewire\Dashboard\Account;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Details extends Component {
    public $name;
    public $email;
    public $phone;
    public $country;
    public $timezone;

    public function mount() {
        $user = auth()->user();

        $this->name     = $user->name;
        $this->email    = $user->email;
        $this->phone    = $user->phone;
        $this->country  = $user->country;
        $this->timezone = $user->timezone;
    }

    protected function rules() {
        return [
            'name'     => 'required|string|min:3',
            'email'    => 'required|email',
            'phone'    => 'nullable|string|min:7',
            'country'  => 'nullable|string|max:2',
            'timezone' => 'nullable|string',
        ];
    }

    public function save() {
        $this->validate();

        auth()->user()->update([
            'name'     => $this->name,
            'email'    => $this->email,
            'phone'    => $this->phone,
            'country'  => $this->country,
            'timezone' => $this->timezone,
        ]);

        $this->dispatch('toast', payload: [
            'message' => 'Account details updated successfully',
            'timeout' => 5000,
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.account.details');
    }
}
