<div class="halpha-w-full halpha-space-y-4">
    @if($earnings->isNotEmpty())
        <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col halpha-gap-2 halpha-bg-gray-900/60 halpha-rounded-xl">
            <div class="halpha-flex halpha-justify-between halpha-items-center">
                <span class="halpha-text-xs halpha-text-gray-400">Rewards (last 30 days)</span>
                <span class="halpha-text-xs halpha-text-gray-400">{{ now()->subDays(29)->format('M d') }} - {{ now()->format('M d') }}</span>
            </div>

            <div class="halpha-mt-2">
                @php
                    // generate daily totals for last 30 days based on credited_at
                    $days = collect(range(0, 29))->map(fn($i) => now()->subDays(29 - $i)->startOfDay());
                    $daily = $days->map(function($d) use ($earnings) {
                        $next = $d->copy()->endOfDay();
                        return $earnings->filter(fn($e) => \Carbon\Carbon::parse($e->credited_at) >= $d && \Carbon\Carbon::parse($e->credited_at) <= $next)
                                        ->sum('amount');
                    });

                    $max = max($daily->toArray()) ?: 1;
                    $points = [];
                    // SVG width mapping: use 120 width, margin 4 left/right
                    $width = 120; $height = 40; $left = 4; $right = 4;
                    $usableW = $width - $left - $right;
                    foreach ($daily as $i => $v) {
                        $x = $left + ($i / max(1, $daily->count() - 1)) * $usableW;
                        $y = ($height - 4) - ($v / $max * ($height - 8)); // padding top/bottom 4
                        $points[] = round($x,2) . ',' . round($y,2);
                    }
                @endphp

                <svg viewBox="0 0 {{ $width }} {{ $height }}" class="halpha-w-full halpha-h-10">
                    <polyline fill="none" stroke="var(--halpha-accent-2)" stroke-width="2" stroke-linecap="round"
                        points="{{ implode(' ', $points) }}" />
                </svg>
            </div>
        </div>
    @endif

    <!-- Top summary cards -->
    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
        <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col halpha-col-span-2">
            <div class="halpha-text-xs halpha-text-gray-400">Total Claimed</div>
            <div class="halpha-text-lg halpha-font-bold halpha-text-white">
                ${{ number_format((float) $totalClaimed, 8) }}
            </div>
        </div>

        <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col">
            <div class="halpha-text-xs halpha-text-gray-400">Total earned</div>
            <div class="halpha-text-lg halpha-font-bold halpha-text-white">
                ${{ number_format((float) $totalEarned, 8) }}
            </div>
        </div>

        <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col">
            <div class="halpha-text-xs halpha-text-gray-400">Claimable</div>

            <div class="halpha-flex halpha-flex-col md:halpha-flex-row md:halpha-items-center halpha-justify-between">
                <div class="halpha-text-lg halpha-font-bold halpha-text-white">
                    ${{ number_format((float) $withdrawable, 8) }}
                </div>

                <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-w-full md:halpha-w-auto">
                    <button 
                        wire:click="claimAll"
                        class="halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-accent-2 halpha-text-white halpha-font-semibold halpha-w-full halpha-max-h-8"
                        aria-label="Claim all rewards"
                    >
                        <span wire:loading.remove wire:target="claimAll">Claim all</span>
                        <x-ri-loader-4-fill wire:target="claimAll" wire:loading class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
                        
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters / search -->
    <div class="halpha-flex halpha-flex-col sm:halpha-flex-row halpha-gap-3 halpha-items-center">
        <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-w-full sm:halpha-w-auto">
            <input wire:model.live.debounce.500ms="search" type="search" placeholder="Search stake id, type or level"
                class="halpha-w-full halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-800 halpha-text-white halpha-text-sm halpha-outline-none" />
            <button wire:click="$set('search','')"
                class="halpha-ml-2 halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Clear</button>
        </div>

        <div class="halpha-mt-2 sm:halpha-mt-0 halpha-ml-auto halpha-flex halpha-items-center halpha-gap-2">
            <select wire:model.live="filter"
                class="halpha-bg-gray-800 halpha-text-sm halpha-px-3 halpha-py-2 halpha-rounded">
                <option value="">All</option>
                <option value="claimable">Claimable</option>
                <option value="claimed">Claimed</option>
            </select>
        </div>
    </div>

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
                        <div class="halpha-w-12 halpha-h-12 halpha-rounded-full halpha-bg-gray-800 halpha-flex halpha-items-center halpha-justify-center">
                            <svg class="halpha-w-6 halpha-h-6 halpha-text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 9v3m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="halpha-font-semibold halpha-text-white">No rewards yet</p>
                        <p class="halpha-text-xs halpha-text-gray-500 halpha-max-w-[260px]">Rewards from your stakes and referrals will appear here.</p>
                    </div>
                </div>
            @else
                @foreach($earnings as $tx)
                    <div class="halpha-card halpha-p-3 halpha-flex halpha-items-start halpha-justify-between halpha-gap-3">
                        <div class="halpha-min-w-0">
                            <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-flex-wrap">
                                <div class="halpha-text-xs halpha-text-gray-400">{{ ucfirst(str_replace('_', ' ', $tx->reward_type)) }}</div>
                                @if(!empty($tx->stake_id))
                                    <div class="halpha-text-xs halpha-text-gray-500">
                                        • <a href="{{ route('stakes.item', $tx->stake_id) }}" class="halpha-text-accent-2 hover:halpha-text-accent-3">Stake #{{ $tx->stake_id }}</a>
                                    </div>
                                @endif
                                @if(!empty($tx->source_user_id))
                                    <div class="halpha-text-xs halpha-text-gray-500">
                                        • From: <span class="halpha-capitalize">{{ $tx->fromUser->name }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-truncate mt-1">
                                {{ number_format((float) $tx->amount, 8) }}
                            </div>

                            <div class="halpha-text-xs halpha-text-gray-400">{{ optional($tx->credited_at)->format('M d, Y H:i') }}</div>
                        </div>

                        <div class="halpha-flex halpha-flex-col halpha-items-end halpha-gap-2">
                            <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-flex-row-reverse">
                                <button wire:click="compoundProfit({{ $tx->id }})"
                                    wire:loading.attr="disabled"
                                    title="Copy reward id"
                                    class="halpha-text-xs halpha-text-gray-300 halpha-border halpha-border-gray-700 halpha-px-2 halpha-py-1 halpha-rounded halpha-bg-accent-2 disabled:halpha-opacity-50">
                                    <span wire:target="compoundProfit" wire:loading.remove>Compound</span>
                                    <span wire:loading wire:target="compoundProfit">waiting...</span>
                                </button>

                                @if($tx->status === 'pending')
                                    <button class="halpha-text-xs halpha-px-1 halpha-py-1 halpha-border halpha-border-accent-3 halpha-rounded halpha-text-accent-2 halpha-flex halpha-gap-1">
                                        <x-heroicon-o-arrow-path class="halpha-w-4 halpha-h-4" />
                                        Claim
                                    </button>
                                @else
                                    <span class="halpha-text-xs halpha-px-1 halpha-py-1 halpha-border halpha-border-gray-500 halpha-rounded halpha-text-gray-400 halpha-flex halpha-gap-1">
                                        <x-tabler-device-mobile-dollar class="halpha-w-4 halpha-h-4" />
                                        Claimed
                                    </span>
                                @endif
                            </div>
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

@push('scripts')
    <script src="{{ asset('js/fn.js') }}"></script>
@endpush
