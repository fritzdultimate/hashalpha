<?php

namespace App\Livewire\Dashboard\Deposit;

use App\Livewire\QrCode;
use App\Models\Deposit;
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
class Create extends Component {
    public $currency = 'ETH';
    public $amount;
    public $invoice;
    public $depositId = 2;
    public $wallets;
    public $note = '';
    public $network = '';
    public $nowPaymentStatus;
    public $nowPaymentWallets;
    public $otp = null;

    public $step;

    public $selectedWallet = null;

    #[On('resetValues')]
    public function resetValues() {
        $this->note = '';
        $this->amount = null;
        $this->resetErrorBag();
    }

    protected $rules = [
        'amount' => 'required|numeric|min:50',
        'currency' => 'required|string',
    ];

    protected $messages = [
        'amount.min' => "Amount must be at least $50."
    ];

    protected $listeners = [
        'otpUpdated' => 'setOtpFromChild',
        'resendOtp' => 'handleResend',
        'example' => 'example'
    ];

    #[On('set-address')]
    public function dispatchAddress($address) {
        $this->dispatch('address-available', $address)->to(QrCode::class);
    }


    public function setOtpFromChild($value) {
        dd('this is parent otp');
        $this->otp = preg_replace('/\D/', '', substr($value, 0, 4));
    }

    public function mount(NowPaymentsService $np) {
        $this->nowPaymentWallets = $np->getCurrencies();
    }



    public function resendOtp() {
        TwoFactorService::generateFor(Auth::user(), 'deposit', 4, 10);
    }

    public function createDeposit() {
        $this->validate();
    }

    public function selectWallet($wallet) {
        $this->selectedWallet = $wallet;
    }


    public function createInvoice($isOtp = false) {
        if($isOtp && $this->otp === null) {
            $this->addError('otp', 'Your OTP is required.');
            return;
        }

        $this->validate();

        $lastDeps = Deposit::where([
            'user_id' => auth()->id()
        ])->whereNotIn('status', ['finished', 'failed', 'cancelled', 'confirmed'])
        ->get();

        if($lastDeps) {
            $this->addError('general', 'You have an ongoing deposit transaction. Please finish it before creating a new one.');
            return;
        }

        if($this->otp === null) {
            TwoFactorService::generateFor(Auth::user(), 'deposit', 4, 10);
            $this->dispatch('otp-created', $this->invoice);

            return;
        }

        $ok = TwoFactorService::validate(Auth::user(), $this->otp, 'deposit');
        if(!$ok) {
            $this->addError('otp', 'Your OTP is invalid.');
            return;
        }



        DB::transaction(function () {
            $wallet = Wallet::firstOrCreate(
            ['user_id' => auth()->id(), 'currency' => $this->currency],
            [
                'balance' => 0, 
                'currency' => $this->currency,
                'user_id' => auth()->id()
                ]
            );


            $deposit = Deposit::create([
                'user_id' => auth()->id(),
                'wallet_id' => $wallet->id,
                'currency' => $this->network,
                'amount' => $this->amount,
                'status' => 'waiting'
            ]);
 


            $invoice = NowPaymentsService::createInvoice($deposit);
            $deposit->nowpayments_invoice_id = $invoice['payment_id'] ?? null;
            $deposit->meta = $invoice;
            $deposit->address = $invoice['pay_address'];
            $deposit->save();

            $wallet->address = $invoice['pay_address'];
            $wallet->save();


            $this->invoice = $invoice;

            session()->put('pay_address', $invoice['pay_address']);

            $this->depositId = $deposit->id;
            $this->dispatch('address-created', invoice: $this->invoice, depositId: $this->depositId);
        });
        
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