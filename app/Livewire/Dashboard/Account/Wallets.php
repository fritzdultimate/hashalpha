<?php

namespace App\Livewire\Dashboard\Account;


use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Wallets extends Component {
    public $total_confirmed;
    public $total_pending;

    public function mount() {
        $wallets = auth()->user()->wallets()->withSum([
            'deposits as total_confirmed' => function($q) {
                $q->where('status', 'finished');
            },
            'deposits as total_pending' => function($q) {
                $q->where('status', 'pending');
            }
        ], 'amount')->get();

        $this->total_confirmed = $wallets->sum('total_confirmed');
        $this->total_pending   = $wallets->sum('total_pending');

        
    }
    public function render()
    {
        return view('livewire.dashboard.account.wallets', [
            'wallets' => auth()->user()->wallets()->withSum([
                'deposits as finished_deposits_sum' => function ($q) {
                    $q->where('status', 'finished');
                }
            ], 'amount')->get()
        ]);
    }
}