<div class="halpha-space-y-6">

    <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
        Sprint Leaderboard
    </h1>

    {{-- Tabs --}}
    <div class="halpha-flex halpha-gap-2">
        @foreach($categories as $ch)
            <button 
                wire:click="setTab('{{ $ch->id }}')"
                class="halpha-px-3 halpha-py-1 halpha-rounded halpha-text-xs
                {{ $activeTab == $ch->id ? 'halpha-bg-accent-2 halpha-text-black' : 'halpha-bg-gray-800 halpha-text-gray-400' }}"
            >
                {{ $ch->challenge->name }}
            </button>
        @endforeach
    </div>

    @if($myRank)
        <div class="halpha-card halpha-p-3 halpha-text-center halpha-bg-card-soft">
            <p class="halpha-text-xs halpha-text-gray-400">Your Position</p>
            <h2 class="halpha-text-xl halpha-text-accent-2 halpha-font-bold">
                #{{ $myRank }}
            </h2>
        </div>
    @endif

    <div 
        x-data="{
            end: {{ $selectedCategory && $selectedCategory->challenge->end_at ? 'new Date(\''.$selectedCategory->challenge->end_at.'\').getTime()' : 'null' }},
            now: new Date().getTime(),
            timer: null,

            init() {
                if (!this.end) return;

                this.timer = setInterval(() => {
                    this.now = new Date().getTime();
                }, 1000);
            },

            get remaining() {
                if (!this.end) return 'No active challenge';

                let diff = this.end - this.now;

                if (diff <= 0) return 'Challenge ended';

                let d = Math.floor(diff / (1000*60*60*24));
                let h = Math.floor((diff % (1000*60*60*24))/(1000*60*60));
                let m = Math.floor((diff % (1000*60*60))/(1000*60));
                let s = Math.floor((diff % (1000*60))/1000);

                // 🔥 Smart formatting
                if (d > 0) {
                    return `${d} day${d > 1 ? 's' : ''} ${h} hour${h !== 1 ? 's' : ''}`;
                }

                if (h > 0) {
                    return `${h} hour${h > 1 ? 's' : ''} ${m} minute${m !== 1 ? 's' : ''}`;
                }

                if (m > 0) {
                    return `${m} minute${m > 1 ? 's' : ''}`;
                }

                return `${s} second${s !== 1 ? 's' : ''}`;
            }
        }"
        class="halpha-card halpha-p-4 halpha-text-center"
    >
        <p class="halpha-text-xs halpha-text-gray-400">Time Remaining</p>

        <h2 class="halpha-text-accent-2 halpha-font-bold halpha-text-lg">
            <span x-text="remaining" class="halpha-capitalize"></span>
        </h2>
    </div>


    @php
        $top3 = collect($leaderboard)->take(3);
    @endphp

    @if($top3->count() >= 1)
        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-3 halpha-items-end">

            {{-- 2nd --}}
            @if(isset($top3[1]))
            <div class="halpha-text-center halpha-bg-gray-800 halpha-rounded-xl halpha-p-3 halpha-scale-95">
                <p class="halpha-text-xs halpha-text-gray-400">🥈 2nd</p>
                <p class="halpha-text-sm halpha-text-white font-semibold halpha-capitalize">{{ $top3[1]->user->name }}</p>
                <p class="halpha-text-xs halpha-text-gray-400">
                    {{ $selectedCategory->type === 'volume' ? '$'.number_format($top3[1]->score, 2) : $top3[1]->score }}
                </p>
            </div>
            @endif

            {{-- 1st --}}
            @if(isset($top3[0]))
            <div class="halpha-text-center halpha-bg-accent-2 halpha-rounded-xl halpha-p-4 halpha-scale-110 shadow-lg">
                <p class="halpha-text-xs text-black font-bold">🥇 1st</p>
                <p class="halpha-text-sm text-black font-bold halpha-capitalize">{{ $top3[0]->user->name }}</p>
                <p class="halpha-text-xs text-black">
                    {{ $selectedCategory->type === 'volume' ? '$'.number_format($top3[0]->score, 2) : $top3[0]->score }}
                </p>
            </div>
            @endif

            {{-- 3rd --}}
            @if(isset($top3[2]))
            <div class="halpha-text-center halpha-bg-gray-800 halpha-rounded-xl halpha-p-3 halpha-scale-95">
                <p class="halpha-text-xs halpha-text-gray-400">🥉 3rd</p>
                <p class="halpha-text-sm halpha-text-white font-semibold halpha-capitalize">{{ $top3[2]->user->name }}</p>
                <p class="halpha-text-xs halpha-text-gray-400">
                    {{ $selectedCategory->type === 'volume' ? '$'.number_format($top3[2]->score, 2) : $top3[2]->score }}
                </p>
            </div>
            @endif

        </div>
    @endif





    {{-- Table --}}
    <div class="halpha-card halpha-p-4 halpha-space-y-3">

        @forelse($leaderboard as $entry)
            <div
                id="wrapper"
                x-data="{ show: false }"
                x-init="setTimeout(() => show = true, 100)"
                x-show="show"
                x-transition:enter="halpha-transition halpha-duration-300"
                x-transition:enter-start="halpha-opacity-0 halpha-translate-y-2"
                x-transition:enter-end="halpha-opacity-100 halpha-translate-y-0"
            >
                <div class="halpha-flex halpha-justify-between halpha-items-center halpha-bg-card-soft halpha-p-3 halpha-rounded">

                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <span class="halpha-text-accent-2 halpha-font-bold">
                            #{{ $entry->rank }}
                        </span>

                        <div>
                            <p class="halpha-text-sm halpha-text-white">
                                {{ $entry->user->name }}
                            </p>
                            <p class="halpha-text-[10px] halpha-text-gray-400">
                                {{ $entry->user->email }}
                            </p>
                        </div>
                    </div>

                    <div class="halpha-text-right">
                        <p class="halpha-text-sm halpha-text-white">
                            @if($selectedCategory->type === 'volume')
                                ${{ number_format($entry->score, 2) }}
                            @else
                                {{ number_format($entry->score) }}
                            @endif
                        </p>

                        @if($entry->rank <= 3)
                            <span class="halpha-text-[10px] halpha-text-accent-2">
                                Reward Zone
                            </span>
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <p class="halpha-text-gray-400 text-xs">No data yet</p>
        @endforelse

    </div>

</div>
