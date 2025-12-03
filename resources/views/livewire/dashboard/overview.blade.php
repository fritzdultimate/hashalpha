<div class="halpha-flex halpha-flex-col halpha-gap-5">

    <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 lg:halpha-grid-cols-2 halpha-gap-5">
        <div class="halpha-bg-card-bg halpha-rounded halpha-border halpha-border-white/5">
            <div class="halpha-flex halpha-justify-between halpha-gap-2">
                <div class="halpha-flex halpha-flex-col halpha-gap-2 halpha-p-4">
                    <h6 class="halpha-text-muted">Total Balance</h6>

                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <h4 class="halpha-text-xl halpha-font-semibold halpha-text-accent halpha-font-sans">
                            $94,589.34
                        </h4>
                    </div>
                </div>

                <div class="halpha-flex halpha-flex-col halpha-gap-2 halpha-p-4 halpha-items-end">
                    <h6 class="halpha-text-muted">Daily Est. Reward</h6>

                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <h4 class="halpha-text-xl halpha-font-semibold halpha-text-accent halpha-font-sans">
                            $108.25
                        </h4>
                    </div>
                </div>
            </div>
            <div id="deposit-chart" style="height:120px;"></div>
        </div>

        <x-dashboard.stat title="Total Earned" value="$8,250" delta="2.32%">
            <div id="daily-earnings"></div>
        </x-dashboard.stat>
    </div>


    <section
        class="halpha-grid halpha-grid-cols-1 sm:halpha-grid-cols-2 md:halpha-grid-cols-3 lg:halpha-grid-cols-3 halpha-gap-5">
        <x-dashboard.stat title="Referral Bonus" value="$83,250" delta="22.32%">
            <div id="referral-bonus"></div>
        </x-dashboard.stat>

        <x-dashboard.stat title="Team Performance" value="$833,250" delta="22.32%">
            <div id="team-performance-bonus"></div>
        </x-dashboard.stat>
    </section>

    <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-5">
        <div class="halpha-grid halpha-grid-cols-2">
            <div
                class="halpha-bg-card-bg halpha-rounded-l halpha-border halpha-border-white/5 halpha-p-4 halpha-flex halpha-flex-col halpha-items-center halpha-justify-center halpha-shadow-[0_0_2px_rgba(0,255,255,0.50)]">
                <h6 class="halpha-text-muted">ETH Staked</h6>
                <span class="count-up" data-value="12.85" data-suffix=" ETH">12.85 ETH</span>
            </div>

            <div
                class="halpha-bg-card-bg halpha-rounded-r halpha-border halpha-border-white/5 halpha-p-4 halpha-flex halpha-flex-col halpha-items-center halpha-justify-center halpha-shadow-[0_0_2px_rgba(0,255,255,0.50)]">
                <h6 class="halpha-text-muted">Uptime</h6>
                <span class="count-up" data-value="99.98" data-suffix="%">99.98%</span>
            </div>
        </div>

        <div class="halpha-grid halpha-grid-cols-2">
            <div
                class="halpha-bg-card-bg halpha-rounded-l halpha-border halpha-border-white/5 halpha-p-4 halpha-flex halpha-flex-col halpha-items-center halpha-justify-center halpha-shadow-[0_0_2px_rgba(0,255,255,0.50)]">
                <h6 class="halpha-text-muted">Active Nodes</h6>
                <span class="count-up" data-value="128">128</span>
            </div>

            <div
                class="halpha-bg-card-bg halpha-rounded-r halpha-border halpha-border-white/5 halpha-p-4 halpha-flex halpha-flex-col halpha-items-center halpha-justify-center halpha-shadow-[0_0_2px_rgba(0,255,255,0.50)]">
                <h6 class="halpha-text-muted">Rank</h6>
                <span>Silver</span>
            </div>
        </div>
    </div>

    <livewire:dashboard.earnings-chart />

    <div class="halpha-grid halpha-gap-4 halpha-grid-cols-2 lg:halpha-grid-cols-4">
        <!-- Deposit Button -->
        <button
            class="halpha-relative halpha-w-full halpha-py-2 md:halpha-py-4 halpha-rounded halpha-shadow-lg halpha-transition-all halpha-font-semibold halpha-text-surface
        halpha-bg-gradient-to-r halpha-from-[#0ea5a4] halpha-to-[#22d3ee] hover:halpha-shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-accent-2">
            <div class="halpha-flex halpha-items-center halpha-justify-center halpha-gap-2">
                <x-fas-plus class="halpha-w-4 halpha-h-4" />
                Deposit
            </div>
        </button>

        <!-- Stake Button -->
        <button
            class="halpha-relative halpha-w-full halpha-py-2 md:halpha-py-4 halpha-rounded halpha-shadow-lg halpha-transition-all halpha-font-semibold halpha-text-surface
        halpha-bg-gradient-to-r halpha-from-[#10b981] halpha-to-[#34d399] hover:halpha-shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-success">
            <div class="halpha-flex halpha-items-center halpha-justify-center halpha-gap-2">
                <x-fas-coins class="halpha-w-4 halpha-h-4" />
                Stake
            </div>
        </button>

        <!-- Withdraw Button -->
        <button
            class="halpha-relative halpha-w-full halpha-py-4 halpha-rounded halpha-shadow-lg halpha-transition-all halpha-font-semibold halpha-text-surface
        halpha-bg-gradient-to-r halpha-from-[#ef4444] halpha-to-[#f87171] hover:halpha-shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-danger halpha-hidden md:halpha-block">
            <div class="halpha-flex halpha-items-center halpha-justify-center halpha-gap-2">
                <x-fas-arrow-down class="halpha-w-4 halpha-h-4" />
                Withdraw
            </div>
        </button>

        <!-- Referrals Button -->
        <button
            class="halpha-relative halpha-w-full halpha-py-2 md:halpha-py-4 halpha-rounded halpha-shadow-lg halpha-transition-all halpha-font-semibold halpha-text-surface
        halpha-bg-gradient-to-r halpha-from-[#0284C7] halpha-to-[#0ea5a4] hover:halpha-shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-accent-2 halpha-hidden md:halpha-block">
            <div class="halpha-flex halpha-items-center halpha-justify-center halpha-gap-2">
                <x-fas-users class="halpha-w-4 halpha-h-4" />
                Referrals
            </div>
        </button>
    </div>



    <section>
        <livewire:dashboard.latest-transactions-table />
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    (function () {
        const depositChartEl = document.getElementById('deposit-chart');
        if (!depositChartEl) return;

        const options = {
            series: [{ name: 'Deposits', data: [1200, 1800, 1300, 1600, 2200, 2500, 1900, 2700, 2300, 3100, 2900, 3300] }],
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
        var options = {
            series: [{
                name: 'Earnings',
                data: [45, 60, 80, 55, 70, 90, 100, 120, 130, 125, 110, 95]
            }],
            chart: {
                type: 'bar',
                height: 120,
                sparkline: { enabled: true },
            },
            plotOptions: {
                bar: {
                    columnWidth: '70%',
                    borderRadius: 3,
                }
            },
            colors: ['#3b82f6'],
            tooltip: {
                enabled: true,
                theme: 'dark',
                y: {
                    formatter: (val) => `$${val}`,
                },
                x: { show: false }
            }
        };

        var chart = new ApexCharts(document.querySelector("#daily-earnings"), options);
        chart.render();
    })();


    (function () {
        const depositChartEl = document.getElementById('referral-bonus');
        if (!depositChartEl) return;

        const options = {
            series: [{ name: 'Referral Bonus', data: [1200, 1800, 1300, 1600, 2200, 2500, 1900, 2700, 2300, 3100, 2900, 3300] }],
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
