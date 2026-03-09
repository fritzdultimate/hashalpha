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
                    {{ $category->type === 'volume' ? '$' . number_format($top3[1]->score, 2) : $top3[1]->score }}
                </p>
            </div>
        @endif

        {{-- 1st --}}
        @if(isset($top3[0]))
            <div class="halpha-text-center halpha-bg-accent-2 halpha-rounded-xl halpha-p-4 halpha-scale-110 shadow-lg">
                <p class="halpha-text-xs text-black font-bold">🥇 1st</p>
                <p class="halpha-text-sm text-black font-bold halpha-capitalize">{{ $top3[0]->user->name }}</p>
                <p class="halpha-text-xs text-black">
                    {{ $category->type === 'volume' ? '$' . number_format($top3[0]->score, 2) : $top3[0]->score }}
                </p>
            </div>
        @endif

        {{-- 3rd --}}
        @if(isset($top3[2]))
            <div class="halpha-text-center halpha-bg-gray-800 halpha-rounded-xl halpha-p-3 halpha-scale-95">
                <p class="halpha-text-xs halpha-text-gray-400">🥉 3rd</p>
                <p class="halpha-text-sm halpha-text-white font-semibold halpha-capitalize">{{ $top3[2]->user->name }}</p>
                <p class="halpha-text-xs halpha-text-gray-400">
                    {{ $category->type === 'volume' ? '$' . number_format($top3[2]->score, 2) : $top3[2]->score }}
                </p>
            </div>
        @endif

    </div>
@endif