<div class="halpha-space-y-5">

    {{-- 🏆 HEADER --}}
    <div class="halpha-card halpha-p-4 halpha-rounded-xl halpha-bg-gradient-to-r halpha-from-[#0f172a] halpha-to-[#020617] halpha-border halpha-border-white/5">

        <p class="halpha-text-[11px] halpha-text-gray-400 halpha-uppercase halpha-tracking-wide">
            Sprint 2 Championship
        </p>

        <h2 class="halpha-text-white halpha-font-bold halpha-text-lg md:halpha-text-xl">
            Leadership Competition & Qualification System
        </h2>

        <p class="halpha-text-gray-400 halpha-text-xs md:halpha-text-sm halpha-mt-1">
            Compete across multiple leadership pathways — championship rankings, milestone achievements, and elite qualification access.
        </p>
    </div>


    {{-- 📘 CATEGORY DESCRIPTION --}}
    <div class="halpha-card halpha-bg-card-soft halpha-p-4 md:halpha-p-5 halpha-rounded-xl halpha-space-y-5 halpha-text-[12px] md:halpha-text-sm halpha-text-gray-400 halpha-border halpha-border-white/5">

        {{-- 🥇 TEAM VOLUME --}}
        @if (strtolower($category->type) === 'team_volume')
            <div class="halpha-flex halpha-gap-4">

                <div class="halpha-text-yellow-400 halpha-text-xl">👑</div>

                <div class="halpha-space-y-2">
                    <p class="halpha-text-white halpha-font-semibold halpha-text-sm md:halpha-text-base">
                        Total Team Volume Champion (Global Crown)
                    </p>

                    <p>
                        This is the <span class="halpha-text-gray-200">flagship leaderboard</span> of Sprint 2.
                        Rankings are based on <span class="halpha-text-gray-200">total team volume across all levels</span>.
                    </p>

                    <p>
                        The leader who drives the highest network expansion earns the title of
                        <span class="halpha-text-yellow-400 halpha-font-semibold">Sprint 2 Global Champion</span>.
                    </p>

                    <div class="halpha-flex halpha-flex-wrap halpha-gap-2 halpha-mt-2">
                        <span class="halpha-badge halpha-bg-yellow-400/10 halpha-text-yellow-300">🏝️ Bali Experience</span>
                        <span class="halpha-badge halpha-bg-green-400/10 halpha-text-green-300">$5,000 Reward</span>
                        <span class="halpha-badge halpha-bg-blue-400/10 halpha-text-blue-300">VIP Recognition</span>
                    </div>
                </div>

            </div>
        @endif


        {{-- 💰 LEVEL 1 VOLUME --}}
        @if (strtolower($category->type) === 'level_1_volume')
            <div class="halpha-flex halpha-gap-4">

                <div class="halpha-text-green-400 halpha-text-xl">💰</div>

                <div class="halpha-space-y-2">
                    <p class="halpha-text-white halpha-font-semibold halpha-text-sm md:text-base">
                        Capital Activation Leader (Level 1)
                    </p>

                    <p>
                        Rankings are based on <span class="halpha-text-gray-200">direct team (Level 1) capital activation</span>.
                    </p>

                    <p>
                        This category rewards leaders who can effectively
                        <span class="halpha-text-gray-200">onboard and activate strong direct participants</span>.
                    </p>

                    <div class="halpha-flex halpha-flex-wrap halpha-gap-2 halpha-mt-2">
                        <span class="halpha-badge halpha-bg-green-400/10 halpha-text-green-300">$2,000+ Rewards</span>
                        <span class="halpha-badge halpha-bg-purple-400/10 halpha-text-purple-300">Builder Recognition</span>
                    </div>
                </div>

            </div>
        @endif


        {{-- 💎 PERSONAL VOLUME --}}
        @if (strtolower($category->type) === 'personal_volume')
            <div class="halpha-flex halpha-gap-4">

                <div class="halpha-text-purple-400 halpha-text-xl">💎</div>

                <div class="halpha-space-y-2">
                    <p class="halpha-text-white halpha-font-semibold halpha-text-sm md:halpha-text-base">
                        Strategic Capital Activation
                    </p>

                    <p>
                        This leaderboard recognizes participants who deploy the
                        <span class="halpha-text-gray-200">highest personal capital</span> during Sprint 2.
                    </p>

                    <p>
                        It reflects <span class="halpha-text-gray-200">conviction, positioning, and strategic execution</span>.
                    </p>

                    <div class="halpha-flex halpha-flex-wrap halpha-gap-2 halpha-mt-2">
                        <span class="halpha-badge halpha-bg-purple-400/10 halpha-text-purple-300">$3,500 Reward</span>
                        <span class="halpha-badge halpha-bg-yellow-400/10 halpha-text-yellow-300">Private Roundtable</span>
                    </div>
                </div>

            </div>
        @endif


        {{-- ⚡ ACTIVATION COUNT --}}
        @if (strtolower($category->type) === 'activation_count')
            <div class="halpha-flex halpha-gap-4">

                <div class="halpha-text-blue-400 halpha-text-xl">⚡</div>

                <div class="halpha-space-y-2">
                    <p class="halpha-text-white halpha-font-semibold halpha-text-sm md:halpha-text-base">
                        $1,000+ Activation Leader
                    </p>

                    <p>
                        Rankings are based on the number of
                        <span class="halpha-text-gray-200">$1,000+ direct activations</span> achieved.
                    </p>

                    <p>
                        This category rewards
                        <span class="halpha-text-gray-200">execution speed and high-value onboarding</span>.
                    </p>

                    <div class="halpha-flex halpha-flex-wrap halpha-gap-2 halpha-mt-2">
                        <span class="halpha-badge halpha-bg-blue-400/10 halpha-text-blue-300">$3,000 Reward</span>
                        <span class="halpha-badge halpha-bg-green-400/10 halpha-text-green-300">Execution Leader</span>
                    </div>
                </div>

            </div>
        @endif

    </div>


    {{-- ⚠️ FOOTER NOTE --}}
    <div class="halpha-text-[11px] halpha-text-gray-500 halpha-text-center md:halpha-text-left">
        Championship rankings determine top rewards. Milestones and qualification paths provide additional recognition but do not override leaderboard positions.
    </div>

</div>