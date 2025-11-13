<?php

namespace App\Livewire\Dashboard;


use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class LatestTransactionsTable extends Component
{

    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';


    protected $listeners = [
        'table-search' => 'setSearch',
        'table-perpage' => 'setPerPage'
    ];


    public function setSearch($value) {
        $this->resetPage();
        $this->search = $value;
    }


    public function setPerPage($value) {
        $this->perPage = (int) $value;
        $this->resetPage();
    }


    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }


        $this->resetPage();
    }


    public function render() {
        $query = Transaction::with('user')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('id', 'like', "%{$this->search}%")
                        ->orWhere('type', 'like', "%{$this->search}%")
                        ->orWhere('reference', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($u) {
                            $u->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);


        $rows = $query->paginate($this->perPage);


        return view('livewire.dashboard.latest-transactions-table', [
            'rows' => $rows,
        ]);
    }
}