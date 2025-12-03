<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Stake;

class StakesList extends Component {
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $perPage = 12;

    protected $paginationTheme = 'tailwind';
    public $fixedPage = false;
    public $quickView = false;

    protected $listeners = [
        'refreshStakes' => '$refresh'
    ];

    // reset page when search/filter changes
    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public function viewStake($id) {
        $this->dispatch('openStakeDetails', $id);
    }

    public function loadMore() {
        $this->perPage = $this->perPage + 10;
    }

    public function render() {
        $userId = Auth::id();
        $query = Stake::with('plan')->where('user_id', $userId);
        if ($this->filterStatus) $query->where('status', $this->filterStatus);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id', 'like', "%{$this->search}%")
                  ->orWhere('meta->note', 'like', "%{$this->search}%")
                  ->orWhereHas('plan', fn($p)=> $p->where('name','like',"%{$this->search}%"));
            });
        }

        $stakes = $query->latest()->paginate($this->perPage);

        return view('livewire.dashboard.stakes-list', compact('stakes'));
    }
}
