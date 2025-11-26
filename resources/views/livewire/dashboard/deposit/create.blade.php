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
        class="halpha-w-full halpha-max-w-[480px] halpha-shadow-lg halpha-min-h-screen halpha-py-5 halpha-flex halpha-flex-col halpha-gap-5">
        <x-dashboard.partials.micro-header />
        <x-dashboard.search-data />
        <span>{{ $search }}</span>

        <x-dashboard.currency-listing :wallets="$wallets" :groupedWallets="$groupedWallets" />

    </div>
</div>

@script
    <script>

        Livewire.on('otp-created', (event) => {
            console.log('for otp');
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