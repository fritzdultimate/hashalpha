<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Overview extends Component {
    public $totalDeposited;
    public $totalEarnings;
    public $activeStakes;

    public function mount() {
        $user = Auth::user();
        $this->totalDeposited = 100;//$user->deposits()->sum('amount');
        $this->activeStakes = 500; //$user->stakes()->count();
        $this->totalEarnings = 405; //$user->transactions()->where('type', 'credit')->sum('amount');
    }
    public function render() {
        return view('livewire.dashboard.overview');
    }
}
