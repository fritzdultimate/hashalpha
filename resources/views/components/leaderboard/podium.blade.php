@php
    $type = strtolower($category->type);

    $limit = $type === 'activation_count' ? 3 : 5;
    $top = collect($leaderboard)->take($limit);

    $isMoney = in_array($type, ['team_volume', 'level_1_volume', 'personal_volume']);

    $formatScore = fn($entry) =>
        $isMoney ? '$' . number_format($entry->score, 2) : number_format($entry->score);

    $rewards = match($type) {
        'team_volume' => [1 => '$5,000 + Bali', 2 => '$3,000', 3 => '$1,500', 4 => '$1,000', 5 => '$750'],
        'level_1_volume' => [1 => '$2,000', 2 => '$1,500', 3 => '$1,000', 4 => '$750', 5 => '$500'],
        'personal_volume' => [1 => '$3,500 + Bali', 2 => '$1,500', 3 => '$1,000', 4 => '$750', 5 => '$500'],
        'activation_count' => [1 => '$3,000', 2 => '$1,500', 3 => '$1,000'],
        default => []
    };
@endphp

@if($top->count())
<div>
    <div class="halpha-space-y-3 halpha-hidden">

        {{-- HEADER --}}
        <div class="halpha-flex halpha-justify-between halpha-items-center">
            <div>
                <p class="halpha-text-[11px] halpha-text-gray-400 halpha-uppercase halpha-tracking-wide">
                    Championship Leaders
                </p>
                <p class="halpha-text-sm halpha-text-white halpha-font-semibold">
                    Top {{ $limit }} Rankings
                </p>
            </div>
        </div>

        {{-- LIST STYLE (PREMIUM) --}}
        <div class="halpha-space-y-2">

            @foreach($top as $entry)

                @php
                    $rank = $entry->rank;

                    $accent = match($rank) {
                        1 => 'halpha-bg-accent-2',
                        2 => 'halpha-bg-gray-400',
                        3 => 'halpha-bg-gray-500',
                        default => 'halpha-bg-gray-700'
                    };

                    $isTop = $rank === 1;
                @endphp

                <div class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-3 halpha-p-3 halpha-rounded-xl halpha-bg-card-soft halpha-border halpha-border-white/5 halpha-relative overflow-hidden {{ $isTop ? 'halpha-border-accent-2' : '' }}">

                    {{-- subtle depth layer --}}
                    <div class="halpha-absolute halpha-inset-0 halpha-bg-gradient-to-r halpha-from-white/0 halpha-via-white/[0.02] halpha-to-white/0 pointer-events-none"></div>

                    {{-- LEFT --}}
                    <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-min-w-0 halpha-relative">

                        {{-- RANK BAR --}}
                        <div class="halpha-w-[3px] halpha-h-10 halpha-rounded-full {{ $accent }}"></div>

                        {{-- RANK + USER --}}
                        <div class="halpha-space-y-0.5 halpha-min-w-0">

                            <div class="halpha-flex halpha-items-center halpha-gap-2">

                                <span class="halpha-text-xs halpha-font-bold {{ $rank === 1 ? 'halpha-text-accent-2' : 'halpha-text-white' }}">
                                    #{{ $rank }}
                                </span>

                                @if($rank <= 3)
                                    <span class="halpha-text-[10px] halpha-text-gray-400">
                                        {{ ['🥇','🥈','🥉'][$rank - 1] }}
                                    </span>
                                @endif

                            </div>

                            <p class="halpha-text-sm halpha-text-white halpha-font-semibold halpha-truncate">
                                {{ mask($entry->user->name) }}
                            </p>

                            <p class="halpha-text-[10px] halpha-text-gray-500 halpha-truncate">
                                {{ mask_email($entry->user->email) }}
                            </p>

                        </div>
                    </div>

                    {{-- RIGHT --}}
                    <div class="halpha-text-right halpha-space-y-1 halpha-min-w-[70px]">

                        {{-- SCORE --}}
                        <p class="halpha-text-sm halpha-text-white halpha-font-semibold">
                            {{ $formatScore($entry) }}
                        </p>

                        {{-- REWARD --}}
                        @if(isset($rewards[$rank]))
                            <p class="halpha-text-[10px] halpha-text-gray-400">
                                {{ $rewards[$rank] }}
                            </p>
                        @endif

                        {{-- MOVEMENT --}}
                        @if($entry->rank_change > 0)
                            <p class="halpha-text-green-400 halpha-text-[10px] halpha-font-medium">
                                ▲ +{{ $entry->rank_change }}
                            </p>
                        @elseif($entry->rank_change < 0)
                            <p class="halpha-text-red-400 halpha-text-[10px] halpha-font-medium">
                                ▼ {{ $entry->rank_change }}
                            </p>
                        @else
                            <p class="halpha-text-gray-600 halpha-text-[10px]">
                                —
                            </p>
                        @endif

                    </div>  

                </div>

            @endforeach

        </div>

    </div>


    @php
        $top3 = collect($leaderboard)->take(3);
        $top1 = collect($leaderboard)->take(1);
    @endphp

 
    @if($top3->count() >= 1)
        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-3 halpha-items-end">

            {{-- 2nd --}}
            @if(isset($top3[1]))
            <div class="halpha-text-center halpha-bg-gray-800 halpha-rounded-xl halpha-p-3 halpha-scale-95">
                <p class="halpha-text-xs halpha-text-gray-400">🥈 2nd</p>
                <p class="halpha-text-sm halpha-text-white font-semibold halpha-capitalize">{{ $top3[1]->user->name }}</p>
                <p class="halpha-text-xs halpha-text-gray-400">
                    {{ $formatScore($top3[1]) }}
                </p>
            </div>
            @endif

            {{-- 1st --}}
            @if(isset($top3[0]))
            <div class="halpha-text-center halpha-bg-accent-2 halpha-rounded-xl halpha-p-4 halpha-scale-110 shadow-lg">
                <p class="halpha-text-xs text-black font-bold">🥇 1st</p>
                <p class="halpha-text-sm text-black font-bold halpha-capitalize">{{ $top3[0]->user->name }}</p>
                <p class="halpha-text-xs text-black">
                    {{ $formatScore($top3[0]) }}
                </p>
            </div>
            @endif

            {{-- 3rd --}}
            @if(isset($top3[2]))
            <div class="halpha-text-center halpha-bg-gray-800 halpha-rounded-xl halpha-p-3 halpha-scale-95">
                <p class="halpha-text-xs halpha-text-gray-400">🥉 3rd</p>
                <p class="halpha-text-sm halpha-text-white font-semibold halpha-capitalize">{{ $top3[2]->user->name }}</p>
                <p class="halpha-text-xs halpha-text-gray-400">
                    {{ $formatScore($top3[2]) }}
                </p>
            </div>
            @endif

        </div>
    @endif
</div>
@endif