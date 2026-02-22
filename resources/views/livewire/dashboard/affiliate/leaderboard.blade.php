<div class="halpha-space-y-6">

    <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
        Sprint Leaderboard
    </h1>

    {{-- 🏁 PHASE HEADER --}}
    <div class="halpha-flex halpha-items-center halpha-justify-between halpha-bg-gradient-to-r halpha-from-blue-800/2 halpha-to-sky-200/5 halpha-opacity-50 halpha-border halpha-border-accent-3 halpha-rounded-xl halpha-p-3">
        
        <div>
            <p class="halpha-text-xs halpha-text-gray-400 uppercase tracking-wide">
                Competition Phase
            </p>
            <h2 class="halpha-text-lg halpha-font-bold halpha-text-accent-2">
                Sprint Phase 1 🚀
            </h2>
        </div>

        <div class="halpha-text-right">
            <p class="halpha-text-xs halpha-text-gray-400">Total Reward Pool</p>
            <p class="halpha-text-sm halpha-font-bold halpha-text-white">
                $10,000
            </p>
        </div>

    </div>

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

    <div class="halpha-space-y-4">

        


        {{-- 📘 DESCRIPTION --}}
        <div class="halpha-card halpha-bg-card-soft halpha-p-4 halpha-rounded-xl halpha-space-y-4 halpha-text-[12px] halpha-text-gray-400">

            @if (strtolower($selectedCategory->challenge->name) === 'volume')
                {{-- 🥇 VOLUME --}}
                <div class="halpha-flex halpha-gap-3">
                    <div class="halpha-text-accent-2">💰</div>
                    <div>
                        <p class="halpha-text-white halpha-font-semibold text-sm">
                            Top Personal Volume — $5,000 Pool
                        </p>
                        <p>
                            Leaderboard rankings are determined by <span class="halpha-text-gray-200">total personal (Volume 1)</span> participation accumulated during the Sprint 1 period. Only <span class="halpha-text-gray-200">directly enrolled users</span> and personally generated volume are considered
                        </p>

                        <p class="halpha-mt-1">
                            Downline activity and team spillover are not included in the calculation.
                        </p>
                    </div>
                </div>
            @endif

            {{-- 🚀 NEW MEMBERS --}}
            <div class="halpha-flex halpha-gap-3">
                <div class="halpha-text-accent-2">🚀</div>
                <div>
                    <p class="halpha-text-white halpha-font-semibold text-sm">
                        Most New Team Members — $2,500 Pool
                    </p>
                    <p>
                        Earn rewards by onboarding new users who activate with at least 
                        <span class="halpha-text-gray-200">$200</span>.
                        Only <span class="halpha-text-gray-200">direct referrals</span> count toward ranking.
                    </p>
                </div>
            </div>

            {{-- ⚡ FASTEST --}}
            <div class="halpha-flex halpha-gap-3">
                <div class="halpha-text-accent-2">⚡</div>
                <div>
                    <p class="halpha-text-white halpha-font-semibold text-sm">
                        Fastest 7 Activations — $2,500 Pool
                    </p>
                    <p>
                        Be among the fastest to activate 
                        <span class="halpha-text-gray-200">7 direct members</span> with 
                        <span class="halpha-text-gray-200">$500+</span> each.
                        Speed matters — early completion ranks higher.
                    </p>
                </div>
            </div>

        </div>

        <p class="halpha-text-[11px] halpha-text-gray-400 halpha-hidden">
            Compete, climb the ranks, and earn from the pool before the sprint ends.
        </p>

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
                x-data="{ show: false }"
                x-init="setTimeout(() => show = true, 100)"
                x-show="show"
                x-transition:enter="halpha-transition halpha-duration-300"
                x-transition:enter-start="halpha-opacity-0 halpha-translate-y-2"
                x-transition:enter-end="halpha-opacity-100 halpha-translate-y-0"
            >

                @php
                    $name = $entry->user->name ?? 'U';
                    $initials = strtoupper(substr($name, 0, 1));

                    // simple color generator based on name
                    $colors = ['halpha-bg-indigo-500','halpha-bg-pink-500','halpha-bg-green-500','halpha-bg-yellow-500','halpha-bg-blue-500','halpha-bg-purple-500'];
                    $color = $colors[crc32($name) % count($colors)];

                    $rankStyles = match($entry->rank) {
                        1 => 'halpha-bg-gradient-to-r halpha-from-yellow-400/20 halpha-to-yellow-600/10 halpha-border-yellow-400/40 halpha-shadow-[0_0_25px_rgba(255,215,0,0.3)] halpha-scale-[1.02]',
                        2 => 'halpha-bg-gradient-to-r halpha-from-gray-300/10 halpha-to-gray-500/10 halpha-border-gray-400/30 halpha-shadow-[0_0_20px_rgba(200,200,200,0.2)]',
                        3 => 'halpha-bg-gradient-to-r halpha-from-orange-400/10 halpha-to-orange-600/10 halpha-border-orange-400/30 halpha-shadow-[0_0_20px_rgba(255,140,0,0.2)]',
                        default => 'halpha-bg-card-soft halpha-border-transparent'
                    };

                    $crown = match($entry->rank) {
                        1 => '👑',
                        2 => '🥈',
                        3 => '🥉',
                        default => null
                    };
                @endphp

                <div class="halpha-relative halpha-flex halpha-justify-between halpha-items-center halpha-p-3 halpha-rounded-xl halpha-border {{ $rankStyles }}">

                    

                    <div class="halpha-flex halpha-items-center halpha-gap-3">

                        @if($crown)
                            <div class="absolute -top-2 -left-2 text-lg">
                                {{ $crown }}
                            </div>
                        @endif

                        {{-- Rank --}}
                        @if (!$crown)
                            <span class="halpha-text-accent-2 halpha-font-bold">
                                #{{ $entry->rank }}
                            </span>
                        @endif

                        {{-- Avatar --}}
                        <div class="halpha-w-10 halpha-h-10 halpha-rounded-full {{ $color }} halpha-flex halpha-items-center halpha-justify-center halpha-text-white halpha-font-bold halpha-text-sm shadow">
                            {{ $initials }}
                        </div>

                        {{-- User Info --}}
                        <div>
                            <p class="halpha-text-sm halpha-text-white">
                                {{ mask($entry->user->name) }}
                            </p>
                            <p class="halpha-text-[10px] halpha-text-gray-400">
                                {{ mask_email($entry->user->email) }}
                            </p>
                        </div>

                    </div>

                    {{-- Score --}}
                    <div class="halpha-text-right halpha-hidden">
                        <p class="halpha-text-sm halpha-text-white halpha-font-semibold">
                            @if($selectedCategory->type === 'volume')
                                ${{ format_compact($entry->score) }}
                            @else
                                {{ number_format($entry->score) }}
                            @endif
                        </p>

                        @if($entry->rank <= 3 && true)
                            <span class="halpha-text-[10px] halpha-text-accent-2 halpha-font-medium">
                                Reward Zone .
                            </span>
                        @endif
                    </div>

                    <div class="halpha-text-right">

                    @if($entry->rank <= 3)

                        @php
                            $scoreStyles = match($entry->rank) {
                                1 => 'halpha-bg-gradient-to-r halpha-from-yellow-300 halpha-to-yellow-500 halpha-text-transparent halpha-bg-clip-text halpha-drop-shadow-[0_0_6px_rgba(255,215,0,0.6)]',
                                2 => 'halpha-bg-gradient-to-r halpha-from-gray-300 to-gray-500 halpha-text-transparent halpha-bg-clip-text halpha-drop-shadow-[0_0_5px_rgba(200,200,200,0.5)]',
                                3 => 'halpha-bg-gradient-to-r halpha-from-orange-300 halpha-to-orange-500 halpha-text-transparent halpha-bg-clip-text halpha-drop-shadow-[0_0_5px_rgba(255,140,0,0.5)]',
                            };

                            $badgeBg = match($entry->rank) {
                                1 => 'halpha-bg-yellow-400/10 halpha-border-yellow-400/30',
                                2 => 'halpha-bg-gray-300/10 halpha-border-gray-400/30',
                                3 => 'halpha-bg-orange-400/10 halpha-border-orange-400/30',
                            };
                        @endphp

                        
                        <div class="halpha-inline-block halpha-px-3 halpha-py-1 halpha-rounded-lg halpha-border {{ $badgeBg }}">

                            <p class="halpha-text-sm halpha-font-bold {{ $scoreStyles }}">

                                @if($selectedCategory->type === 'volume')
                                    ${{ format_compact($entry->score) }}
                                @else
                                    {{ number_format($entry->score) }}
                                @endif

                            </p>

                        </div>

                        <span class="halpha-text-[10px] halpha-text-accent-2 halpha-font-semibold halpha-hidden halpha-mt-1">
                            Elite Reward Zone
                        </span>

                    @else

                        {{-- normal users --}}
                        <p class="halpha-text-sm halpha-text-white halpha-font-semibold">
                            @if($selectedCategory->type === 'volume')
                                ${{ number_format($entry->score, 2) }}
                            @else
                                {{ number_format($entry->score) }}
                            @endif
                        </p>

                    @endif

                </div>

                </div>
            </div>
        @empty
            <p class="halpha-text-gray-400 text-xs">No data yet</p>
        @endforelse


    </div>

</div>
