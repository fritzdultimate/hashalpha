<?php

namespace App\Livewire;

use App\Models\Stake;
use App\Models\StakingPlan;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class PlansList extends Component {
    public string $sortDir = 'asc'; 
    public ?int $durationFilter = null;
    public int $perPage = 6;
    public bool $loading = true;
    public string $search = '';
    public string $sortBy = 'daily_roi';
    public $quickView = false;

    public function updatedSearch() {
        $this->resetPerPage();
    }

    public function updatedDurationFilter() {
        $this->resetPerPage();
    }

    public function updatedSortBy() {
        $this->resetPerPage();
    }

    public function updatedSortDir($value) {
        $this->resetPerPage();
    }

    public function resetPerPage() {
        $this->perPage = 6;
    }

    #[On('stakeCreated')]
    public function refresh() {
        $this->plans = StakingPlan::orderBy('apy_decimal', 'desc')->get();
        $this->dispatch('refreshDashboard');
    }

    public function toggleSortDir() {
        $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
    }

    public function openStakeModal($planId) {
        $this->dispatch('openStakeModal', $planId);
    }


    #[On('openStakeModel')]
    public function handleOpenStakeModal() {

    }

    public function openPlanDetails(int $planId) {
        $this->dispatch('openPlanDetails', id: $planId);
    }

    public function loadMore() {
        $this->perPage += 6;
    }

     protected function query() {
        $q = StakingPlan::query()
            ->withSum(['stakes as active_staked_amount' => function ($q) {
                $q->where('status', 'active');
            }], 'amount');

        if ($this->search) {
            $q->where(function($sub) {
                $sub->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->durationFilter) {
            $q->where('duration', $this->durationFilter);
        }

        // safe sorting
        if (in_array($this->sortBy, ['daily_roi','min_amount','duration'])) {
            $q->orderBy($this->sortBy, $this->sortDir);
        } else {
            $q->orderBy('daily_roi', 'desc');
        }

        return $q;
    }

    public function getPlansProperty(): Collection {
        $totalActive = Stake::where('status', 'active')->sum('amount');
        $plans = $this->query()->limit($this->perPage)->get();

        $plans->each(function ($plan) use ($totalActive) {
            $plan->utilization = $totalActive > 0
            ? round(($plan->active_staked_amount / $totalActive) * 100, 1)
            : 0;
        });
        
        return $plans;
    }


    public function render() {
        $totalPlans = StakingPlan::count();
        return view('livewire.plans-list', [
            'totalPlans' => $totalPlans
        ]);
    }
}
