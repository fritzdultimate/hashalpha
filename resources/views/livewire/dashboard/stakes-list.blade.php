<div class="halpha-space-y-3">
    <div class="halpha-flex halpha-items-center halpha-gap-3">
        <input 
            wire:model.live.debounce.300ms="search" 
            type="search" 
            placeholder="Search stakes"
            class="halpha-w-full halpha-bg-gray-800 halpha-text-white halpha-rounded halpha-px-3 halpha-py-2 halpha-text-sm" 
        />
        <select wire:model.live="filterStatus"
            class="halpha-bg-gray-800 halpha-text-sm halpha-px-3 halpha-py-2 halpha-rounded">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <div class="halpha-space-y-3">
        @forelse($stakes as $stake)
            <div
                class="halpha-card halpha-p-3 halpha-bg-gray-900 halpha-border halpha-border-gray-800 halpha-flex halpha-items-center halpha-justify-between">
                <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-min-w-0">
                    <div
                        class="halpha-min-w-10 halpha-h-10 halpha-rounded-full halpha-bg-gray-800 halpha-flex halpha-items-center halpha-justify-center halpha-text-sm halpha-text-gray-300">
                        {{ strtoupper(substr($stake->plan->name ?? 'PL', 0, 2)) }}
                    </div>
                    <div class="halpha-min-w-0">
                        <div class="halpha-text-sm halpha-text-white halpha-font-semibold halpha-truncate">
                            {{ $stake->plan->name ?? '—' }}
                        </div>
                        <div class="halpha-text-xs halpha-text-gray-400 halpha-truncate halpha-flex halpha-flex-col md:halpha-flex-row">
                            <span>Amount: ${{ number_format($stake->amount, 2) }}</span>
                            <span class="halpha-hidden md:halpha-block">&nbsp; • &nbsp;</span>
                            <span>Started: {{ optional($stake->started_at)->format('d M, Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-text-right">
                    <div class="halpha-text-sm halpha-font-semibold halpha-text-white">
                        ${{ number_format($stake->rewards->sum('amount'), 2) }}
                    </div>
                    @if (!$fixedPage)
                        <button 
                            wire:click="viewStake({{ $stake->id }})"
                            class="halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-text-xs halpha-text-gray-300"
                        >
                            View
                        </button>
                    @else
                        <a 
                            href="{{ route('stakes.item', $stake->id) }}"
                            class="halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-text-xs halpha-text-gray-300"
                        >
                            Details
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="halpha-text-center halpha-py-8 halpha-text-gray-400">You have no stakes yet.</div>
        @endforelse
    </div>

    <div class="halpha-mt-3 halpha-hidden">
        {{ $stakes->links() }}
    </div>

    {{-- optional: load more button if you prefer infinite load behaviour --}}
    @if($stakes->count() > 0 && $stakes->count() >= $perPage && !$fixedPage)
        <div class="halpha-flex halpha-justify-center halpha-mt-4">
            <button wire:click="loadMore" class="halpha-w-full sm:halpha-w-auto halpha-px-4 halpha-py-2 halpha-rounded halpha-bg-gray-800 halpha-text-white halpha-font-semibold">
                <span wire:loading.remove wire:target="loadMore">Load more</span>
                <span wire:loading wire:target="loadMore">Loading</span>
            </button>
        </div>
    @endif
</div>
