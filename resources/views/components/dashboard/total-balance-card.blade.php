<div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 lg:halpha-grid-cols-2 halpha-gap-5">
    <div class="halpha-bg-card-bg halpha-rounded halpha-border halpha-border-white/5">
        <div class="halpha-flex halpha-justify-between halpha-gap-2">
            <div class="halpha-flex halpha-flex-col halpha-gap-2 halpha-p-4">
                <h6 class="halpha-text-muted">Total Balance</h6>

                <div class="halpha-flex halpha-items-center halpha-gap-3">
                    <h4 class="halpha-text-xl halpha-font-semibold halpha-text-accent halpha-font-sans">
                        ${{ number_format($balance, 2) }}
                    </h4>
                </div>
            </div>

            <div class="halpha-flex halpha-flex-col halpha-gap-2 halpha-p-4 halpha-items-end">
                <h6 class="halpha-text-muted">Daily Est. Reward</h6>

                <div class="halpha-flex halpha-items-center halpha-gap-3">
                    <h4 class="halpha-text-xl halpha-font-semibold halpha-text-accent halpha-font-sans">
                        ${{ number_format($dailyEstimatedReward, 2) }}
                    </h4>
                </div>
            </div>
        </div>
        <div id="total-balance-chart" style="height:120px;"></div>
    </div>

    <x-dashboard.stat title="Total Earned" value="${{ number_format($totalEarned, 2) }}" :delta="$totalEarnedDelta">
        <div id="daily-earnings"></div>
    </x-dashboard.stat>
</div>
@once
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        (function () {
            window.rewardChartData = @json($chartData);
            const totalBalanceChartEl = document.getElementById('total-balance-chart');
            if (!totalBalanceChartEl) return;

            if (!window.rewardChartData.length) {
                totalBalanceChartEl.innerHTML = '<p class="halpha-text-xs halpha-text-muted halpha-p-4">No reward data within the last 12 days yet</p>';
                return;
            }

            const options = {
                series: [{ name: 'Daily Rewards', data: window.rewardChartData ?? [] }],
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

            new ApexCharts(totalBalanceChartEl, options).render();
        })();
    </script>
@endonce