<?php


namespace App\Livewire\Dashboard;


use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.app')]
class Overview extends Component
{
    public $totalDeposited = 0;
    public $totalEarnings = 0;
    public $activeStakes = 0;


    public function mount()
    {
        $user = Auth::user();
        $this->totalDeposited = (float) ($user->deposits()->sum('amount') ?? 0);
        $this->totalEarnings = (float) ($user->transactions()->where('type', 'credit')->sum('amount') ?? 0);
        $this->activeStakes = (int) ($user->stakes()->count() ?? 0);
    }


    public function render()
    {
        return view('livewire.dashboard.overview');
    }
}