@extends('layouts.guest')

@section('content')

    <div class="top-section section small halpha-mt-10 top-section-bg-img-center">
        <div class="container-default w-container">
            <div class="grid-2-columns _1-col-tablet gap-row-8px">
                <div data-w-id="bc6f8e73-abc8-b69a-68e1-73c6d3a67216" style="opacity: 1; filter: blur(0px);"
                    class="inner-container _558px _100-tablet">
                    <h1 class="display-2 heading-color-gradient mg-bottom-0 halpha-uppercase">
                        Earn daily from the backbone of blockchain
                    </h1>
                </div>
                <div id="w-node-_64d41687-720e-ca5c-a050-26b768b07fcc-04e3ff82"
                    data-w-id="64d41687-720e-ca5c-a050-26b768b07fcc" style="opacity: 1; filter: blur(0px);"
                    class="inner-container _504px _100-tablet">
                    <p class="color-neutral-100 mg-bottom-32px">
                        {{ env('APP_LONG_NAME') }} transforms Ethereum validator operations into accessible, daily staking rewards powered by real on-chain performance and MEV optimization.
                    </p>
                    <div class="buttons-flex-container">
                        <div data-w-id="64d41687-720e-ca5c-a050-26b768b07fd0" class="btn-primary-wrapper">
                            <a href="{{ route('register') }}" class="btn-primary w-button">Get started<span
                                    class="line-rounded-icon link-icon-right"></span>
                            </a>
                            <div class="btn-primary-border"></div>
                        </div>
                        <a href="{{ route('about') }}" class="btn-secondary w-button !halpha-hidden">Learn more</a>
                    </div>
                </div>
            </div>
        </div>

        <img class="top-section-bg-img-center---img"
            src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d662c156553bb641e879af_home-v2-hero-image-right-cryptomatic-webflow-ecommerce-template.jpg"
            alt="" style="opacity: 1; filter: blur(0px);"
            sizes="(max-width: 479px) 80vw, (max-width: 767px) 72vw, (max-width: 991px) 80vw, (max-width: 1439px) 78vw, 1107.9862060546875px"
            data-w-id="64d41687-720e-ca5c-a050-26b768b07fd8" loading="eager">
    </div>

    <div data-w-id="6bb2631d-8226-c422-0ba3-4602f716ae36" style="opacity: 1; filter: blur(0px);"
        class="w-layout-blockcontainer container-default w-container">
        <div class="divider mg-0"></div>
    </div>

    @include('components.guest.companies-supported')

    @include('components.guest.why-us')

    @include('components.guest.features')

    @include('components.guest.take-away-attributes')

    @include('components.guest.how-it-works')

    @include('components.guest.testimonies')

    @include('components.guest.core-concepts')

    


    @include('components.guest.plans-overview')


    {{-- 4) Transparency (responsive KPIs + CTA) --}}
    <section class="halpha-bg-[rgba(255,255,255,0.02)] halpha-mt-10">
        <div class="container-default w-container">
            <div class="heading-and-content-grid mg-bottom-24px">
                <div class="inner-container _564px _100-tablet">
                    <h2 class="display-2 heading-color-gradient mg-bottom-0">Transparency & Proof</h2>
                    <p class="color-neutral-100 mg-bottom-16px !halpha-text-gray-400">
                        Real-time validator telemetry and monthly operations reports.
                    </p>
                </div>
            </div>

            <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-4 halpha-gap-6 halpha-mb-8">
                <div class="halpha-text-center">
                    <div class="halpha-text-3xl halpha-font-extrabold halpha-text-gray-600">128</div>
                    <div class="halpha-text-sm halpha-text-gray-300">Active Nodes</div>
                </div>
                <div class="halpha-text-center">
                    <div class="halpha-text-3xl halpha-font-extrabold halpha-text-gray-600">99.9%</div>
                    <div class="halpha-text-sm halpha-text-gray-300">Avg Uptime</div>
                </div>
                <div class="halpha-text-center">
                    <div class="halpha-text-3xl halpha-font-extrabold halpha-text-gray-600">Daily</div>
                    <div class="halpha-text-sm halpha-text-gray-300">Payout Schedule</div>
                </div>
                <div class="halpha-text-center">
                    <div class="halpha-text-3xl halpha-font-extrabold halpha-text-gray-600">Audited</div>
                    <div class="halpha-text-sm halpha-text-gray-300">Third-party Reports</div>
                </div>
            </div>

            <div class="halpha-flex halpha-flex-col sm:halpha-flex-row halpha-gap-3">
                <a href="/transparency/validator-explorer" class="btn-primary w-full sm:!halpha-w-auto">Open Validator
                    Explorer</a>
                <a href="/transparency/reports" class="btn-secondary w-full sm:!halpha-w-auto">Monthly Reports</a>
            </div>
        </div>
    </section>

    {{-- 5) Roadmap (responsive timeline) --}}
    <section class="halpha-py-16 md:halpha-py-32">
        <div class="container-default w-container">
            <div class="heading-and-content-grid mg-bottom-24px">
                <div class="inner-container _564px _100-tablet">
                    <h2 class="display-2 heading-color-gradient mg-bottom-0">Roadmap</h2>
                    <p class="color-neutral-100 mg-bottom-16px !halpha-text-gray-400">
                        Planned features and operational milestones — updated quarterly.
                    </p>
                </div>
            </div>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6">
                <div class="halpha-space-y-6">
                    <div class="halpha-flex halpha-gap-4">
                        <div class="halpha-w-10 halpha-text-center halpha-text-white">Q1</div>
                        <div>
                            <h5 class="halpha-text-white halpha-font-semibold">Foundation Phase</h5>
                            <p class="halpha-text-sm halpha-text-gray-300">
                                Partnerships with node operators, infrastructure providers, and validator engineers. Internal R&D and security architecture.
                            </p>
                        </div>
                    </div>

                    <div class="halpha-flex halpha-gap-4">
                        <div class="halpha-w-10 halpha-text-center halpha-text-white">Q2</div>
                        <div>
                            <h5 class="halpha-text-white halpha-font-semibold">Validator Deployment Phase</h5>
                            <p class="halpha-text-sm halpha-text-gray-300">
                                Launch of HashAlpha’s institutional-grade Ethereum validators, MEV relay integration, and transparency framework.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="halpha-space-y-6">
                    <div class="halpha-flex halpha-gap-4">
                        <div class="halpha-w-10 halpha-text-center halpha-text-white">Q3</div>
                        <div>
                            <h5 class="halpha-text-white halpha-font-semibold">Platform Expansion Phase</h5>
                            <p class="halpha-text-sm halpha-text-gray-300">
                                Public platform launch, global affiliate ecosystem, enhanced dashboard, and validator proof layer.
                            </p>
                        </div>
                    </div>

                    <div class="halpha-flex halpha-gap-4">
                        <div class="halpha-w-10 halpha-text-center halpha-text-white">Q4</div>
                        <div>
                            <h5 class="halpha-text-white halpha-font-semibold">Ecosystem Scaling Phase</h5>
                            <p class="halpha-text-sm halpha-text-gray-300">
                                Validator-as-a-Service, L2 integrations, enterprise partnerships, and long-term tokenized validator share model.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.guest.our-team')

    @include('components.guest.faqs', ['showing' => 3])

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection