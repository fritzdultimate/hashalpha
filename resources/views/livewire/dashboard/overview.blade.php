<div class="!halpha-text-gray-700">
    <div class="halpha-mb-6 halpha-grid halpha-grid-cols-1 sm:halpha-grid-cols-2 lg:halpha-grid-cols-3 halpha-gap-4">
        <x-stat-card title="Total Deposited" :value="'$' . number_format($totalDeposited, 2)" subtitle="All-time deposits"
            :icon="'<svg class=`halpha-h-5 halpha-w-5` ...></svg>'" />
        <x-stat-card title="Total Earnings" :value="'$' . number_format($totalEarnings, 2)" subtitle="All-time earnings"
            :icon="'<svg class=`halpha-h-5 halpha-w-5` ...></svg>'" />
        <x-stat-card title="Active Stakes" :value="$activeStakes" subtitle="Ongoing validator stakes"
            :icon="'<svg class=`halpha-h-5 halpha-w-5` ...></svg>'" />
    </div>

    <div class="halpha-grid halpha-grid-cols-1 lg:halpha-grid-cols-3 halpha-gap-6">
        <section class="lg:halpha-col-span-2">
            <div class="halpha-p-4 halpha-rounded-2xl halpha-bg-white halpha-shadow-sm halpha-border halpha-overflow-hidden">
                <h3 class="halpha-font-semibold halpha-mb-3">Pool Performance</h3>
                <div class="halpha-text-sm halpha-text-gray-500">
                    Estimated daily APY, validator health and distribution chart placeholder.
                </div>
                {{-- Replace with chart component (recharts / chartjs) or Livewire-powered chart --}}
                <div class="halpha-mt-4 halpha-h-56 halpha-flex halpha-items-center halpha-justify-center halpha-text-sm halpha-text-gray-400 halpha-border halpha-rounded">
                    Chart placeholder
                </div>
            </div>

            <div class="halpha-mt-4 halpha-p-4 halpha-rounded-2xl halpha-bg-white halpha-shadow-sm halpha-border">
                <h3 class="halpha-font-semibold halpha-mb-3 !halpha-text-black">Recent Activity</h3>
                <div class="halpha-space-y-3">
                    {{-- sample entries --}}
                    <div class="halpha-flex halpha-items-center halpha-justify-between">
                        <div>
                            <div class="halpha-text-sm halpha-font-medium">Deposit — ETH</div>
                            <div class="halpha-text-xs halpha-text-gray-500">Oct 30, 2025 — Tx: 0xabc...123</div>
                        </div>
                        <div class="halpha-text-sm halpha-font-semibold">+$1,200.00</div>
                    </div>
                </div>
            </div>
        </section>

        <aside class="halpha-space-y-4">
            <div class="halpha-p-4 halpha-rounded-2xl halpha-bg-white halpha-shadow-sm halpha-border">
                <h4 class="halpha-font-semibold">Quick Actions</h4>
                <div class="halpha-mt-3 halpha-flex halpha-flex-col halpha-gap-2">
                    <a href="/invest" class="halpha-block halpha-text-center halpha-py-2 halpha-rounded halpha-bg-blue-600 halpha-text-white halpha-font-medium">
                        Invest Now
                    </a>
                    <a href="/withdraw" class="halpha-block halpha-text-center halpha-py-2 halpha-rounded halpha-border">
                        Withdraw
                    </a>
                </div>
            </div>

            <div class="halpha-p-4 halpha-rounded-2xl halpha-bg-white halpha-shadow-sm halpha-border">
                <h4 class="halpha-font-semibold !halpha-text-gray-700">Validator Health</h4>
                <div class="halpha-mt-2 halpha-text-sm halpha-text-gray-500">
                    All validators are <span class="halpha-font-medium halpha-text-green-600">online</span>.
                </div>
            </div>
        </aside>
    </div>
</div>
