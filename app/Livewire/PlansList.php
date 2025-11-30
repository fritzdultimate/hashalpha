<?php

namespace App\Livewire;

use App\Models\StakingPlan;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class PlansList extends Component {
    public string $sortDir = 'desc'; 
    public ?int $durationFilter = null;
    public int $perPage = 6;
    public bool $loading = true;
    public string $search = '';
    public string $sortBy = 'apy_decimal';

    public function updatedSearch() {
        $this->resetPerPage();
    }

    public function updatedDurationFilter() {
        $this->resetPerPage();
    }

    public function updatedSortBy() {
        $this->resetPerPage();
    }

    public function updatedSortDir() {
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
        $q = StakingPlan::query();

        if ($this->search) {
            $q->where(function($sub) {
                $sub->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->durationFilter) {
            $q->where('duration_days', $this->durationFilter);
        }

        // safe sorting
        if (in_array($this->sortBy, ['apy_decimal','min_amount_decimal','duration_days'])) {
            $q->orderBy($this->sortBy, $this->sortDir);
        } else {
            $q->orderBy('apy_decimal', 'desc');
        }

        return $q;
    }

    public function getPlansProperty(): Collection {
        return $this->query()->limit($this->perPage)->get();
    }


    public function render() {
        $totalPlans = StakingPlan::count();
        return view('livewire.plans-list', [
            'totalPlans' => $totalPlans
        ]);
    }
}
