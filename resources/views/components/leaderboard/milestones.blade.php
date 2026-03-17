@php
    $levels = [
        'bronze' => ['label' => 'Bronze Builder', 'amount' => 20000, 'display' => '$20K', 'icon' => '🥉'],
        'silver' => ['label' => 'Silver Builder', 'amount' => 50000, 'display' => '$50K', 'icon' => '🥈'],
        'gold' => ['label' => 'Gold Builder', 'amount' => 75000, 'display' => '$75K', 'icon' => '🥇'],
        'diamond' => ['label' => 'Diamond Builder', 'amount' => 100000, 'display' => '$100K', 'icon' => '💎'],
    ];

    $currentVolume = $currentVolume ?? 0;

    $nextLevel = null;
    foreach ($levels as $key => $lvl) {
        if ($currentVolume < $lvl['amount']) {
            $nextLevel = $lvl;
            break;
        }
    }
@endphp

<div class="halpha-card halpha-p-4 md:halpha-p-5 halpha-rounded-xl halpha-bg-gradient-to-br halpha-from-[#020617] halpha-to-[#0f172a] halpha-border halpha-border-white/5 halpha-space-y-5">

    {{-- HEADER --}}
    <div class="halpha-space-y-1">
        <p class="halpha-text-[11px] halpha-text-gray-400 uppercase tracking-wide">
            Leadership Milestones
        </p>

        <h3 class="halpha-text-white halpha-font-bold halpha-text-sm md:halpha-text-base">
            Volume Achievement Ladder
        </h3>

        <p class="halpha-text-gray-400 halpha-text-xs md:halpha-text-sm">
            Grow your team volume to unlock milestone rewards and leadership recognition.
        </p>
    </div>

    {{-- 🔥 PROGRESS BAR --}}
    <div class="halpha-space-y-2">

        <div class="halpha-flex halpha-justify-between halpha-text-[10px] halpha-text-gray-400">
            <span>Your Volume</span>
            <span>${{ number_format($currentVolume) }}</span>
        </div>

        <div class="halpha-w-full halpha-h-2 halpha-bg-gray-800 halpha-rounded-full overflow-hidden">
            <div class="halpha-h-full halpha-bg-gradient-to-r halpha-from-green-400 halpha-to-emerald-500 halpha-rounded-full"
                 style="width: {{ min(($currentVolume / 100000) * 100, 100) }}%">
            </div>
        </div>

        @if($nextLevel)
            <p class="halpha-text-[10px] halpha-text-gray-400">
                Next milestone: 
                <span class="halpha-text-white font-semibold">
                    {{ $nextLevel['label'] }}
                </span>
                ({{ $nextLevel['display'] }})
            </p>
        @else
            <p class="halpha-text-green-400 halpha-text-[10px] font-semibold">
                🎉 All milestones unlocked
            </p>
        @endif

    </div>

    {{-- 🧱 LADDER --}}
    <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-4 halpha-gap-3">

        @foreach($levels as $key => $level)

            @php
                $unlocked = in_array($key, $milestones);
                $progress = min(($currentVolume / $level['amount']) * 100, 100);
            @endphp

            <div class="halpha-relative halpha-rounded-xl halpha-p-3 halpha-border halpha-transition halpha-duration-300
                {{ $unlocked 
                    ? 'halpha-bg-gradient-to-br halpha-from-green-500/10 halpha-to-emerald-500/10 halpha-border-green-400/30 halpha-shadow-[0_0_25px_rgba(34,197,94,0.2)]' 
                    : 'halpha-bg-gray-900 halpha-border-white/5' }}">

                {{-- glow --}}
                @if($unlocked)
                    <div class="halpha-absolute halpha-inset-0 halpha-rounded-xl halpha-bg-green-400/5 blur-xl"></div>
                @endif

                <div class="halpha-relative halpha-space-y-2 text-center">

                    <p class="halpha-text-lg">{{ $level['icon'] }}</p>

                    <p class="halpha-text-white halpha-text-xs font-semibold">
                        {{ $level['label'] }}
                    </p>

                    <p class="halpha-text-[10px] halpha-text-gray-400">
                        {{ $level['display'] }}
                    </p>

                    {{-- mini progress --}}
                    <div class="halpha-w-full halpha-h-1 halpha-bg-gray-800 halpha-rounded-full overflow-hidden">
                        <div class="halpha-h-full halpha-bg-green-400"
                             style="width: {{ $progress }}%">
                        </div>
                    </div>

                    @if($unlocked)
                        <p class="halpha-text-green-400 halpha-text-[10px] font-semibold">
                            ✓ Achieved
                        </p>
                    @else
                        <p class="halpha-text-gray-500 halpha-text-[10px]">
                            {{ number_format($progress, 0) }}% complete
                        </p>
                    @endif

                </div>

            </div>

        @endforeach

    </div>

    {{-- FOOTER --}}
    <div class="halpha-text-[11px] halpha-text-gray-500">
        Milestones are cumulative — each level unlocks additional rewards and leadership recognition.
    </div>

</div>