<div wire:ignore.self>
    <div class="halpha-bg-card-bg halpha-border halpha-border-white/5 halpha-rounded halpha-p-4">
        <div class="halpha-flex halpha-justify-between halpha-items-center halpha-mb-3">
            <div>
                <h3 class="halpha-text-base halpha-font-semibold">Earnings</h3>
                <p class="halpha-text-muted halpha-text-xs">Validator earnings over time</p>
            </div>

            <div class="halpha-flex halpha-items-center halpha-gap-2">
                <select wire:model="range" class="halpha-bg-gray-800 halpha-text-sm halpha-px-2 halpha-py-1 halpha-rounded">
                    <option value="7d">7d</option>
                    <option value="30d">30d</option>
                    <option value="90d">90d</option>
                    <option value="365d">365d</option>
                </select>

                <button x-data x-on:click="$dispatch('toggle-currency')"
                    class="halpha-text-sm halpha-px-3 halpha-py-1 halpha-border halpha-border-white/5 halpha-rounded">
                    Toggle USD/ETH
                </button>
            </div>
        </div>

        <div class="halpha-relative">
            <canvas id="earningsChart" width="600" height="260"></canvas>
        </div>
    </div>
</div>

@push('scripts')
    <!-- Chart.js CDN (or use npm build) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('livewire:load', function () {
            const ctx = document.getElementById('earningsChart').getContext('2d');

            // create gradient matching halpha theme
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(0,200,255,0.25)'); // top
            gradient.addColorStop(1, 'rgba(0,200,255,0.03)'); // bottom

            const config = {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [
                        {
                            label: 'ETH',
                            data: @json($ethData),
                            fill: true,
                            backgroundColor: gradient,
                            borderColor: 'rgba(0,200,255,0.9)',
                            pointRadius: 2,
                            tension: 0.25,
                            borderWidth: 2,
                            hoverRadius: 4,
                            yAxisID: 'y',
                        },
                        {
                            label: 'USD',
                            data: @json($usdData),
                            fill: false,
                            borderColor: 'rgba(120,120,255,0.9)',
                            borderDash: [6, 4],
                            pointRadius: 0,
                            tension: 0.25,
                            borderWidth: 1.5,
                            hidden: true, // start hidden; toggle with button
                            yAxisID: 'yRight',
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#D1D5DB', // tailwind gray-300 for dark
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    const val = ctx.parsed.y;
                                    if (ctx.dataset.label === 'ETH') return `${val} ETH`;
                                    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(val);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#9CA3AF' },
                            grid: { display: false }
                        },
                        y: {
                            type: 'linear',
                            position: 'left',
                            ticks: { color: '#9CA3AF', callback: v => v + ' ETH' },
                            grid: { color: 'rgba(255,255,255,0.03)' }
                        },
                        yRight: {
                            type: 'linear',
                            position: 'right',
                            ticks: { color: '#9CA3AF', callback: v => '$' + v },
                            grid: { drawOnChartArea: false },
                        }
                    }
                }
            };

            let chart = new Chart(ctx, config);

            // Listen for Livewire updates
            Livewire.on('earningsUpdated', payload => {
                chart.data.labels = payload.labels;
                chart.data.datasets[0].data = payload.eth;
                chart.data.datasets[1].data = payload.usd;
                chart.update();
            });

            // Toggle currency dataset visibility (button dispatch)
            window.addEventListener('toggle-currency', () => {
                const usdSet = chart.data.datasets[1];
                usdSet.hidden = !usdSet.hidden;
                chart.update();
            });

            // Also support the button that dispatches from Alpine above
            document.addEventListener('toggle-currency', () => {
                const usdSet = chart.data.datasets[1];
                usdSet.hidden = !usdSet.hidden;
                chart.update();
            });
        });
    </script>
@endpush