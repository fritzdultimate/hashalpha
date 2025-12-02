<div wire:key="plans-list-root">
    <div class="halpha-space-y-4">

        <!-- Search Section -->
        <div class="halpha-flex halpha-flex-col sm:halpha-flex-row halpha-gap-3 halpha-items-center">
            <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-w-full sm:halpha-w-auto">
                <label for="planSearch" class="halpha-sr-only">Search plans</label>
                <input id="planSearch" wire:model.live="search" type="search"
                    placeholder="Search plans (name or description)"
                    class="halpha-w-full halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-800 halpha-text-white halpha-text-sm halpha-outline-none" />

                <button wire:click="$set('search','')"
                    class="halpha-ml-2 halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Clear</button>
            </div>

            <div class="halpha-mt-2 sm:halpha-mt-0 halpha-ml-auto halpha-flex halpha-items-center halpha-gap-2">
                <select wire:model="durationFilter"
                    class="halpha-bg-gray-800 halpha-text-sm halpha-px-3 halpha-py-2 halpha-rounded">
                    <option value="">All durations</option>
                    <option value="7">7 days</option>
                    <option value="30">30 days</option>
                    <option value="90">90 days</option>
                </select>

                <select wire:model="sortBy"
                    class="halpha-bg-gray-800 halpha-text-sm halpha-px-3 halpha-py-2 halpha-rounded">
                    <option value="apy_decimal">Sort: APY</option>
                    <option value="min_amount_decimal">Sort: Min amount</option>
                    <option value="duration_days">Sort: Duration</option>
                </select>

                <button wire:click="$toggle('sortDir', 'asc')" title="Toggle sort direction"
                    class="halpha-ml-2 halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700 halpha-text-xs">
                    @if($sortDir === 'desc') Desc @else Asc @endif
                </button>
            </div>
        </div>

        
        <div class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-3">
            <div class="halpha-text-sm halpha-text-gray-400 halpha-hidden sm:halpha-inline">
                Showing <span class="halpha-font-medium halpha-text-white">{{ $this->plans->count() }}</span> of <span
                    class="halpha-font-medium halpha-text-white">{{ $totalPlans }}</span> plans
            </div>

            <div class="halpha-flex halpha-flex-col md:halpha-flex-row halpha-items-center halpha-gap-3 halpha-w-full md:halpha-w-auto">
                @if($this->plans->isNotEmpty())
                    <div class="halpha-text-xs halpha-text-gray-400 halpha-w-full">Tip: tap <span
                            class="halpha-font-semibold halpha-text-white">Stake</span> to open the stake sheet</div>
                @endif

                <div class="halpha-flex halpha-justify-between md:halpha-justify-end halpha-w-full">

                    <a 
                        href="{{ route('stakes.index') }}"
                        class="halpha-ml-2 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-text-xs halpha-text-white halpha-flex halpha-items-center halpha-gap-2 hover:halpha-bg-accent-2 halpha-transition-all halpha-duration-300"
                        title="View my stakes"
                    >
                        <x-fas-coins class="halpha-w-4 halpha-h-4" />
                        <span>My stakes</span>
                    </a>

                    <button 
                        onclick="Livewire.emit && Livewire.emit('openMyStakesModal')"
                        class="halpha-ml-2 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-accent-2 halpha-text-white halpha-text-xs"
                    >
                        Quick view
                    </button>
                </div>
            </div>
        </div>

        {{-- Empty state --}}
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
                    <p class="halpha-text-xs halpha-text-gray-500 halpha-max-w-[260px]">New investment plans will appear here
                        once added.</p>
                </div>
            </div>
        @endif

        {{-- Plan grid --}}
        <div class="halpha-space-y-3 md:halpha-space-y-0 md:halpha-grid md:halpha-grid-cols-3 halpha-gap-5">
            @foreach($this->plans as $plan)
                <div
                    class="halpha-card halpha-p-4 md:halpha-p-6 halpha-flex halpha-flex-col halpha-rounded-xl halpha-bg-gray-900 halpha-border halpha-border-gray-800">
                    <div class="halpha-flex halpha-justify-between halpha-items-start halpha-gap-3">
                        <div class="halpha-min-w-0 halpha-flex halpha-flex-col halpha-gap-2">
                            <div class="halpha-flex halpha-items-center halpha-gap-3">
                                <div class="halpha-flex halpha-items-center halpha-justify-center halpha-w-10 halpha-h-10 halpha-rounded-full halpha-bg-gray-800 halpha-min-w-10">
                                    <span
                                        class="halpha-text-xs halpha-text-gray-400">{{ strtoupper(substr($plan->name, 0, 2)) }}</span>
                                </div>
                                <div class="halpha-min-w-0">
                                    <h3 class="halpha-text-lg halpha-font-semibold halpha-text-white truncate">{{ $plan->name }}
                                    </h3>
                                    <div class="halpha-text-xs halpha-text-gray-400 truncate">{{ $plan->description ?? '—' }}
                                    </div>
                                </div>
                            </div>

                            
                        </div>

                        <div class="halpha-text-right halpha-flex halpha-flex-col halpha-items-end halpha-justify-between">
                            <div>
                                <div class="halpha-text-2xl halpha-font-bold halpha-text-accent-2">
                                    {{ rtrim((string) $plan->daily_roi, '.') }}%
                                </div>
                                <div class="halpha-text-xs halpha-text-gray-400">APY</div>
                            </div>
                        </div>
                    </div>

                    <div class="halpha-space-y-2 halpha-mt-3">
                        <div class="halpha-flex halpha-gap-2 halpha-items-center halpha-mt-2">
                            {{-- badges --}}
                            @if($plan->compound_allowed)
                                <span
                                    class="halpha-text-[11px] halpha-px-2 halpha-py-1 halpha-rounded halpha-bg-success/10 halpha-text-success halpha-font-medium">Compound</span>
                            @endif
                            <span
                                class="halpha-text-[11px] halpha-px-2 halpha-py-1 halpha-rounded halpha-bg-gray-800 halpha-text-gray-300 halpha-font-medium">Min:
                                {{ number_format($plan->min_amount, 2) }}</span>
                            <span
                                class="halpha-text-[11px] halpha-px-2 halpha-py-1 halpha-rounded halpha-bg-gray-800 halpha-text-gray-300 halpha-font-medium">{{ $plan->duration_days ? $plan->duration_days . 'd' : 'Flexible' }}</span>
                        </div>
                    </div>

                    {{-- utilization sparkline + bar --}}
                    <div class="halpha-mt-4 halpha-space-y-2">
                        <div class="halpha-h-8 halpha-w-full halpha-bg-gray-800 halpha-rounded overflow-hidden">
                            @php
                                $seed = crc32($plan->id);
                                $vals = [];
                                for ($i = 0; $i < 12; $i++) {
                                    $vals[] = (sin($seed + $i) + 1) * (0.5 + ($i % 3) / 5);
                                }
                                $maxv = max($vals);
                                $points = [];
                                foreach ($vals as $i => $v) {
                                    $x = 2 + ($i * (100 / 11));
                                    $y = 26 - (($v / $maxv) * 20);
                                    $points[] = $x . ',' . $y;
                                }
                            @endphp
                            <svg viewBox="0 0 100 30" class="halpha-w-full halpha-h-full">
                                <polyline fill="none" stroke="var(--halpha-accent-2)" stroke-width="1.5"
                                    points="{{ implode(' ', $points) }}" />
                            </svg>
                        </div>

                        {{-- utilization bar --}}
                        @php
                            $util = optional($plan->meta)['utilization'] ?? (50 + ($plan->id % 40));
                            $util = (int) min(100, max(0, $util));
                        @endphp
                        <div class="halpha-w-full halpha-bg-gray-800 halpha-rounded halpha-h-2">
                            <div class="halpha-h-2 halpha-rounded"
                                style="width: {{ $util }}%; background: linear-gradient(90deg, var(--halpha-accent-2), rgba(14,165,163,0.6));">
                            </div>
                        </div>
                        <div class="halpha-text-xs halpha-text-gray-400">
                            Pool utilization: <span class="halpha-text-white halpha-font-medium">{{ $util }}%</span>
                        </div>
                    </div>

                    {{-- actions --}}
                    <div class="halpha-mt-4 halpha-flex halpha-gap-3">
                        <button 
                            wire:click="openStakeModal({{ $plan->id }})"
                            class="halpha-flex-1 halpha-py-2 halpha-rounded-lg halpha-bg-accent-2 halpha-text-white halpha-font-semibold halpha-max-h-10 halpha-flex halpha-justify-center halpha-items-center"
                            aria-label="Stake on {{ $plan->name }}"
                        >
                            <span wire:loading.remove wire:target="openStakeModal">Stake</span>
                            <x-ri-loader-4-fill wire:target="openStakeModal" wire:loading class="halpha-w-6 halpha-h-6 halpha-animate-spin" />
                        </button>
                        <button 
                            type="button" 
                            class="halpha-py-2 halpha-px-4 halpha-rounded-lg halpha-border halpha-border-gray-700 halpha-text-xs halpha-text-gray-300" 
                            aria-label="View details for {{ $plan->name }}"
                            onclick="dispatchEvent(new CustomEvent('openPlanDetails', { detail: {{ $plan->id }} }))"
                        >
                            Details
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- load more --}}
        @if($this->plans->count() > 0 && $this->plans->count() >= $perPage)
            <div class="halpha-flex halpha-justify-center halpha-mt-4">
                <button wire:click="loadMore" class="halpha-w-full sm:halpha-w-auto halpha-px-4 halpha-py-2 halpha-rounded halpha-bg-gray-800 halpha-text-white halpha-font-semibold">
                    <span wire:loading.remove wire:target="loadMore">Load more</span>
                    <span wire:loading wire:target="loadMore">Loading</span>
                </button>
            </div>
        @endif

        <livewire:stake-modal />

    </div>

    <script>
        window.addEventListener('openPlanDetails', (e) => {
            // If you want to handle opening a client-side modal for details,
            // you can emit a Livewire event or show an Alpine sheet here:
            const id = e.detail;
            // Example: trigger Livewire to open server modal (preferred)
            if (window.Livewire) {
                try { Livewire.emit('openPlanDetails', id); } catch (e) { }
            }
        });
    </script>
</div>