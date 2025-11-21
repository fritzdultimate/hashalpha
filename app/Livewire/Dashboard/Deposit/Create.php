<?php

namespace App\Livewire\Dashboard\Deposit;

use App\Models\Deposit;
use App\Models\Wallet;
use App\Services\NowPaymentsService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Create extends Component {
    public $currency = 'ETH';
    public $amount;
    public $invoice;
    public $depositId;
    public $wallets;

    public $selectedWallet = null;

    protected $rules = [
        'amount' => 'required|numeric|min:0.0001',
        'currency' => 'required|string',
    ];

    public function mount() {
        $this->wallets = [
            [
                'currency' => 'btc',
                'label' => 'Bitcoin',
                'icon' => 'icon-btc',
                'bg' => 'halpha-bg-btc'

            ],
            [
                'currency' => 'eth',
                'label' => 'Ethereum',
                'icon' => 'icon-eth',
                'bg' => 'halpha-bg-eth'

            ],
            [
                'currency' => 'usdt',
                'label' => 'USDT',
                'icon' => 'icon-usdt',
                'bg' => 'halpha-bg-usdt'

            ],
            [
                'currency' => 'xrp',
                'label' => 'Ripple',
                'icon' => 'icon-xrp',
                'bg' => 'halpha-bg-xrp'

            ]
        ];
    }

    public function createDeposit() {
        $this->validate();

        dd($this->currency);
    }

    public function selectWallet($wallet) {
        $this->selectedWallet = $wallet;
    }


    public function createInvoice() {
        $this->validate();


        DB::transaction(function () {
            $wallet = Wallet::firstOrCreate(
            ['user_id' => auth()->id(), 'currency' => $this->currency],
            ['balance' => 0]
            );


            $deposit = Deposit::create([
                'user_id' => auth()->id(),
                'wallet_id' => $wallet->id,
                'currency' => $this->currency,
                'amount' => $this->amount,
                'status' => 'waiting'
            ]);


        $this->depositId = $deposit->id;


        $invoice = NowPaymentsService::createInvoice($deposit);
        $deposit->nowpayments_invoice_id = $invoice['id'] ?? null;
        $deposit->metadata = $invoice;
        $deposit->save();


        $this->invoice = $invoice;
        });


        $this->emit('invoiceCreated', $this->invoice);
    }


    public function checkInvoiceStatus() {
        if (!$this->invoice || empty($this->invoice['id'])) return;


        $latest = NowPaymentsService::checkInvoice($this->invoice['id']);
        $this->invoice = $latest;


        
        if (!empty($this->depositId)) {
            $dep = Deposit::find($this->depositId);
            $dep->status = $latest['payment_status'] ?? $dep->status;
            $dep->metadata = $latest;
            $dep->save();
        }
    }


    public function render() {
        return view('livewire.dashboard.deposit.create');
    }

}