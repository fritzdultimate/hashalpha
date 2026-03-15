<div class="halpha-space-y-6">

    {{-- ============================= --}}
    {{-- 🚀 SPRINT 2 PREPARATION --}}
    {{-- ============================= --}}

    <div class="halpha-card halpha-bg-card-soft halpha-border halpha-border-accent-3 halpha-rounded-xl halpha-p-6 halpha-space-y-8">

        {{-- HEADER --}}
        <div class="halpha-text-center halpha-space-y-2">

            <h2 class="halpha-text-2xl halpha-font-bold halpha-text-accent-2">
                🚀 Sprint 2 — Capital Expansion
            </h2>

            <p class="halpha-text-sm halpha-text-gray-400 max-w-xl halpha-mx-auto">
                The next phase of the HashAlpha growth cycle begins soon.
            </p>

            <p class="halpha-text-xs halpha-text-gray-500">
                Sprint 2 is designed to expand capital activation, deepen team networks, and reward strategic leadership across the ecosystem.
            </p>

        </div>


        {{-- LAUNCH DATE --}}
        <div class="halpha-text-center halpha-space-y-2">

            <p class="halpha-text-xs halpha-text-gray-400 uppercase tracking-wide">
                Sprint 2 Launch
            </p>

            <p class="halpha-text-lg halpha-font-bold halpha-text-white">
                📅 March 18, 2026
            </p>

        </div>


        {{-- COUNTDOWN --}}
        <div
            x-data="{
                end: new Date('2026-03-18T00:00:00').getTime(),
                now: new Date().getTime(),
                init() {
                    setInterval(() => {
                        this.now = new Date().getTime()
                    },1000)
                },
                get remaining() {
                    let diff = this.end - this.now

                    if(diff <= 0) return 'Sprint 2 is live'

                    let d = Math.floor(diff/(1000*60*60*24))
                    let h = Math.floor((diff%(1000*60*60*24))/(1000*60*60))
                    let m = Math.floor((diff%(1000*60*60))/(1000*60))
                    let s = Math.floor((diff % (1000*60)) / 1000)

                    let parts = []

                    if (d > 0) parts.push(`${d}d`)
                    if (h > 0) parts.push(`${h}h`)
                    if (m > 0) parts.push(`${m}m`)
                    if (s > 0) parts.push(`${s}s`)

                    return parts.join(' ')
                }
            }"
            class="halpha-text-center halpha-space-y-1"
        >

            <p class="halpha-text-xs halpha-text-gray-400">
                ⏳ Countdown
            </p>

            <p class="halpha-text-lg halpha-font-bold halpha-text-accent-2" x-text="remaining"></p>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- 🏆 SPRINT 1 RECAP --}}
    {{-- ============================= --}}

    <div class="halpha-card halpha-bg-card-soft halpha-border halpha-border-accent-3 halpha-rounded-xl halpha-p-6 halpha-space-y-5">

        <h2 class="halpha-text-lg halpha-font-bold halpha-text-white">
            🏆 Sprint 1 Results
        </h2>

        <p class="halpha-text-sm halpha-text-gray-400">
            Sprint 1 established strong momentum across the HashAlpha network.
        </p>

        <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-4 halpha-gap-3 halpha-text-sm">

            <div class="halpha-bg-gray-900/40 halpha-rounded-lg halpha-p-3 halpha-text-center">
                <p class="halpha-text-lg halpha-font-bold halpha-text-accent-2">250+</p>
                <p class="halpha-text-xs halpha-text-gray-400">New Activations</p>
            </div>

            <div class="halpha-bg-gray-900/40 halpha-rounded-lg halpha-p-3 halpha-text-center">
                <p class="halpha-text-lg halpha-font-bold halpha-text-accent-2">3</p>
                <p class="halpha-text-xs halpha-text-gray-400">Competition Categories</p>
            </div>

            <div class="halpha-bg-gray-900/40 halpha-rounded-lg halpha-p-3 halpha-text-center">
                <p class="halpha-text-lg halpha-font-bold halpha-text-accent-2">9</p>
                <p class="halpha-text-xs halpha-text-gray-400">Recognized Leaders</p>
            </div>

            <div class="halpha-bg-gray-900/40 halpha-rounded-lg halpha-p-3 halpha-text-center">
                <p class="halpha-text-lg halpha-font-bold halpha-text-accent-2">1</p>
                <p class="halpha-text-xs halpha-text-gray-400">Bali Qualification</p>
            </div>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- 🚀 SPRINT 2 COMPETITIONS --}}
    {{-- ============================= --}}

    <div class="halpha-card halpha-bg-card-soft halpha-border halpha-border-accent-3 halpha-rounded-xl halpha-p-6 halpha-space-y-6">

        <h2 class="halpha-text-lg halpha-font-bold halpha-text-white">
            🚀 Sprint 2 Competition Categories
        </h2>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-4">

            <div class="halpha-bg-gray-900/40 halpha-rounded-xl halpha-p-4">
                <p class="halpha-font-semibold halpha-text-white">🏆 Total Team Volume Champion</p>
                <p class="halpha-text-xs halpha-text-gray-400">
                    Highest cumulative team volume across all levels.
                </p>
            </div>

            <div class="halpha-bg-gray-900/40 halpha-rounded-xl halpha-p-4">
                <p class="halpha-font-semibold halpha-text-white">💰 Capital Activation Leader</p>
                <p class="halpha-text-xs halpha-text-gray-400">
                    Highest Level 1 volume activated.
                </p>
            </div>

            <div class="halpha-bg-gray-900/40 halpha-rounded-xl halpha-p-4">
                <p class="halpha-font-semibold halpha-text-white">💎 Strategic Capital Leader</p>
                <p class="halpha-text-xs halpha-text-gray-400">
                    Highest personal capital staked.
                </p>
            </div>

            <div class="halpha-bg-gray-900/40 halpha-rounded-xl halpha-p-4">
                <p class="halpha-font-semibold halpha-text-white">⚡ Activation Power Leader</p>
                <p class="halpha-text-xs halpha-text-gray-400">
                    Most $1,000+ Level 1 activations.
                </p>
            </div>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- 🌴 BALI EXPERIENCE --}}
    {{-- ============================= --}}

    <div class="halpha-card halpha-bg-card-soft halpha-border halpha-border-accent-3 halpha-rounded-xl halpha-p-6 halpha-space-y-4">

        <h2 class="halpha-text-lg halpha-font-bold halpha-text-white">
            🌴 Bali Leadership Experience
        </h2>

        <p class="halpha-text-sm halpha-text-gray-400">
            Top Sprint 2 performers will qualify for the HashAlpha Leadership Experience in Bali.
        </p>

        <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-4 halpha-gap-3 halpha-text-sm">

            <div class="halpha-bg-gray-900/40 halpha-rounded-lg halpha-p-3 halpha-text-center">✈️ Flights</div>
            <div class="halpha-bg-gray-900/40 halpha-rounded-lg halpha-p-3 halpha-text-center">🏨 Luxury Hotel</div>
            <div class="halpha-bg-gray-900/40 halpha-rounded-lg halpha-p-3 halpha-text-center">💰 Cash Prizes</div>
            <div class="halpha-bg-gray-900/40 halpha-rounded-lg halpha-p-3 halpha-text-center">🎤 Leadership Recognition</div>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- 📈 STRATEGY --}}
    {{-- ============================= --}}

    <div class="halpha-card halpha-bg-card-soft halpha-border halpha-border-accent-3 halpha-rounded-xl halpha-p-6 halpha-space-y-3">

        <h2 class="halpha-text-lg halpha-font-bold halpha-text-white">
            📈 Winning Strategy
        </h2>

        <ul class="halpha-text-sm halpha-text-gray-400 halpha-space-y-1">

            <li>• Early activation momentum</li>
            <li>• Strong Level 1 volume generation</li>
            <li>• Consistent team duplication</li>
            <li>• Deep network engagement</li>

        </ul>

        <p class="halpha-text-xs halpha-text-gray-500">
            Momentum in the first days of the sprint often determines the final outcome.
        </p>

    </div>


    {{-- ============================= --}}
    {{-- ⚡ CALL TO ACTION --}}
    {{-- ============================= --}}

    <div class="halpha-card halpha-bg-accent-2/10 halpha-border halpha-border-accent-3 halpha-rounded-xl halpha-p-6 halpha-space-y-4">

        <h2 class="halpha-text-lg halpha-font-bold halpha-text-white">
            ⚡ Prepare Your Team
        </h2>

        <p class="halpha-text-sm halpha-text-gray-400">
            Sprint 2 begins March 18. Now is the time to align your team and prepare for activation.
        </p>

        <ul class="halpha-text-sm halpha-text-gray-300 halpha-space-y-1">

            <li>• Align your team</li>
            <li>• Prepare activations</li>
            <li>• Position your network</li>

        </ul>

    </div>


    {{-- ============================= --}}
    {{-- 🔥 LEADERS TO WATCH --}}
    {{-- ============================= --}}

    <div class="halpha-card halpha-bg-card-soft halpha-border halpha-border-accent-3 halpha-rounded-xl halpha-p-6 halpha-space-y-5">

        <div class="halpha-text-center halpha-space-y-1">
            <h2 class="halpha-text-lg halpha-font-bold halpha-text-white">
                🔥 Leaders to Watch
            </h2>

            <p class="halpha-text-xs halpha-text-gray-400">
                Top performers from Sprint 1 expected to compete in Sprint 2
            </p>
        </div>

        <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-5 halpha-gap-4">

            @php
                $watch = ['eotynaowe','richard','christinabarger','serroofing','tnrbateman'];
            @endphp

            @foreach($watch as $leader)

            @php
                $colors = ['halpha-bg-indigo-500','halpha-bg-pink-500','halpha-bg-green-500','halpha-bg-yellow-500','halpha-bg-blue-500','halpha-bg-purple-500'];
                $color = $colors[crc32($leader) % count($colors)];
                $initial = strtoupper(substr($leader,0,1));
            @endphp

            <div class="halpha-relative halpha-group halpha-bg-gray-900/40 halpha-border halpha-border-gray-700 halpha-rounded-xl halpha-p-4 halpha-text-center halpha-space-y-2 halpha-transition halpha-duration-300 hover:halpha-border-accent-3 hover:halpha-scale-[1.04]">

                {{-- glow --}}
                <div class="halpha-absolute halpha-inset-0 halpha-rounded-xl halpha-opacity-0 group-hover:halpha-opacity-100 halpha-transition halpha-duration-300 halpha-bg-accent-2/5"></div>

                {{-- avatar --}}
                <div class="halpha-relative halpha-w-12 halpha-h-12 halpha-mx-auto halpha-rounded-full {{ $color }} halpha-flex halpha-items-center halpha-justify-center halpha-text-white halpha-font-bold halpha-shadow">

                    {{ $initial }}

                    {{-- small flame badge --}}
                    <span class="halpha-absolute -halpha-top-1 -halpha-right-1 halpha-text-xs">
                        🔥
                    </span>

                </div>

                {{-- name --}}
                <p class="halpha-text-sm halpha-text-white halpha-font-semibold">
                    {{ mask($leader) }}
                </p>

                {{-- sprint badge --}}
                <p class="halpha-text-[10px] halpha-text-gray-400">
                    Sprint 1 Leader
                </p>

            </div>

            @endforeach

        </div>

    </div>

</div>
