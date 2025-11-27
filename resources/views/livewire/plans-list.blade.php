<div>
    @if($this->plans->isEmpty())
        <div class="halpha-text-center halpha-py-10 halpha-text-gray-400 halpha-text-sm">
            <div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-3">
                <div
                    class="halpha-w-12 halpha-h-12 halpha-rounded-full halpha-bg-gray-800 halpha-flex halpha-items-center halpha-justify-center">
                    <svg class="halpha-w-6 halpha-h-6 halpha-text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 9v3m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <p class="halpha-font-semibold halpha-text-white">No staking plans available</p>
                <p class="halpha-text-xs halpha-text-gray-500 halpha-max-w-[220px]">
                    New investment plans will appear here once they are added.
                </p>
            </div>
        </div>
    @endif

    <div class="halpha-space-y-3">
        @foreach($this->plans as $plan)
            <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col">
                <div class="halpha-flex halpha-justify-between halpha-items-start">
                    <div class="halpha-min-w-0">
                        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white truncate">{{ $plan->name }}</h3>
                        <p class="halpha-text-xs halpha-text-gray-400 truncate">{{ $plan->description ?? '—' }}</p>
                        <p class="halpha-text-xs halpha-text-gray-400 mt-1">Min
                            {{ number_format($plan->min_amount_decimal, 2) }}</p>
                    </div>

                    <div class="halpha-text-right halpha-ml-4 halpha-flex halpha-flex-col halpha-justify-center">
                        <div class="halpha-text-lg halpha-font-bold halpha-text-white">
                            {{ rtrim(rtrim((string) $plan->apy_decimal, '0'), '.') }}%</div>
                        <div class="halpha-text-xs halpha-text-gray-400">APY</div>
                    </div>
                </div>

                <div class="halpha-mt-3 halpha-flex halpha-gap-2">
                    <button wire:click="openStakeModal({{ $plan->id }})"
                        class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-bg-accent-2 halpha-text-white halpha-font-semibold">Stake</button>
                    <button
                        class="halpha-ml-2 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700 halpha-text-xs">Details</button>
                </div>
            </div>
        @endforeach
    </div>
</div>