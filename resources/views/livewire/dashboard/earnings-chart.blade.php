<div wire:ignore.self>
    <div class="halpha-bg-card-bg halpha-border halpha-border-white/5 halpha-rounded">
        <div class="halpha-flex halpha-justify-between halpha-items-center halpha-mb-3 halpha-p-4">
            <div>
                <h3 class="halpha-text-base halpha-font-semibold">Earnings</h3>
                <p class="halpha-text-muted halpha-text-xs">Validator earnings over time</p>
            </div>

            <div class="halpha-flex halpha-items-center halpha-gap-2">
                <select wire:model.live="range"
                    class="halpha-bg-gray-800 halpha-text-sm halpha-px-2 halpha-py-1 halpha-rounded halpha-appearance-none no-arrow">
                    <option value="7d">7d</option>
                    <option value="30d">30d</option>
                    <option value="90d">90d</option>
                    <option value="365d">365d</option>
                </select>
            </div>
        </div>

        <div class="halpha-relative">
            <div id="earnings-chart" class=""></div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@4.4.0/dist/apexcharts.min.js"></script>

        <script>
            (function () {
                const earningChart = document.getElementById('earnings-chart');
                if (!earningChart) return;

                const options = {
                    series: [{ name: 'Earnings', data: [] }],
                    chart: { 
                        type: 'area', 
                        height: 160, 
                        sparkline: { enabled: true },
                        animations: { enabled: true, easing: 'easeout', speed: 450 },
                        zoom: { enabled: false },
                        toolbar: { show: false },
                    },
                    stroke: { curve: 'smooth', width: 2.5 },
                    markers: { size: 0, hover: { size: 6 } },
                    grid: { show: false },
                    fill: { 
                        type: 'gradient', 
                        // gradient: { opacityFrom: 0.45, opacityTo: 0.05 },
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.4,
                            inverseColors: false,
                            opacityFrom: 0.45,
                            opacityTo: 0.02,
                            stops: [20, 100]
                        }
                    },
                    colors: ['#3b82f6'],
                    tooltip: {
                        enabled: true,
                        theme: 'light',
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Public Sans, sans-serif'
                        },
                        y: { formatter: v => '$' + Number(v).toLocaleString() },
                        x: { show: true },
                        marker: { show: true },
                        custom: function({ series, seriesIndex, dataPointIndex, w }) {
                            const label = w.globals.categoryLabels[dataPointIndex];
                            const value = series[seriesIndex][dataPointIndex];
                            return `
                                <div style="
                                    background: white;
                                    padding: 6px 10px;
                                    border-radius: 6px;
                                    font-family: 'Public Sans', sans-serif;
                                    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                                    color: black;
                                ">
                                    <div style="font-size: 11px; opacity: 0.7;">${label}</div>
                                    <div style="font-weight: 600; font-size: 13px;">
                                        $${Number(value).toLocaleString()}
                                    </div>
                                </div>
                            `;
                        }
                    },
                };

                const chart = new ApexCharts(earningChart, options);
                chart.render();

                window.addEventListener('earningsUpdated', ({ detail }) => {
                    const labels = Array.isArray(detail[0].labels) ? detail[0].labels : [];
                    const data = Array.isArray(detail[0].usd) ? detail[0].usd : [];
                    chart.updateOptions({ xaxis: { categories: labels } }, true, true)
                        .then(() => {
                            chart.updateSeries([{ name: 'Earnings Maka', data }], true);
                        })
                        .catch(err => console.error('Apex update error:', err));
                });
            })();
        </script>
    @endpush




</div>