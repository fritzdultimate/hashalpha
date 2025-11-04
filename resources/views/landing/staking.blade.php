@extends('layouts.guest')

@section('content')
    <!-- Hero -->
    <section class="section halpha-py-8 md:halpha-py-32 halpha-bg-gradient-to-b halpha-from-[#04121a] halpha-to-[#07121a]">
        <div class="container-default w-container">
            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6 halpha-items-center">
                <div>
                    <h1 class="display-2 heading-color-gradient">Stake with {{ env('APP_LONG_NAME') }}</h1>
                    <p class="mg-top-4 !halpha-text-gray-300">
                        Earn predictable rewards from validators and MEV-enhanced operations. Transparent fees, daily
                        payouts, and enterprise-grade security — no node ops required.
                    </p>

                    <div class="halpha-flex halpha-gap-3 halpha-mt-6">
                        <a href="/register" class="btn-primary w-button">Join & Stake</a>
                        <a href="#plans" class="btn-secondary w-button">See Plans</a>
                    </div>
                </div>

                <div class="halpha-flex halpha-justify-end">
                    <!-- small KPI card group -->
                    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3 halpha-w-full md:halpha-w-3/4">
                        <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                            <div class="halpha-text-sm halpha-text-gray-300">Active Nodes</div>
                            <div class="halpha-text-2xl halpha-font-bold halpha-text-white">128</div>
                        </div>
                        <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                            <div class="halpha-text-sm halpha-text-gray-300">Avg. Uptime</div>
                            <div class="halpha-text-2xl halpha-font-bold halpha-text-white">99.9%</div>
                        </div>
                        <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                            <div class="halpha-text-sm halpha-text-gray-300">Payout</div>
                            <div class="halpha-text-2xl halpha-font-bold halpha-text-white">Daily</div>
                        </div>
                        <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                            <div class="halpha-text-sm halpha-text-gray-300">MEV Enabled</div>
                            <div class="halpha-text-2xl halpha-font-bold halpha-text-white">Yes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NAV (internal anchors) -->
    <nav
        class="halpha-mb-10 halpha-sticky halpha-top-0 halpha-bg-[rgba(6,8,12,0.6)] halpha-backdrop-blur halpha-py-3 halpha-z-40">
        <div class="container-default w-container halpha-flex halpha-gap-4 halpha-items-center halpha-justify-center">
            <a href="#plans" class="halpha-text-sm halpha-text-gray-300">Plans</a>
            <a href="#infrastructure" class="halpha-text-sm halpha-text-gray-300">Infrastructure</a>
            <a href="#mev" class="halpha-text-sm halpha-text-gray-300">MEV</a>
            <a href="#yield" class="halpha-text-sm halpha-text-gray-300">Yield & Payouts</a>
        </div>
    </nav>

    @include('components.guest.plans-overview')

    <!-- 2) Validator Infrastructure -->
    <div class="halpha-my-24"></div>
    @include('components.guest.validator-infrastructure')

    <!-- 3) MEV-Boosted Staking -->
    <section id="mev" class="halpha-py-16 md:halpha-py-32">
        <div class="container-default w-container">
            <div class="inner-container _608px _100-tablet">
                <h2 class="display-2 heading-color-gradient">MEV-Boosted Staking</h2>
                <p class="!halpha-text-gray-400">We integrate MEV-boost relay services to increase proposer revenue while
                    applying risk controls and revenue-sharing rules — designed to maximize yield without sacrificing
                    decentralization.</p>
            </div>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6 halpha-mt-6">
                <div>
                    <h4 class="halpha-text-white halpha-font-semibold">What is MEV?</h4>
                    <p class="halpha-text-sm halpha-text-gray-300">MEV (Maximal Extractable Value) is additional proposer
                        revenue captured from transaction ordering and bundle execution. We use vetted relays and ethical
                        MEV strategies.</p>

                    <h4 class="halpha-text-white halpha-font-semibold halpha-mt-4">Revenue Split</h4>
                    <p class="halpha-text-sm halpha-text-gray-300">Proposer revenue is split between the validators and the
                        staking pool per plan. Typical split example: 70% to stakers / 30% operational & infra fee (example
                        — update with your policy).</p>
                </div>

                <div>
                    <h4 class="halpha-text-white halpha-font-semibold">Risk Controls</h4>
                    <ul class="halpha-list-none halpha-space-y-2 halpha-text-sm halpha-text-gray-300">
                        <li>Relay vetting & SLA checks</li>
                        <li>Dynamic share limits to avoid centralization</li>
                        <li>Audited MEV operator contracts</li>
                    </ul>

                    <div class="halpha-mt-6">
                        <a href="/transparency/mev-reports" class="btn-secondary w-button">MEV Reports & Audit</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4) Yield Strategy & Payout Schedule -->
    <section id="yield" class="halpha-py-10 halpha-bg-[rgba(255,255,255,0.01)]">
        <div class="container-default w-container">
            <div class="inner-container _608px _100-tablet">
                <h2 class="display-2 heading-color-gradient">Yield Strategy & Payout Schedule</h2>
                <p class="!halpha-text-gray-400">We combine protocol block rewards, MEV revenue and an operational model to
                    deliver regular payouts. Below is an example schedule and sample calculation.</p>
            </div>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6 halpha-mt-6">
                <div>
                    <h4 class="halpha-text-white halpha-font-semibold">Payout cadence</h4>
                    <ul class="halpha-list-none halpha-space-y-2 halpha-text-sm halpha-text-gray-300">
                        <li>Daily aggregation of earned rewards → user balances updated every 24 hours.</li>
                        <li>Auto-compound option available for Pro and Institutional plans.</li>
                        <li>Withdrawals processed within 24–72 hours (subject to plan liquidity).</li>
                    </ul>

                    <h4 class="halpha-text-white halpha-font-semibold halpha-mt-4">Sample calculation</h4>
                    <pre class="halpha-bg-[#07121a] halpha-p-3 halpha-rounded-[8px] halpha-text-sm halpha-text-gray-300">
    Example: $1,000 in Pro (9% APY)
    Daily reward ≈ (0.09 / 365) * 1000 = $0.25/day (before fees & MEV)
    Net to user after fees & splits = ~$0.18/day (illustrative)
                        </pre>
                </div>

                <div>
                    <!-- Chart placeholder: integrate chart library or image -->
                    <div
                        class="halpha-bg-[#07121a] halpha-rounded-[12px] halpha-p-4 halpha-h-60 halpha-flex halpha-items-center halpha-justify-center">
                        <div class="halpha-text-sm halpha-text-gray-400"><!--[Yield projection chart]--></div>
                    </div>

                    <div class="halpha-mt-4">
                        <a href="/pricing" class="btn-primary w-button">See detailed payout rules</a>
                    </div>
                </div>
            </div>

            <!-- Payout schedule table -->
            <div class="halpha-overflow-x-auto halpha-mt-6">
                <table class="halpha-w-full halpha-text-sm halpha-text-gray-300">
                    <thead class="halpha-text-left">
                        <tr>
                            <th class="halpha-p-3">Plan</th>
                            <th class="halpha-p-3">Payout Frequency</th>
                            <th class="halpha-p-3">Auto-compound</th>
                            <th class="halpha-p-3">Withdrawal window</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="halpha-border-t halpha-border-[#111316]">
                            <td class="halpha-p-3">Starter</td>
                            <td class="halpha-p-3">Daily</td>
                            <td class="halpha-p-3">No</td>
                            <td class="halpha-p-3">24 hours</td>
                        </tr>
                        <tr class="halpha-border-t halpha-border-[#111316]">
                            <td class="halpha-p-3">Pro</td>
                            <td class="halpha-p-3">Daily</td>
                            <td class="halpha-p-3">Optional</td>
                            <td class="halpha-p-3">24–48 hours</td>
                        </tr>
                        <tr class="halpha-border-t halpha-border-[#111316]">
                            <td class="halpha-p-3">Institutional</td>
                            <td class="halpha-p-3">Daily</td>
                            <td class="halpha-p-3">Optional</td>
                            <td class="halpha-p-3">Custom</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @include('components.guest.faqs')

@endsection