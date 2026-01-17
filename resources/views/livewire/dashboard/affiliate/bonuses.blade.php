<div class="halpha-space-y-6">
    <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
        Referral Bonus
    </h1>
    <p class="halpha-text-xs halpha-text-gray-400">
        View your downline bonuses
    </p>

    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
        <x-affiliate.stat label="Total" :value="number_format($totalAvailable,2)" prefix="$" highlight />
        <x-affiliate.stat label="Withdrawn" :value="number_format($pending,2)" prefix="$" />
    </div>

    @if($claimable > 0)
        <div class="halpha-card halpha-p-4 halpha-border-success/30">
            <div class="halpha-flex halpha-justify-between halpha-items-center">
                <div>
                    <p class="halpha-text-sm halpha-text-white">Available Bonus</p>
                    <p class="halpha-text-xs halpha-text-gray-400">Ready to claim</p>
                </div>

                <button
                    wire:click="claim"
                    wire:loading.attr="disabled"
                    class="halpha-bg-accent-2 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs"
                >
                    <span wire:loading.remove>Claim</span>
                    <span wire:loading>Processing…</span>
                </button>
            </div>
        </div>
    @endif


    {{-- Bonus History --}}
    <div class="halpha-space-y-2">
        @forelse($bonuses as $bonus)
            <div class="halpha-card halpha-p-3 halpha-flex halpha-justify-between">
                <div>
                    <div class="halpha-text-sm halpha-text-white halpha-capitalize">
                        {{ $bonus->fromUser->name ?? 'Referral User' }} <span class="halpha-text-xs halpha-text-gray-400">(Level{{ $bonus->level }})</span>
                    </div>
                    <div class="halpha-text-xs halpha-text-gray-400">
                        {{ $bonus->created_at->diffForHumans() }}
                    </div>
                </div>

                <div class="halpha-text-right">
                    <div class="halpha-text-xs
                        @class([
                            'halpha-text-success' => $bonus->status === 'claimable',
                            'halpha-text-accent-3' => $bonus->status === 'pending',
                            'halpha-text-gray-400' => $bonus->status === 'claimed',
                        ])
                    ">
                        <!-- {{ ucfirst($bonus->status) }} -->
                    </div>
                    <div class="halpha-text-xs halpha-text-gray-400">
                        ${{ number_format($bonus->amount, 2) }}
                    </div>
                </div>
            </div>
        @empty
            <div class="halpha-text-center halpha-text-gray-400 halpha-text-sm">
                No referral bonuses yet
            </div>
        @endforelse
    </div>


</div>