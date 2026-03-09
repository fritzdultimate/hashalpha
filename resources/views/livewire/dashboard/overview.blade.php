<div class="halpha-flex halpha-flex-col halpha-gap-5">

    <style>
        @keyframes ticker {
            0% {
                transform: translateX(0%);
            }
            100% {
                transform: translateX(-100%);
            }
        }
    </style>

    <div class="halpha-w-full halpha-rounded-xl halpha-border halpha-border-amber-400/20 halpha-bg-gradient-to-r halpha-from-amber-500/10 halpha-to-yellow-400/5 halpha-p-4 halpha-flexx halpha-items-center halpha-justify-between halpha-gap-4 halpha-flex-wrap halpha-hidden">

        {{-- LEFT --}}
        <div class="halpha-flex halpha-items-start halpha-gap-3 halpha-max-w-full">

            <div class="halpha-text-xl halpha-shrink-0">
                🚨
            </div>

            <div class="halpha-space-y-1">
                <p class="halpha-text-sm halpha-font-semibold halpha-text-white">
                    Sprint 1 Verification in Progress
                </p>

                <p class="halpha-text-xs halpha-text-gray-400 halpha-max-w-xl">
                    Sprint 1 has officially closed and the leaderboard is now frozen. Our team is reviewing all activations and qualifying volumes to ensure fair and accurate results.
                </p>

                <p class="halpha-text-xs halpha-text-gray-400">
                    🏆 Winners will be announced on <span class="halpha-text-white halpha-font-medium">March 10, 2026</span>
                </p>

            </div>
        </div>

        {{-- STATUS (RESPONSIVE) --}}
        <div class="halpha-grid halpha-grid-cols-1 sm:halpha-grid-cols-2 lg:halpha-grid-cols-3 halpha-gap-2 halpha-text-xs halpha-w-full lg:halpha-w-auto">

            <div class="halpha-bg-black/30 halpha-border halpha-border-gray-700 halpha-rounded-lg halpha-px-3 halpha-py-2 halpha-flex halpha-items-center halpha-gap-2">
                <span>🔒</span>
                <span class="halpha-text-gray-300">Leaderboard Frozen</span>
            </div>

            <div class="halpha-bg-black/30 halpha-border halpha-border-gray-700 halpha-rounded-lg halpha-px-3 halpha-py-2 halpha-flex halpha-items-center halpha-gap-2">
                <span>🔍</span>
                <span class="halpha-text-gray-300">Results Under Review</span>
            </div>

            <div class="halpha-bg-black/30 halpha-border halpha-border-gray-700 halpha-rounded-lg halpha-px-3 halpha-py-2 halpha-flex halpha-items-center halpha-gap-2">
                <span>📅</span>
                <span class="halpha-text-gray-300">March 10 Announcement</span>
            </div>

        </div>

    </div>



    <x-dashboard.total-balance-card :balance="$balance" :totalEarned="$totalEarned" :chartData="$chartData" :dailyEstimatedReward="$dailyEstimatedReward" :totalEarnedDelta="$totalEarnedDelta" :earningchartData="$earningchartData" :totalReferralBonus="$totalReferralBonus" :totalReferralDelta="$totalReferralDelta" />


    <section
        class="halpha-grid halpha-grid-cols-1 sm:halpha-grid-cols-2 md:halpha-grid-cols-3 lg:halpha-grid-cols-3 halpha-gap-5">
        <x-dashboard.stat :show="false" title="Referral Bonus" value="${{ number_format($totalReferralBonus, 2) }}" delta="22.32%">
            <div id="referral-bonus"></div>
        </x-dashboard.stat>

        <x-dashboard.stat :show="false" title="Team Performance" value="$833,250" delta="22.32%">
            <div id="team-performance-bonus"></div>
        </x-dashboard.stat>
    </section>

    <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-5">
        <div class="halpha-grid halpha-grid-cols-2">
            <div
                class="halpha-bg-card-bg halpha-rounded-l halpha-border halpha-border-white/5 halpha-p-4 halpha-flex halpha-flex-col halpha-items-center halpha-justify-center halpha-shadow-[0_0_2px_rgba(0,255,255,0.50)]">
                <h6 class="halpha-text-muted">Blocks Validated</h6>
                <span class="count-up" data-value="{{ $validatedBlocks }}">--</span>
            </div>

            <div
                class="halpha-bg-card-bg halpha-rounded-r halpha-border halpha-border-white/5 halpha-p-4 halpha-flex halpha-flex-col halpha-items-center halpha-justify-center halpha-shadow-[0_0_2px_rgba(0,255,255,0.50)]">
                <h6 class="halpha-text-muted">Plan Type</h6>
                <span class="">Staking</span>
            </div>
        </div>

        <div class="halpha-grid halpha-grid-cols-2">
            <div
                class="halpha-bg-card-bg halpha-rounded-l halpha-border halpha-border-white/5 halpha-p-4 halpha-flex halpha-flex-col halpha-items-center halpha-justify-center halpha-shadow-[0_0_2px_rgba(0,255,255,0.50)]">
                <h6 class="halpha-text-muted">Network Status</h6>
                <span >Active</span>
            </div>

            <div
                class="halpha-bg-card-bg halpha-rounded-r halpha-border halpha-border-white/5 halpha-p-4 halpha-flex halpha-flex-col halpha-items-center halpha-justify-center halpha-shadow-[0_0_2px_rgba(0,255,255,0.50)]">
                <h6 class="halpha-text-muted">Rank</h6>
                <span>{{ $rank }}</span>
            </div>
        </div>
    </div>

    <livewire:dashboard.earnings-chart />

    <div class="halpha-grid halpha-gap-4 halpha-grid-cols-2 lg:halpha-grid-cols-4">
        <!-- Deposit Button -->
        <a
            href="{{ route('deposit.create') }}"
            class="halpha-relative halpha-w-full halpha-py-2 md:halpha-py-4 halpha-rounded halpha-shadow-lg halpha-transition-all halpha-font-semibold halpha-text-surface
        halpha-bg-gradient-to-r halpha-from-[#0ea5a4] halpha-to-[#22d3ee] hover:halpha-shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-accent-2">
            <div class="halpha-flex halpha-items-center halpha-justify-center halpha-gap-2">
                <x-fas-plus class="halpha-w-4 halpha-h-4" />
                Deposit
            </div>
        </a>

        <!-- Stake Button -->
        <a
            href="{{ route('staking.stake') }}"
            class="halpha-relative halpha-w-full halpha-py-2 md:halpha-py-4 halpha-rounded halpha-shadow-lg halpha-transition-all halpha-font-semibold halpha-text-surface
        halpha-bg-gradient-to-r halpha-from-[#10b981] halpha-to-[#34d399] hover:halpha-shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-success">
            <div class="halpha-flex halpha-items-center halpha-justify-center halpha-gap-2">
                <x-fas-coins class="halpha-w-4 halpha-h-4" />
                Stake
            </div>
        </a>

        <!-- Withdraw Button -->
        <a
            href="{{ route('account.withdrawal') }}"
            class="halpha-relative halpha-w-full halpha-py-4 halpha-rounded halpha-shadow-lg halpha-transition-all halpha-font-semibold halpha-text-surface
        halpha-bg-gradient-to-r halpha-from-[#ef4444] halpha-to-[#f87171] hover:halpha-shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-danger halpha-hidden md:halpha-block">
            <div class="halpha-flex halpha-items-center halpha-justify-center halpha-gap-2">
                <x-fas-arrow-down class="halpha-w-4 halpha-h-4" />
                Withdraw
            </div>
        </a>

        <!-- Referrals Button -->
        <a
            href="{{ route('referral.bonus') }}"
            class="halpha-relative halpha-w-full halpha-py-2 md:halpha-py-4 halpha-rounded halpha-shadow-lg halpha-transition-all halpha-font-semibold halpha-text-surface
        halpha-bg-gradient-to-r halpha-from-[#0284C7] halpha-to-[#0ea5a4] hover:halpha-shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-accent-2 halpha-hidden md:halpha-block">
            <div class="halpha-flex halpha-items-center halpha-justify-center halpha-gap-2">
                <x-fas-users class="halpha-w-4 halpha-h-4" />
                Referrals
            </div>
    </a>
    </div>



    <section>
        <livewire:dashboard.latest-transactions-table />
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

    (function () {
        window.referralRewardschartData = @json($referralRewardschartData);
        const depositChartEl = document.getElementById('referral-bonus');
        if (!depositChartEl) return;

        if(!window.referralRewardschartData.length) {
            depositChartEl.innerHTML = '<p class="halpha-text-xs halpha-text-muted halpha-p-4">No bonus earned yet</p>';
            return;
        }

        const options = {
            series: [{ name: 'Referral Bonus', data: window.referralRewardschartData ?? [] }],
            chart: { type: 'area', height: 120, sparkline: { enabled: true } },
            stroke: { curve: 'smooth', width: 2 },
            fill: { type: 'gradient', gradient: { opacityFrom: 0.45, opacityTo: 0.05 } },
            colors: ['#3b82f6'],
            tooltip: {
                enabled: true,
                theme: false,
                style: {
                    fontSize: '12px',
                    fontFamily: 'Public Sans, sans-serif'
                },
                y: { formatter: v => '$' + Number(v).toLocaleString() },
                x: { show: false },
                marker: { show: false }
            }
        };

        new ApexCharts(depositChartEl, options).render();
    })();

    (function () {
        const depositChartEl = document.getElementById('team-performance-bonus');
        if (!depositChartEl) return;

        const data = [300, 450, 500, 400, 600, 550, 700, 650, 600, 750, 800, 900];
        const options = {
            series: [{ name: 'Team Performance', data }],
            chart: { type: 'bar', sparkline: { enabled: true }, height: 120 },
            plotOptions: { bar: { columnWidth: '70%', borderRadius: 2, distributed: true } },
            colors: data.map(v => v >= 0 ? '#10b981' : '#ef4444')
        };

        new ApexCharts(depositChartEl, options).render();
    })();
</script>
