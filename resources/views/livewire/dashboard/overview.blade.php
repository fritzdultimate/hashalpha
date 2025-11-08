<section
    class="halpha-grid halpha-grid-cols-1 sm:halpha-grid-cols-2 md:halpha-grid-cols-3 lg:halpha-grid-cols-4 halpha-gap-5">
    <x-dashboard.stat title="Total Deposits" value="$78,250">
        <div id="deposit-chart" style="height:120px;"></div>
    </x-dashboard.stat>

    <x-dashboard.stat title="Active Investments" value="$8,250" delta="42.32%">
        <div id="active-investment-chart"></div>
    </x-dashboard.stat>

    <x-dashboard.stat title="Daily Earnings" value="$8,250" delta="2.32%">
        <div id="daily-earnings"></div>
    </x-dashboard.stat>

    <x-dashboard.stat title="Referral Bonus" value="$83,250" delta="22.32%">
        <div id="referral-bonus"></div>
    </x-dashboard.stat>

    <x-dashboard.stat title="Team Performance" value="$833,250" delta="22.32%">
        <div id="team-performance-bonus"></div>
    </x-dashboard.stat>

    <x-dashboard.stat title="Total Withdrawn" value="$833,250" delta="22.32%">
        <div id="total-withdrawn"></div>
    </x-dashboard.stat>

    <x-dashboard.stat title="Wallet Balance" value="$833,250" delta="22.32%">
        <div id="wallet-balance"></div>
    </x-dashboard.stat>
</section>

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
        const el = document.getElementById('active-investment-chart');
        if (!el) return;


        const data = [4, -2, 3, 1, -6, 5, 2, -3, 4, 3, -1, 6, 4, 4, 4, 4, -10, -12];

        const colors = data.map(v => v >= 0 ? '#10b981' : '#ef4444');
        console.log(colors)
        const options = {
            series: [{ name: 'Daily', data }],
            chart: {
                type: 'bar',
                height: 120,
                sparkline: { enabled: true },
                toolbar: { show: false }
            },
            plotOptions: {
                bar: { columnWidth: '80%', borderRadius: 2, distributed: true }
            },
            colors,
            tooltip: {
                enabled: true,
                theme: false,
                style: { fontSize: '12px', fontFamily: 'Public Sans, sans-serif' },
                y: { formatter: v => (v >= 0 ? '+' : '') + v + '%' },
                x: { show: false }
            }
        };

        if (window._sparkCol) { try { window._sparkCol.destroy(); } catch (e) { } }
        window._sparkCol = new ApexCharts(el, options);
        window._sparkCol.render();
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

    (function () {
        const withdrawalChartEl = document.getElementById('total-withdrawn');
        if (!withdrawalChartEl) return;

        const options = {
            series: [{ name: 'Total Withdrawn', data: [800, 950, 700, 850, 900, 1000, 950, 1100, 1050, 1200, 1150, 1300] }],
            chart: { type: 'line', sparkline: { enabled: true }, height: 120 },
            stroke: { curve: 'smooth', width: 3 },
            fill: { 
                type: 'gradient', 
                gradient: { 
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.3,
                    opacityFrom: 0.4, 
                    opacityTo: 1,
                    stops: [0, 100]
                } 
            },
            colors: ['#ef4444'],
            tooltip: {
                x: { show: false },
                y: { formatter: val => `$${val}` }
            }
        };

        new ApexCharts(withdrawalChartEl, options).render();
    })();

    (function () {
        const withdrawalChartEl = document.getElementById('wallet-balance');
        if (!withdrawalChartEl) return;

        const options = {
            series: [{ name: 'Wallet Balance', data: [5000, 5200, 5400, 5600, 5800, 6000, 6200, 6400, 6600, 6800, 7000, 7200] }],
            chart: { type: 'area', sparkline: { enabled: true }, height: 120 },
            stroke: { curve: 'smooth', width: 2 },
            fill: { type: 'gradient', gradient: { opacityFrom: 0.3, opacityTo: 0 } },
            colors: ['#f59e0b'],
            tooltip: {
                x: { show: false }
            }
        };

        new ApexCharts(withdrawalChartEl, options).render();
    })();
</script>