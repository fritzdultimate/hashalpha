<?php

namespace App\Livewire;

use App\Models\StakingPlan;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Plan;

class PlanDetails extends Component
{
    public bool $show = false;
    public ?StakingPlan $plan = null;

    #[On('openPlanDetails')]
    public function open(int $planId): void
    {
        $this->plan = StakingPlan::findOrFail($planId);
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.plan-details');
    }
}
