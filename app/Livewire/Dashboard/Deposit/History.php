<?php

namespace App\Livewire\Dashboard\Deposit;

use App\Livewire\QrCode;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\NowPaymentsService;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Livewire;

#[Layout('layouts.app')]
class History extends Component {

    public $search = '';
    public $status = '';
    public $perPage = 12;
    public $transactions;

    public $showModal = false;
    public $selected = null;

    protected $updatesQueryString = ['search', 'status', 'page'];

    public function mount() {
        $this->transactions = Deposit::where('user_id', auth()->id())->get();
    }

    public function render() {
        return view('livewire.dashboard.deposit.history');
    }

}