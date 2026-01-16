<div class="halpha-w-full halpha-space-y-4">
    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
        <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col halpha-col-span-2">
            <div class="halpha-text-xs halpha-text-gray-400">Total Claimed</div>
            <div class="halpha-text-lg halpha-font-bold halpha-text-white">
                ${{ number_format((float) $totalClaimed, 2) }}
            </div>
        </div>

        <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col">
            <div class="halpha-text-xs halpha-text-gray-400">Total earned</div>
            <div class="halpha-text-lg halpha-font-bold halpha-text-white">
                ${{ number_format((float) $totalEarned, 2) }}
            </div>
        </div>

        <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col">
            <div class="halpha-text-xs halpha-text-gray-400">Claimable</div>

            <div class="halpha-flex halpha-flex-col md:halpha-flex-row md:halpha-items-center halpha-justify-between">
                <div class="halpha-text-lg halpha-font-bold halpha-text-white">
                    ${{ number_format((float) $claimable, 2) }}
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
            @if($rewards->isEmpty())
                {{-- Empty state --}}
                <div class="halpha-text-center halpha-py-10 halpha-text-gray-400 halpha-text-sm">
                    <div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-3">
                        <div class="halpha-w-12 halpha-h-12 halpha-rounded-full halpha-bg-gray-800 halpha-flex halpha-items-center halpha-justify-center">
                            <svg class="halpha-w-6 halpha-h-6 halpha-text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 9v3m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="halpha-font-semibold halpha-text-white">No bonuses yet</p>
                        <p class="halpha-text-xs halpha-text-gray-500 halpha-max-w-[260px]">Referral bonuses from your users you invited will appear here.</p>
                    </div>
                </div>
            @else
                @foreach($rewards as $tx)
                    <div class="halpha-card halpha-p-3 halpha-flex halpha-items-start halpha-justify-between halpha-gap-3">
                        <div class="halpha-min-w-0">
                            <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-flex-wrap">
                                <div class="halpha-text-xs halpha-text-gray-400">
                                    Level {{ $tx->level }} Referral Bonus
                                </div>
                            </div>

                            <div class="halpha-text-sm halpha-font-semibold halpha-text-white mt-1">
                                ${{ number_format($tx->amount, 2) }}
                            </div>

                            <div class="halpha-text-xs halpha-text-gray-400">
                                From {{ optional($tx->fromUser)->name ?? 'System' }}
                            </div>

                            <div class="halpha-text-xs halpha-text-gray-400">{{ optional($tx->credited_at)->format('M d, Y H:i') }}</div>

                            @if(!$tx->isClaimable() && $tx->status === 'pending')
                                <div class="halpha-text-xs halpha-text-yellow-400 mt-1">
                                    Locked: {{ $tx->lock_reason ?? 'Cooling period' }}
                                    <br>
                                    Available in {{ $tx->remainingTime() }}
                                </div>
                            @endif
                        </div>

                        <div class="halpha-flex halpha-flex-col halpha-items-end halpha-gap-2">
                            <div class="halpha-flex halpha-items-center halpha-gap-2">

                                @if($tx->status === 'paid')
                                    <span class="halpha-text-xs halpha-border halpha-border-gray-600 halpha-rounded halpha-px-2 halpha-py-1 halpha-text-gray-400">
                                        Claimed
                                    </span>
                                @elseif($tx->isClaimable())
                                    <button wire:click="$set('confirmingRewardId', {{ $tx->id }})"
                                        class="halpha-text-xs halpha-bg-accent-2 halpha-text-white halpha-rounded halpha-px-3 halpha-py-1">
                                        Claim
                                    </button>
                                @else
                                    <span class="halpha-text-xs halpha-border halpha-border-yellow-600 halpha-rounded halpha-px-2 halpha-py-1 halpha-text-yellow-400">
                                        Not claimable
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- pagination --}}
                <div class="halpha-flex halpha-justify-center halpha-mt-2">
                    {{ $rewards->links() }}
                </div>
            @endif
        @endif
    </div>

    @if($confirmingRewardId)
        <div class="halpha-fixed halpha-inset-0 halpha-bg-black/60 halpha-flex halpha-items-center halpha-justify-center z-50">
            <div class="halpha-bg-gray-900 halpha-rounded-xl halpha-p-4 halpha-w-[300px]">
                <p class="halpha-text-white halpha-text-sm">Claim this referral reward?</p>

                <div class="halpha-flex halpha-justify-end halpha-gap-2 mt-4">
                    <button wire:click="$set('confirmingRewardId', null)"
                        class="halpha-text-xs halpha-border halpha-border-gray-600 halpha-rounded halpha-px-3 halpha-py-1">
                        Cancel
                    </button>
                    <button wire:click="claim({{ $confirmingRewardId }})"
                        class="halpha-text-xs halpha-bg-accent-2 halpha-text-white halpha-rounded halpha-px-3 halpha-py-1">
                        <span wire:target="claim" wire:loading.remove>Confirm</span>
                        <span wire:target="claim" wire:loading>Claiming...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>