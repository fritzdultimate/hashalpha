<?php

namespace App\Livewire;

use App\Models\StakingPlan;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PlansList extends Component {
    public $plans;

    protected $listeners = ['stakeCreated' => 'refresh'];

    public function mount() {
        $this->plans = StakingPlan::where('active', true)->orderBy('apy_decimal', 'desc')->get();
    }

    public function refresh() {
        $this->plans = StakingPlan::where('active', true)->orderBy('apy_decimal', 'desc')->get();
        $this->emit('refreshDashboard'); // let others update
    }

    public function openStakeModal($planId)
    {
        $this->emit('openStakeModal', $planId);
    }

    public function render()
    {
        return view('livewire.plans-list');
    }
}
