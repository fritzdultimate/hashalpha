{{-- ============================= --}}
{{-- 🚀 SPRINT 2 PREPARATION --}}
{{-- ============================= --}}

<div
    class="halpha-card halpha-bg-card-soft halpha-border halpha-border-accent-3 halpha-rounded-xl halpha-p-6 halpha-space-y-8">

    {{-- HEADER --}}
    <div class="halpha-text-center halpha-space-y-2">

        <h2 class="halpha-text-2xl halpha-font-bold halpha-text-accent-2">
            🚀 Sprint 2 — Capital Expansion
        </h2>

        <p class="halpha-text-sm halpha-text-gray-400 max-w-xl halpha-mx-auto">
            The next phase of the HashAlpha growth cycle begins soon.
        </p>

        <p class="halpha-text-xs halpha-text-gray-500">
            Sprint 2 is designed to expand capital activation, deepen team networks, and reward strategic leadership
            across the ecosystem.
        </p>

    </div>


    {{-- LAUNCH DATE --}}
    <div class="halpha-text-center halpha-space-y-2">

        <p class="halpha-text-xs halpha-text-gray-400 uppercase tracking-wide">
            Sprint 2 Launch
        </p>

        <p class="halpha-text-lg halpha-font-bold halpha-text-white">
            📅 March 20, 2026
        </p>

    </div>


    {{-- COUNTDOWN --}}
    <div x-data="{
                end: new Date('2026-03-20T00:00:00').getTime(),
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
            }" class="halpha-text-center halpha-space-y-1">

        <p class="halpha-text-xs halpha-text-gray-400">
            ⏳ Countdown
        </p>

        <p class="halpha-text-lg halpha-font-bold halpha-text-accent-2" x-text="remaining"></p>

    </div>

</div>