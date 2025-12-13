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
                x-ref="level{{ $level }}"
                x-init="
                    if({{ $activeLevel }} === {{ $level }}) {
                        $nextTick(() => {
                            $refs.level{{ $level }}.scrollIntoView({
                                behavior: 'smooth',
                                inline: 'center',
                                block: 'nearest'
                            })
                        })
                    }
                "
            >
                L{{ $level }}
            </button>
        @endforeach
    </div>

    <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-4 halpha-gap-3">
        <x-affiliate.stat label="Members" :value="321" />
        <x-affiliate.stat label="Active" :value="123" />
        <x-affiliate.stat label="Volume" :value="345" />
        <x-affiliate.stat label="Earnings" :value="4543" />
    </div>


    <div class="halpha-space-y-2">
        {{-- Team list --}}
        <div class="halpha-space-y-2 halpha-mt-5">
            <div class="halpha-card halpha-p-3 halpha-flex halpha-justify-between">
                <div>
                    <div class="halpha-text-sm halpha-text-white halpha-capitalize">fritz</div>
                    <div class="halpha-text-xs halpha-text-gray-400">
                        Joined Dec, 25, 2019
                    </div>
                </div>
                <div class="halpha-text-right">
                    <div
                        class="halpha-text-xs {{ true ? 'halpha-text-success' : 'halpha-text-gray-400' }}">
                        {{ true ? 'Active' : 'Inactive' }}
                    </div>
                    <div class="halpha-text-xs halpha-text-gray-400">
                        $100.53
                    </div>
                </div>
            </div>
            @forelse($team as $member)
                <div class="halpha-card halpha-p-3 halpha-flex halpha-justify-between">
                    <div>
                        <div class="halpha-text-sm halpha-text-white">{{ $member->username }}</div>
                        <div class="halpha-text-xs halpha-text-gray-400">Joined {{ $member->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="halpha-text-right">
                        <div
                            class="halpha-text-xs {{ $member->is_active ? 'halpha-text-success' : 'halpha-text-gray-400' }}">
                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                        </div>
                        <div class="halpha-text-xs halpha-text-gray-400">
                            ${{ number_format($member->volume, 2) }}
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


</div>