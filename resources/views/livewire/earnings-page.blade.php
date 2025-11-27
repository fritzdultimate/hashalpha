<div class="halpha-w-full halpha-space-y-4">
    @if($earnings->isNotEmpty())
        <div
            class="halpha-card halpha-p-3 halpha-flex halpha-flex-col halpha-gap-2 halpha-bg-gray-900/60 halpha-rounded-xl">
            <div class="halpha-flex halpha-justify-between halpha-items-center">
                <span class="halpha-text-xs halpha-text-gray-400">Earnings (last 30 days)</span>
                <span class="halpha-text-xs halpha-text-gray-400">{{ now()->subDays(30)->format('M d') }} -
                    {{ now()->format('M d') }}</span>
            </div>
            <div class="halpha-mt-2">
                <svg viewBox="0 0 120 40" class="halpha-w-full halpha-h-10">
                    @php
                        // generate daily totals for last 30 days
                        $days = collect(range(0, 29))->map(fn($i) => now()->subDays(29 - $i)->format('Y-m-d'));
                        $daily = $days->map(fn($d) => $earnings->where('created_at', '>=', $d)->where('created_at', '<', now()->parse($d)->addDay())->sum('amount_decimal'));
                        $max = max($daily->toArray()) ?: 1;
                        $points = [];
                        foreach ($daily as $i => $v) {
                            $x = 4 + $i * 4; // simple spacing
                            $y = 36 - ($v / $max * 30); // height 30px
                            $points[] = "$x,$y";
                        }
                    @endphp
                    <polyline fill="none" stroke="#22d3ee" stroke-width="2" points="{{ implode(' ', $points) }}" />
                </svg>
            </div>
        </div>
    @endif


    <!-- Top summary cards -->
    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
        <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col">
            <div class="halpha-text-xs halpha-text-gray-400">Total earned</div>
            <div class="halpha-text-lg halpha-font-bold halpha-text-white">{{ number_format((float) $totalEarned, 8) }}
            </div>
        </div>

        <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col">
            <div class="halpha-text-xs halpha-text-gray-400">Claimable</div>
            <div class="halpha-flex halpha-items-center halpha-justify-between">
                <div class="halpha-text-lg halpha-font-bold halpha-text-white">
                    {{ number_format((float) $withdrawable, 8) }}
                </div>
                <button wire:click="claimAll"
                    class="halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-accent-2 halpha-text-white halpha-font-semibold"
                    aria-label="Claim all rewards">
                    Claim all
                </button>
            </div>
        </div>
    </div>

    <!-- Filters / search -->
    <div class="halpha-flex halpha-flex-col sm:halpha-flex-row halpha-gap-3 halpha-items-center">
        <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-w-full sm:halpha-w-auto">
            <input wire:model.debounce.500ms="search" type="search" placeholder="Search stake id or plan"
                class="halpha-w-full halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-800 halpha-text-white halpha-text-sm halpha-outline-none" />
            <button wire:click="$set('search','')"
                class="halpha-ml-2 halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Clear</button>
        </div>

        <div class="halpha-mt-2 sm:halpha-mt-0 halpha-ml-auto halpha-flex halpha-items-center halpha-gap-2">
            <select wire:model="filter"
                class="halpha-bg-gray-800 halpha-text-sm halpha-px-3 halpha-py-2 halpha-rounded">
                <option value="">All</option>
                <option value="claimable">Claimable</option>
                <option value="claimed">Claimed</option>
            </select>
        </div>
    </div>

    @if($withdrawable > 0)
        <div class="halpha-flex halpha-justify-end halpha-mb-3">
            <button wire:click="withdrawAll"
                class="halpha-px-4 halpha-py-2 halpha-bg-accent-2 halpha-text-white halpha-font-semibold halpha-rounded-lg halpha-text-sm">
                Withdraw All
            </button>
        </div>
    @endif

    <!-- Earnings list -->
    <div class="halpha-space-y-3">
        @if($loading)
            {{-- skeletons --}}
            @for($i = 0; $i < 3; $i++)
                <div class="halpha-card halpha-p-3 animate-pulse halpha-bg-gray-800/50 halpha-rounded">
                    <div class="halpha-h-3 halpha-bg-gray-700 halpha-rounded halpha-w-1/3 mb-2"></div>
                    <div class="halpha-h-3 halpha-bg-gray-700 halpha-rounded halpha-w-1/2"></div>
                </div>
            @endfor
        @else
            @if($earnings->isEmpty())
                {{-- Empty state --}}
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
                        <p class="halpha-font-semibold halpha-text-white">No earnings yet</p>
                        <p class="halpha-text-xs halpha-text-gray-500 halpha-max-w-[260px]">
                            Rewards from your stakes will appear here. Stake funds to start earning.
                        </p>
                    </div>
                </div>
            @else
                @foreach($earnings as $tx)
                    <div class="halpha-card halpha-p-3 halpha-flex halpha-items-start halpha-justify-between halpha-gap-3">
                        <div class="halpha-min-w-0">
                            <div class="halpha-flex halpha-items-center halpha-gap-2">
                                <div class="halpha-text-xs halpha-text-gray-400">{{ ucfirst(str_replace('_', ' ', $tx->type)) }}
                                </div>
                                @if(isset($tx->meta['stake_id']))
                                    <div class="halpha-text-xs halpha-text-gray-500">• Stake #{{ $tx->meta['stake_id'] }}</div>
                                @endif
                            </div>
                            <div class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-truncate">
                                {{ number_format($tx->amount_decimal, 8) }}
                            </div>
                            <div class="halpha-text-xs halpha-text-gray-400">{{ $tx->created_at->format('M d, Y H:i') }}</div>
                        </div>

                        <div class="halpha-flex halpha-flex-col halpha-items-end halpha-gap-2">
                            @if($tx->type === 'stake_reward')
                                <button onclick="copyRef('{{ $tx->id }}')" title="Copy tx id"
                                    class="halpha-text-xs halpha-text-gray-300 halpha-border halpha-border-gray-700 halpha-px-2 halpha-py-1 halpha-rounded">Copy</button>
                            @endif
                            @if($tx->type === 'stake_reward' && $tx->amount_decimal > 0)
                                <span class="halpha-text-xs halpha-text-gray-400">Pending</span>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- pagination --}}
                <div class="halpha-flex halpha-justify-center halpha-mt-2">
                    {{ $earnings->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<script>
    function copyRef(id) {
        try {
            navigator.clipboard.writeText(id);
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Copied transaction id' } }));
        } catch (e) {
            // fallback
        }
    }
</script>