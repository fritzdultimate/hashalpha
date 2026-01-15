<?php

namespace App\Livewire\Dashboard\Deposit;

use App\Models\Deposit;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class History extends Component {
    use WithPagination;

    public $search = '';
    public $status = '';
    public $perPage = 12;
    // public $transactions;

    public $showModal = false;
    public $selected = null;

    // protected $updatesQueryString = ['search', 'status', 'page'];

    public function updated($prop) {
        $this->resetPage();
    }

    public function mapCurrencyLabel($currency) {
        $nameMap = [
            'BTC'  => 'Bitcoin',
            'ETH'  => 'Ethereum',
            'LTC'  => 'Litecoin',
            'TRX'  => 'TRON',
            'USDTTRC20' => 'Tether',
            'USDERRC20' => 'Tether',
            'USDC' => 'USD Coin',
        ];
        
        return $nameMap[\strtoupper($currency)] ?? null;
    }

    public function showDetails($id){
        $this->selected = Deposit::where([
            'user_id' => auth()->id(),
            'id' => $id
        ])->first();
        $this->showModal = (bool) $this->selected;
    }

    public function closeModal() {
        $this->showModal = false;
        $this->selected = null;
    }

    public function getTransactionsQueryProperty() {
        $q = Deposit::query()->where('user_id', auth()->id())
            ->when($this->search, fn($builder) => $builder->where(function($b) {
                $b->where('currency', 'like', '%'.$this->search.'%')
                  ->orWhere('address', 'like', '%'.$this->search.'%')
                  ->orWhere('tx_hash', 'like', '%'.$this->search.'%')
                  ->orWhere('amount', 'like', '%'.$this->search.'%');
            }))
            ->when($this->status, fn($builder) => $builder->where('status', $this->status))
            ->orderBy('created_at', 'desc');

        return $q;
    }

    public function getTransactionsProperty() {
        return $this->transactionsQuery->paginate($this->perPage);
    }

    public function render() {
        return view('livewire.dashboard.deposit.history', [
            'transactions' => $this->transactions,
            'totalAmount' => $this->transactionsQuery->sum('amount'),
        ]);
    }

}