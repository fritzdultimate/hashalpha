@php
    $currentTeamVolume = $currentTeamVolume ?? 0;
    $currentPersonalVolume = $currentPersonalVolume ?? 0;

    $targets = [
        'strategic_capital' => 50000,
        'network_builder' => 150000,
    ];

    $sc = $qualifications['strategic_capital'] ?? null;
    $nb = $qualifications['network_builder'] ?? null;
@endphp

<div class="halpha-card halpha-p-4 md:halpha-p-5 halpha-rounded-xl halpha-bg-gradient-to-br halpha-from-[#020617] halpha-to-[#0f172a] halpha-border halpha-border-white/5 halpha-space-y-5">

    {{-- HEADER --}}
    <div class="halpha-space-y-1">
        <p class="halpha-text-[11px] halpha-text-gray-400 uppercase tracking-wide">
            Qualification Paths
        </p>

        <h3 class="halpha-text-white halpha-font-bold halpha-text-sm md:halpha-text-base">
            Bali Leadership Experience Access
        </h3>

        <p class="halpha-text-gray-400 halpha-text-xs md:halpha-text-sm">
            Reach elite thresholds to unlock exclusive travel, recognition, and leadership access.
        </p>
    </div>

    {{-- PATHS --}}
    <div class="halpha-space-y-4">

        {{-- 💎 STRATEGIC CAPITAL --}}
        @php
            $scProgress = min(($currentPersonalVolume / $targets['strategic_capital']) * 100, 100);
            $scRemaining = max($targets['strategic_capital'] - $currentPersonalVolume, 0);
        @endphp

        <div class="halpha-rounded-xl halpha-p-3 halpha-border halpha-transition
            {{ $sc 
                ? 'halpha-bg-gradient-to-br halpha-from-green-500/10 halpha-to-emerald-500/10 halpha-border-green-400/30 halpha-shadow-[0_0_25px_rgba(34,197,94,0.2)]'
                : 'halpha-bg-gray-900 halpha-border-white/5' }}"
            x-data="{ open: false }"
        >

            <div class="halpha-flex halpha-justify-between halpha-items-start">

                <div class="halpha-space-y-1">
                    <p class="halpha-text-white halpha-text-xs font-semibold">
                        💎 Strategic Capital Leader
                    </p>

                    <p class="halpha-text-[10px] halpha-text-gray-400">
                        Target: $50,000 personal capital
                    </p>
                </div>

                <div class="halpha-flex halpha-items-center halpha-gap-2">
                    <!-- {!! $sc ? '✅' : '❌' !!} -->
                     <span class="halpha-text-sm">{!! $sc ? '✅' : '❌' !!}</span>

                     <button @click="open = !open"
                        class="halpha-text-[10px] halpha-text-green-400 hover:halpha-underline">
                        Rewards
                    </button>
                </div>

            </div>

            {{-- Progress --}}
            <div class="halpha-mt-2 halpha-space-y-1">

                <div class="halpha-w-full halpha-h-1 halpha-bg-gray-800 halpha-rounded-full overflow-hidden">
                    <div class="halpha-h-full halpha-bg-green-400"
                         style="width: {{ $scProgress }}%">
                    </div>
                </div>

                <p class="halpha-text-[10px] halpha-text-gray-400">
                    ${{ number_format($currentPersonalVolume) }} / $50,000
                </p>

                @if(!$sc)
                    <p class="halpha-text-[10px] halpha-text-gray-500">
                        ${{ number_format($scRemaining) }} remaining to qualify
                    </p>
                @endif

                @if($sc)
                    <p class="halpha-text-green-400 halpha-text-[10px] font-semibold">
                        ✓ Qualified — Bali Access Unlocked
                    </p>
                @endif

            </div>

            <div x-show="open" x-transition class="halpha-mt-3 halpha-space-y-1 halpha-text-[10px] halpha-text-gray-300">

                <p>✈️ Economy Flight to Bali</p>
                <p>🏨 5-Star Resort — 3 Nights</p>
                <p>🏝️ Bali Leadership Experience Access</p>
                <p>🎖️ VIP Leadership Seating</p>

            </div>

        </div>

        


        {{-- 🏆 NETWORK BUILDER --}}
        @php
            $nbProgress = min(($currentTeamVolume / $targets['network_builder']) * 100, 100);
            $nbRemaining = max($targets['network_builder'] - $currentTeamVolume, 0);
        @endphp

        <div class="halpha-rounded-xl halpha-p-3 halpha-border halpha-transition
            {{ $nb 
                ? 'halpha-bg-gradient-to-br halpha-from-blue-500/10 halpha-to-indigo-500/10 halpha-border-blue-400/30 halpha-shadow-[0_0_25px_rgba(59,130,246,0.2)]'
                : 'halpha-bg-gray-900 halpha-border-white/5' }}"
            x-data="{ open: false }"
        >

            <div class="halpha-flex halpha-justify-between halpha-items-start">

                <div class="halpha-space-y-1">
                    <p class="halpha-text-white halpha-text-xs font-semibold">
                        🏆 Network Builder
                    </p>

                    <p class="halpha-text-[10px] halpha-text-gray-400">
                        Target: $150,000 team volume
                    </p>
                </div>

                <div class="halpha-text-sm">
                    <!-- {!! $nb ? '✅' : '❌' !!} -->
                     <span class="halpha-text-sm">{!! $nb ? '✅' : '❌' !!}</span>
                    <button @click="open = !open"
                        class="halpha-text-[10px] halpha-text-green-400 hover:halpha-underline">
                        Rewards
                    </button>
                </div>

            </div>

            {{-- Progress --}}
            <div class="halpha-mt-2 halpha-space-y-1">

                <div class="halpha-w-full halpha-h-1 halpha-bg-gray-800 halpha-rounded-full overflow-hidden">
                    <div class="halpha-h-full halpha-bg-blue-400"
                         style="width: {{ $nbProgress }}%">
                    </div>
                </div>

                <p class="halpha-text-[10px] halpha-text-gray-400">
                    ${{ number_format($currentTeamVolume) }} / $150,000
                </p>

                @if(!$nb)
                    <p class="halpha-text-[10px] halpha-text-gray-500">
                        ${{ number_format($nbRemaining) }} remaining to qualify
                    </p>
                @endif

                @if($nb)
                    <p class="halpha-text-blue-400 halpha-text-[10px] font-semibold">
                        ✓ Qualified — Leadership Recognition Secured
                    </p>
                @endif

            </div>

            <div x-show="open" x-transition class="halpha-mt-3 halpha-space-y-1 halpha-text-[10px] halpha-text-gray-300">

                <p>✈️ Economy Flight to Bali</p>
                <p>🏨 5-Star Resort — 3 Nights</p>
                <p>🏝️ Bali Leadership Experience Access</p>
                <p>🏆 Leadership Recognition</p>

            </div>

        </div>

    </div>

    {{-- 🏝️ EXPERIENCE --}}
    <div class="halpha-rounded-xl halpha-p-3 halpha-bg-gradient-to-r halpha-from-yellow-400/10 halpha-to-orange-500/10 halpha-border halpha-border-yellow-400/20">

        <p class="halpha-text-yellow-300 halpha-text-xs font-semibold">
            🏝️ Bali Leadership Experience
        </p>

        <p class="halpha-text-[11px] halpha-text-gray-400 mt-1">
            Executive sessions, recognition ceremonies, and private networking with top-performing leaders.
        </p>

    </div>

    {{-- FOOTER --}}
    <div class="halpha-text-[11px] halpha-text-gray-500">
        Qualification rewards do not override championship rankings. The highest reward tier will be applied where multiple paths are achieved.
    </div>

</div>