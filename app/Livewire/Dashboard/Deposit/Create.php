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
    public $filteredCurrencies;
    public $otp = null;

    public $step;
    public $search;

    public $selectedWallet = null;

    public function updated($prop, $value) {
        if($prop === "search") {
            $q = trim($value);
            if ($q === '') {
                $this->filteredCurrencies = $this->nowPaymentWallets;
                return;
            }

            $search = strtolower($q);

            $filtered = array_filter($this->nowPaymentWallets, function ($item) use ($search) {

                if (str_contains(strtolower($item['currency']), $search)) return true;
                if (str_contains(strtolower($item['label']), $search)) return true;

                if (!empty($item['networks'])) {
                    foreach ($item['networks'] as $net) {
                        if (isset($net['network']) && str_contains(strtolower($net['network']), $search)) {
                            return true;
                        }
                    }
                }

                return false;
            });

            $this->filteredCurrencies = $filtered;
        }
    }

    #[On('resetValues')]
    public function resetValues() {
        $this->note = '';
        $this->amount = null;
        $this->otp = null;
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
        $this->otp = preg_replace('/\D/', '', substr($value, 0, 4));
    }

    public function mount(NowPaymentsService $np) {
        $this->nowPaymentWallets = $np->getCurrencies();
        $this->filteredCurrencies = $this->nowPaymentWallets;
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

    public function prepareDeposit() {
        $this->validate();

        if(auth()->user()->hasUnsettledDeposit()) {
            $this->addError('general', 'You have an ongoing deposit transaction. Please finish it before creating a new one.');
            return;
        }

        TwoFactorService::generateFor(Auth::user(), 'deposit', 4, 10);
        $this->dispatch('otp-created', $this->invoice);

    }


    public function createPayment() {

        if($this->otp === null) {
            $this->addError('otp', 'Your OTP is required.');
            return;
        }

        $ok = TwoFactorService::validate(Auth::user(), $this->otp, 'deposit');
        if(!$ok) {
            $this->addError('otp', 'Invalid or expired otp.');
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