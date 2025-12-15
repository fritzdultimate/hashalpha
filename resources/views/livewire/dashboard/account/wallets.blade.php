<div class="halpha-space-y-6">

    <div>
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Inflow Wallets
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            Your wallets used for deposits.
        </p>
    </div>

    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
        <x-affiliate.stat label="Total confirmed" :value="$total_confirmed" prefix="$" highlight />
        <x-affiliate.stat label="Pending" :value="number_format($total_pending)" prefix="$" />
    </div>


    {{-- Wallet cards --}}
    <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-4">


        @foreach($wallets as $wallet)
            <div class="halpha-card halpha-p-4 halpha-space-y-4">


                {{-- Top row --}}
                <div class="halpha-flex halpha-justify-between halpha-items-center">
                    <div>
                        <p class="halpha-text-sm halpha-text-white">
                            {{ strtoupper($wallet->currency) }} Wallet
                        </p>
                        <p class="halpha-text-xs halpha-text-gray-400">
                            <span class="halpha-block">Last used address:</span>
                            {{ optional($wallet->deposits->first())->address
                                ? Str::mask($wallet->deposits->first()->address, '*', 6)
                                : 'No deposits yet'
                            }}
                        </p>
                    </div>


                    <div class="halpha-text-xs halpha-text-success">
                        Active
                    </div>
                </div>


                {{-- Metrics --}}
                <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
                    <div>
                        <p class="halpha-text-xs halpha-text-gray-400">Total Funded</p>
                        <p class="halpha-text-sm halpha-text-white">
                            ${{ number_format($wallet->finished_deposits_sum  ?? 0, 2) }}
                        </p>
                    </div>


                    <div>
                        <p class="halpha-text-xs halpha-text-gray-400">Network</p>
                        <p class="halpha-text-sm halpha-text-white">
                            {{ $wallet->network ?? 'Mainnet' }}
                        </p>
                    </div>
                </div>


                {{-- Explanation --}}
                <div class="halpha-text-xs halpha-text-gray-500">
                    Deposits made using this wallet are credited to your internal balance.
                </div>


                {{-- Actions --}}
                <div class="halpha-flex halpha-gap-2">
                    <!-- <button wire:navigate href="{{ route('deposit.create') }}"
                        class="halpha-bg-accent-2 halpha-text-white halpha-px-3 halpha-py-2 halpha-rounded halpha-text-xs">
                        Fund Account
                    </button> -->

                    <a href="{{ route('deposit.create') }}"
                        class="halpha-bg-accent-2 halpha-text-white halpha-px-3 halpha-py-2 halpha-rounded halpha-text-xs">
                        Fund Account
                    </a>


                    <button
                        class="halpha-bg-gray-800 halpha-text-gray-300 halpha-px-3 halpha-py-2 halpha-rounded halpha-text-xs"
                        onclick="navigator.clipboard.writeText('{{ $wallet->deposits->first()->address ?? '' }}')">
                        Copy Address
                    </button>
                </div>


            </div>
        @endforeach


    </div>


</div>