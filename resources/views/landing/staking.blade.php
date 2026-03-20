@extends('layouts.guest')

@section('content')
    <!-- Hero -->
    <section class="halpha-py-8 md:halpha-py-32 halpha-bg-gradient-to-b halpha-from-[#04121a] halpha-to-[#07121a]">
        <div class="container-default w-container">
            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-12 halpha-items-center">
                <div>
                    <h1 class="display-3 heading-color-gradient">INFRASTRUCTURE BACKED STAKING & YIELD OPERATIONS </h1>
                    <p class="mg-top-4 !halpha-text-gray-300">
                        Multi-Layer Digital Asset Infrastructure
                    </p>
                    <p class="mg-top-4 !halpha-text-gray-300">
                        {{ env('APP_NAME') }} operates a diversified infrastructure ecosystem designed to generate performance through validator architecture, execution-layer optimization, and scalable hosting systems.
                    </p>

                    <p class="mg-top-4 !halpha-text-gray-300">
                        Our model is built on systems — not single revenue streams.
                    </p>

                    <p class="mg-top-4 !halpha-text-gray-300">
                        Engineered for resilience. Structured for scale. Designed for long-term participation.

                    </p>

                    <div class="halpha-flex halpha-gap-3 halpha-mt-6">
                        <!-- <a href="{{ route('register') }}" class="btn-primary w-button">Join & Stake</a> -->
                        <a href="{{ route('login') }}" class="btn-secondary w-button">
                            Explore Infrastructure 
                        </a>
                    </div>
                </div>

                <div class="halpha-flex halpha-flex-col halpha-justify-end">
                    <h2 class="halpha-text-lg">KEY METRICS:</h2>
                    <!-- small KPI card group -->
                    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3 halpha-w-full md:halpha-w-3/4">
                        <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a] halpha-text-center">
                            <div class="halpha-text-sm halpha-text-gray-300">Active Infrastructure Nodes</div>
                            <div class="halpha-text-2xl halpha-font-bold halpha-text-white">136+</div>
                        </div>
                        <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a] halpha-text-center">
                            <div class="halpha-text-sm halpha-text-gray-300">Average Network Uptime</div>
                            <div class="halpha-text-2xl halpha-font-bold halpha-text-white">99.9%</div>
                        </div>
                        <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a] halpha-text-center">
                            <div class="halpha-text-sm halpha-text-gray-300">Deployment Regions</div>
                            <div class="halpha-text-base halpha-font-bold halpha-text-white">Multi-Region Architecture</div>
                        </div>
                        <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a] halpha-text-center">
                            <div class="halpha-text-sm halpha-text-gray-300">Execution Optimization</div>
                            <div class="halpha-text-base halpha-font-bold halpha-text-white">Integrated</div>
                        </div>

                        <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a] halpha-text-center">
                            <div class="halpha-text-sm halpha-text-gray-300">Distribution Model</div>
                            <div class="halpha-text-base halpha-font-bold halpha-text-white">Periodic & Performance-Based</div>
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
            <!-- <a href="#plans" class="halpha-text-sm halpha-text-gray-300">Plans</a> -->
            <a href="#infrastructure" class="halpha-text-sm halpha-text-gray-300">Infrastructure</a>
            <a href="#mev" class="halpha-text-sm halpha-text-gray-300">MEV</a>
            <a href="#yield" class="halpha-text-sm halpha-text-gray-300">Yield & Payouts</a>
        </div>
    </nav>

    <!-- @include('components.guest.plans-overview') -->

    <!-- Validator Infrastructure -->
    @include('components.guest.validator-infrastructure')

    <!-- MEV-Boosted Staking -->
    <section class="halpha-py-16 md:halpha-py-0">
        <div class="container-default w-container">
            <div class="inner-container _608px _100-tablet">
                <h2 class="display-2 heading-color-gradient">REVENUE ARCHITECTURE</h2>
                <p class="!halpha-text-gray-400">
                    A Diversified Performance Model
                </p>
            </div>

            <div class="halpha-mt-6">
                <div class="halpha-flex halpha-flex-col">
                    <p class="!halpha-text-gray-400">
                        Performance within HashAlpha’s ecosystem is derived from multiple operational layers, including:
                    </p>

                    <ul class="halpha-list-disc halpha-text-gray-300 halpha-text-base">
                        <li>Consensus participation rewards</li>
                        <li>Execution layer transaction fees</li>
                        <li>MEV optimization systems</li>
                        <li>Proprietary execution strategies</li>
                        <li>Infrastructure-level efficiencies</li>
                    </ul>
                </div>

                <div>
                    <p class="!halpha-text-gray-400">Outcomes are variable and reflect real network conditions and system performance.</p>
                    <p class="!halpha-text-gray-400">We prioritize sustainability and structured growth over aggressive short-term positioning.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="halpha-py-16 md:halpha-py-0">
        <div class="container-default w-container">
            <div class="inner-container _608px _100-tablet">
                <h2 class="display-2 heading-color-gradient">DISTRIBUTIONS & TRANSPARENCY</h2>
                <p class="!halpha-text-gray-400">
                    
                </p>
            </div>

            <div class="halpha-mt-6">
                <div class="halpha-flex halpha-flex-col">
                    <p class="!halpha-text-gray-400">
                        Structured Distribution Model
                    </p>

                    <ul class="halpha-list-disc halpha-text-gray-300 halpha-text-base">
                        <li>Rewards are aggregated across operational layers</li>
                        <li>Balances reflect system-wide performance</li>
                        <li>Optional compounding configurations available</li>
                        <li>Withdrawals processed according to liquidity structure</li>
                    </ul>
                </div>

                <div>
                    <p class="!halpha-text-gray-400">
                        Performance reporting and operational transparency remain core to our approach.
                    </p>
                    <p class="!halpha-text-gray-400">
                        No fixed returns. No artificial guarantees.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="halpha-py-16 md:halpha-py-0">
        <div class="container-default w-container">
            <div class="inner-container _608px _100-tablet">
                <h2 class="display-2 heading-color-gradient">PHASE 2: INFRASTRUCTURE EVOLUTION</h2>
                <p class="!halpha-text-gray-400">
                    Validators were the starting point.
                </p>
            </div>

            <div class="halpha-mt-6">
                <div class="halpha-flex halpha-flex-col">
                    <p class="!halpha-text-gray-400">
                        Phase 2 expands HashAlpha into a broader infrastructure and execution ecosystem designed to:
                    </p>

                    <ul class="halpha-list-disc halpha-text-gray-300 halpha-text-base">
                        <li>Diversify revenue streams</li>
                        <li>Strengthen operational resilience</li>
                        <li>Scale infrastructure capacity</li>
                        <li>Introduce institutional-grade participation frameworks</li>
                    </ul>
                </div>

                <div>
                    <p class="!halpha-text-gray-400">
                        Deployment milestones will be introduced progressively.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Yield Strategy & Payout Schedule -->
    <section id="yield" class="halpha-py-10 halpha-bg-[rgba(255,255,255,0.01)]">
        <div class="container-default w-container">
            <div class="inner-container _608px _100-tablet">
                <h2 class="display-2 heading-color-gradient">SECURITY & GOVERNANCE</h2>
                <p class="!halpha-text-gray-400">
                    Security underpins every layer of our ecosystem.
                </p>
            </div>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6 halpha-mt-6">
                <div>
                    <ul class="halpha-list-none halpha-space-y-2 halpha-text-sm halpha-text-gray-300">
                        <li>Layered custody architecture</li>
                        <li>Infrastructure isolation protocols</li>
                        <li>Automated monitoring and alert systems</li>
                        <li>Defined operational response procedures</li>
                        <li>Transparent and structured fee model</li>
                    </ul>

                    
                </div>

                <div>
                    <p class="halpha-text-white halpha-font-semibold halpha-mt-4">
                        We build deliberately. We scale responsibly.
                    </p>

                    <p class="!halpha-text-gray-400">
                        Security underpins every layer of our ecosystem.
                    </p>

                    <div class="halpha-mt-4">
                        <a href="/login" class="btn-primary w-button">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- @include('components.guest.faqs') -->

@endsection