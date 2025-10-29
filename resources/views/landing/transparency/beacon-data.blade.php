@extends('layouts.guest')

@section('content')
    <section class="halpha-py-8">
        <div class="container-default w-container">
            <h1 class="display-2 heading-color-gradient">Real-Time Beacon Data</h1>
            <p class="!halpha-text-gray-400">Live chain health metrics from public beacon providers.</p>

            
            <div x-data="publicBeaconWidget()" x-init="init()" class="halpha-mt-6">
                <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-4 halpha-gap-4">
                    <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                        <div class="halpha-text-sm halpha-text-gray-300">Head Slot</div>
                        <div class="halpha-text-2xl halpha-text-white" x-text="headSlot">—</div>
                    </div>

                    <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                        <div class="halpha-text-sm halpha-text-gray-300">Finalized Epoch</div>
                        <div class="halpha-text-2xl halpha-text-white" x-text="finalizedEpoch">—</div>
                    </div>

                    <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                        <div class="halpha-text-sm halpha-text-gray-300">Provider</div>
                        <div class="halpha-text-2xl halpha-text-white" x-text="provider">—</div>
                    </div>

                    <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                        <div class="halpha-text-sm halpha-text-gray-300">Last updated</div>
                        <div class="halpha-text-2xl halpha-text-white" x-text="lastFetched">—</div>
                    </div>
                </div>

                <div class="halpha-mt-6 halpha-bg-[#07121a] halpha-p-4 halpha-rounded-[12px]">
                    <canvas id="beaconChart" class="halpha-w-full halpha-h-[360px]"></canvas>
                </div>

                <div class="halpha-mt-4 halpha-flex halpha-flex-col md:halpha-flex-row md:halpha-justify-between md:halpha-items-center halpha-gap-4 halpha-text-sm halpha-text-gray-400">
                    <div class="halpha-space-y-6 md:halpha-space-x-6">
                        <button @click="fetchOnce()" class="btn-secondary w-button">Refresh now</button>
                        <button @click="togglePoll()" class="btn-primary w-button"
                            x-text="polling ? 'Pause' : 'Resume'">Pause</button>
                    </div>
                    <div x-show="error" class="halpha-text-red-400" x-text="error"></div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function publicBeaconWidget() {
            return {
                headSlot: '—',
                finalizedEpoch: '—',
                provider: '—',
                lastFetched: '—',
                error: null,
                polling: true,
                pollIntervalMs: 12000,
                _interval: null,
                chart: null,
                chartData: { labels: ['maka', 'kaka', 'boko', 'bigi'], slots: [1, 2, 4, 2.3] },

                init() {
                    // init Chart.js line
                    const ctx = document.getElementById('beaconChart').getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: this.chartData.labels,
                            datasets: [{
                                label: 'Head Slot',
                                data: this.chartData.slots,
                                fill: true,
                                tension: 0.25,
                                borderWidth: 2,
                                pointRadius: 2,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { display: true },
                                y: { display: true }
                            }
                        }
                    });

                    // initial fetch then start polling
                    this.fetchOnce();
                    this._interval = setInterval(() => {
                        if (this.polling) this.fetchOnce();
                    }, this.pollIntervalMs);
                },

                async fetchOnce() {
                    this.error = null;
                    try {
                        const res = await fetch('{{ route('api-beacon') }}');
                        if (!res.ok) {
                            const text = await res.text().catch(() => null);
                            throw new Error('Failed to fetch beacon data' + (text ? (': ' + text) : ''));
                        }
                        const json = await res.json();

                        // canonical fields expected from controller: head_slot, finalized_epoch, fetched_at, raw_provider
                        this.headSlot = json.head_slot ?? '—';
                        this.finalizedEpoch = json.finalized_epoch ?? '—';
                        this.provider = json.raw_provider ?? (json.provider ?? 'public');
                        this.lastFetched = json.fetched_at ? new Date(json.fetched_at).toLocaleString() : new Date().toLocaleString();

                        // push to chart (keep last 40 points)
                        const label = new Date().toLocaleTimeString();
                        const slotVal = Number(json.head_slot) || null;
                        if (slotVal !== null) {
                            this.chartData.labels.push(label);
                            this.chartData.slots.push(slotVal);
                            if (this.chartData.labels.length > 40) {
                                this.chartData.labels.shift();
                                this.chartData.slots.shift();
                            }
                            this.chart.data.labels = this.chartData.labels;
                            this.chart.data.datasets[0].data = this.chartData.slots;
                            this.chart.update();
                        }
                    } catch (err) {
                        console.error('Beacon fetch error', err);
                        this.error = err.message || 'Error fetching beacon data';
                    }
                },

                togglePoll() {
                    this.polling = !this.polling;
                },

                // cleanup (not used by Blade but good to have)
                destroy() {
                    if (this._interval) clearInterval(this._interval);
                    if (this.chart) this.chart.destroy();
                }
            }
        }
    </script>
@endsection