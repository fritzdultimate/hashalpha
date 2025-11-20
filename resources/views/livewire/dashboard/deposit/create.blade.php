<div class="halpha-w-full halpha-min-h-screen halpha-flex halpha-justify-center">
    <div class="halpha-bg-card-bg halpha-rounded-2xl halpha-p-4 halpha-shadow-sm halpha-hidden">
        <h3 class="halpha-text-lg halpha-font-semibold">Create Deposit</h3>
        <div class="halpha-mt-3">
            <label class="halpha-block halpha-text-sm halpha-text-muted">Currency</label>
            <select wire:model="currency" class="halpha-w-full halpha-py-2 halpha-rounded halpha-mt-1">
                <option value="ETH">ETH</option>
                <option value="USDT">USDT (ERC20)</option>
                <option value="USDT-TRC20">USDT (TRC20)</option>
                <option value="USDC">USDC</option>
                <option value="BTC">BTC</option>
            </select>
        </div>


        <div class="halpha-mt-3">
            <label class="halpha-block halpha-text-sm halpha-text-muted">Amount</label>
            <input wire:model.defer="amount" type="number" step="any"
                class="halpha-w-full halpha-py-3 halpha-rounded halpha-mt-1" placeholder="0.00">
        </div>


        <div class="halpha-mt-4 halpha-grid halpha-grid-cols-2 halpha-gap-3">
            <button wire:click="createInvoice"
                class="halpha-py-3 halpha-rounded-2xl halpha-font-semibold halpha-bg-accent halpha-w-full">Create
                Invoice</button>
            <button wire:click="$refresh"
                class="halpha-py-3 halpha-rounded-2xl halpha-font-semibold halpha-border halpha-w-full">Reset</button>
        </div>


        @if($invoice)
            <div class="halpha-mt-4 halpha-border halpha-rounded halpha-p-3">
                <h4 class="halpha-font-semibold halpha-text-sm">Invoice</h4>


                <div class="halpha-mt-2 halpha-flex halpha-flex-col sm:halpha-flex-row halpha-gap-3 halpha-items-center">
                    <div class="halpha-flex-1">
                        <p class="halpha-text-xs halpha-text-muted">Pay to:</p>
                        <p class="halpha-break-words">
                            {{ $invoice['pay_address'] ?? ($invoice['payment_address'] ?? ($invoice['payin_address'] ?? '—')) }}
                        </p>
                        <p class="halpha-text-xs halpha-text-muted">Amount:
                            {{ $invoice['pay_amount'] ?? $invoice['price_amount'] ?? '' }}
                            {{ $invoice['pay_currency'] ?? $invoice['price_currency'] ?? '' }}
                        </p>
                        <p class="halpha-text-xs halpha-text-muted">Status:
                            {{ $invoice['payment_status'] ?? $invoice['status'] ?? 'waiting' }}
                        </p>
                    </div>


                    <div>
                        {{-- QR placeholder: you can generate QR from invoice address or invoice['pay_url'] --}}
                        @if(!empty($invoice['pay_url']))
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($invoice['pay_url']) }}"
                                alt="qr">
                        @endif
                    </div>
                </div>


                <div class="halpha-mt-3 halpha-flex halpha-items-center halpha-justify-between">
                    <div>
                        <button wire:click="checkInvoiceStatus" class="halpha-text-sm halpha-underline">Check
                            Status</button>
                    </div>


                    <div>
                        <span class="halpha-text-xs halpha-text-muted">Auto-polling</span>
                        <input type="checkbox" wire:model="poll">
                    </div>
                </div>


            </div>
        @endif
    </div>

    @php
        $wallets = [
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

        $groupedWallets = collect($wallets)
            ->sortBy('label')
            ->groupBy(function ($item) {
        return strtoupper(substr($item['label'], 0, 1));
    });
    @endphp

    <div
        class="halpha-w-full halpha-max-w-[480px] halpha-shadow-lg halpha-min-h-screen halpha-py-5 halpha-flex halpha-flex-col halpha-gap-5">
        <x-dashboard.partials.micro-header />
        <x-dashboard.search-data />

        <x-dashboard.currency-listing :groupedWallets="$groupedWallets" />

    </div>
</div>