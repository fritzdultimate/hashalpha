<div class="halpha-w-full halpha-min-h-screen halpha-flex halpha-justify-center">
    @php

        $groupedWallets = collect($filteredCurrencies)
            ->sortBy('label')
            ->groupBy(function ($item) {
                return strtoupper(substr($item['label'], 0, 1));
            });

        $wallets = collect($this->filteredCurrencies)
    @endphp

    <div
        class="halpha-w-full halpha-max-w-[480px] md:halpha-shadow md:halpha-shadow-white/20 halpha-min-h-screen halpha-py-5 halpha-flex halpha-flex-col halpha-gap-5 halpha-p-2 md:halpha-p-6"
    >
        <x-dashboard.partials.micro-header />
        <x-dashboard.search-data />
        <div class="halpha-w-full halpha-flex halpha-justify-end">
            <a href="{{ route('deposit.history') }}" class="halpha-text-xs halpha-text-accent-2 halpha-font-medium hover:halpha-text-accent-3 halpha-transition-all halpha-duration-300">History</a>
        </div>

        {{-- Deposit Disclaimer --}}
        <div class="halpha-card halpha-rounded-lg halpha-bg-card-soft halpha-p-3 halpha-text-[11px] halpha-text-gray-400 halpha-leading-relaxed">
            <p class="halpha-font-medium halpha-text-gray-300 halpha-mb-1">
                Important Deposit Information
            </p>

            <ul class="halpha-list-disc halpha-pl-4 halpha-space-y-1">
                <li>
                    Ensure you are sending funds to the <span class="halpha-text-gray-200">correct network and address</span>. Sending assets on the wrong network may result in permanent loss.
                </li>
                <li>
                    Deposits below the minimum required amount may not be credited to your account.
                </li>
                <li>
                    Deposits require network confirmations before becoming available. Processing times depend on blockchain conditions.
                </li>
                <li>
                    Blockchain transactions are <span class="halpha-text-gray-200">irreversible</span>. Once confirmed, they cannot be canceled or refunded.
                </li>
                <li>
                    You are solely responsible for verifying all transaction details before submitting a deposit.
                </li>
            </ul>
        </div>

        @if($bonusPercent > 0)
            <div class="halpha-card halpha-rounded-lg halpha-bg-accent-soft halpha-p-3 halpha-text-[12px] halpha-text-accent-1 halpha-font-medium">
                Deposit now and get {{ $bonusPercent }}% bonus! Bonus valid untill Feb. 16, 2026.
            </div>
        @endif

        <x-dashboard.disclaimer />


        <x-dashboard.currency-listing :wallets="$wallets" :groupedWallets="$groupedWallets" />

    </div>
</div>

@script
    <script>

        Livewire.on('otp-created', (event) => {
            console.log('otp dispatched');
            window.dispatchEvent(new CustomEvent('deposit:step', {
                detail: { step: 'otp' }
            }));
        })

        Livewire.on('address-created', (event) => {
            $wire.dispatch('set-address', { address: event.invoice.pay_address });
            console.log(event)
            window.dispatchEvent(new CustomEvent('deposit:step', {
                detail: { step: 'address', depositId: event.depositId, address: event.invoice.pay_address, pay_amount: event.invoice.pay_amount  }
            }));
        });

        
        Livewire.on('resendOtp', () => {
            @this.call('resendOtp');
        });
    </script>
@endscript