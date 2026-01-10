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

    {{-- Wallet Information --}}
    <div
        class="halpha-card halpha-rounded-lg halpha-bg-card-soft halpha-p-3 halpha-text-[11px] halpha-text-gray-400 halpha-leading-relaxed">
        <p class="halpha-font-medium halpha-text-gray-300 halpha-mb-1">
            Important Wallet Information
        </p>

        <ul class="halpha-list-disc halpha-pl-4 halpha-space-y-1">
            <li>
                Always verify <span class="halpha-text-gray-200">wallet addresses, networks, and assets</span> before
                performing any transaction.
            </li>
            <li>
                Blockchain transactions are <span class="halpha-text-gray-200">permanent and irreversible</span> once
                confirmed on the network.
            </li>
            <li>
                Transaction times may vary depending on network congestion and blockchain conditions.
            </li>
            <li>
                Certain actions may be subject to security checks, system reviews, or temporary delays to protect your
                account.
            </li>
            <li>
                You are solely responsible for reviewing and confirming all wallet-related details before proceeding.
            </li>
        </ul>
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
                            ${{ number_format($wallet->finished_deposits_sum ?? 0, 2) }}
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