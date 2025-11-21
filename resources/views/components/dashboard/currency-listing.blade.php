@props([
    'groupedWallets' => [],
    'wallets' => []
])

<div x-data="depositPanel()" @wallet-selected.window="openPanel($event.detail)" class="halpha-w-full halpha-max-w-lg halpha-mx-auto halpha-space-y-4">
    @foreach ($groupedWallets as $letter => $items)
        <div x-init="init({{ json_encode($items[0]) }})">
            <div class="halpha-text-xs halpha-font-semibold halpha-text-gray-400 halpha-mb-2">{{ $letter }}</div>

            <!-- List -->
            <ul class="halpha-space-y-2">
                @foreach ($items as $wallet)
                    <li 
                        
                        class="halpha-flex halpha-items-center halpha-gap-3 halpha-p-2 halpha-rounded-md halpha-cursor-pointer halpha-transition halpha-bg-transparent hover:halpha-bg-gray-700 focus:halpha-outline-none"
                        tabindex="0" 
                        role="button" 
                        @click="openPanel({{ json_encode($wallet) }})"
                        wire:click='selectWallet({{ json_encode($wallet) }})'
                        @keydown.enter="openPanel({{ json_encode($wallet) }})"
                        aria-label="Select {{ $wallet['currency'] }} - {{ $wallet['label'] }}"
                    >
                        <span
                            class="halpha-w-6 halpha-h-6 {{ $wallet['bg'] }} halpha-rounded-full halpha-flex halpha-justify-center halpha-items-center">
                            <span class="icon {{ $wallet['icon'] }}"></span>
                        </span>
                        <div class="halpha-flex-1">
                            <div class="halpha-flex halpha-items-baseline halpha-justify-between">
                                <span
                                    class="halpha-font-semibold halpha-text-white halpha-text-sm halpha-uppercase">{{ $wallet['currency'] }}</span>
                                <span class="halpha-text-xs halpha-text-gray-500">Deposit available</span>
                            </div>
                            <div class="halpha-text-xs halpha-text-gray-400 halpha-mt-0.5 halpha-capitalize">
                                {{ $wallet['label'] }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    <x-dashboard.action-sheets.deposit-action-sheet :wallets="$wallets" />

</div>

<script src="{{ asset('js/dashboard.deposit.js') }}"></script>