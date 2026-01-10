<div class="halpha-space-y-6">
    <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
        Team Dashboard
    </h1>
    <p class="halpha-text-xs halpha-text-gray-400">
        View your downline structure (up to 10 levels)
    </p>


    <div x-data class="halpha-flex halpha-gap-2 halpha-overflow-x-auto halpha-scrollbar-hide halpha-scroll-smooth halpha-transition-transform halpha-duration-700">
        @foreach(range(1, 10) as $level)
            <button
                class="halpha-px-3 halpha-py-1 halpha-rounded-full halpha-text-xs
                            {{ $activeLevel === $level ? 'halpha-bg-accent-2 halpha-text-white' : 'halpha-bg-gray-800 halpha-text-gray-400' }}"
                wire:click="loadLevel({{ $level }})"
            >
                L{{ $level }}
            </button>
        @endforeach
    </div>

    <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-4 halpha-gap-3">
        <x-affiliate.stat label="Members" :value="$members" />
        <x-affiliate.stat label="Active" :value="$activeMembers" />
        <x-affiliate.stat label="Volume" :value="number_format($volume, 2)" />
        <x-affiliate.stat label="Earnings" :value="number_format($earnings, 2)" />
    </div>


    <div class="halpha-space-y-2">
        {{-- Team list --}}
        @forelse($team as $member)
            <div class="halpha-card halpha-p-3 halpha-flex halpha-justify-between">
                <div>
                    <div class="halpha-text-sm halpha-text-white">
                        {{ $member->name }}
                    </div>
                    <div class="halpha-text-xs halpha-text-gray-400">
                        Joined {{ $member->created_at->format('M d, Y') }}
                    </div>
                </div>

                <div class="halpha-text-right">
                    <div class="halpha-text-xs {{ !$member->is_suspended ? 'halpha-text-success' : 'halpha-text-gray-400' }}">
                        {{ !$member->is_suspended ? 'Active' : 'Inactive' }}
                    </div>
                    <div class="halpha-text-xs halpha-text-gray-400">
                        ${{ number_format($member->stakes->sum('amount') ?? 0, 2) }}
                    </div>
                </div>
            </div>
        @empty
            <div class="halpha-text-center halpha-text-gray-400 halpha-text-sm">
                No members on this level
            </div>
        @endforelse

    </div>


</div>