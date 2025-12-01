@extends('layouts.guest')

@section('content')

    <div class="halpha-overflow-hidden md:halpha-mt-20">
        <section class="top-section section top-section-bg-img-right">
            <div class="w-layout-blockcontainer container-default position-relative---z-index-1 w-container">
                <div class="grid-2-columns _1-col-tablet">
                    <div id="w-node-_924b8ab0-686c-9d71-25ab-87214b088c45-bd0d2b38" class="inner-container _510px _100-tablet">
                        <h1 data-w-id="e94fab0b-b7aa-0619-af02-bbb42d83efb8" style="opacity: 1; filter: blur(0px);" class="display-1 heading-color-gradient mg-bottom-0">
                            Earn daily from the backbone of blockchain
                        </h1>
                        
                        <p class="color-neutral-100 mg-bottom-32px">
                        {{ env('APP_LONG_NAME') }} transforms Ethereum validator operations into accessible, daily staking rewards powered by real on-chain performance and MEV optimization.
                        </p>
                        
                        <div data-w-id="94b66ed0-3a57-7602-7036-6692c6d028e9" style="opacity: 1; filter: blur(0px);" class="buttons-flex-container">
                            <div data-w-id="94b66ed0-3a57-7602-7036-6692c6d028ea" class="btn-primary-wrapper">
                                <a href="{{ route('register') }}" class="btn-primary w-button">
                                    Get started<span class="line-rounded-icon link-icon-right" style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;"></span>
                                </a>
                                
                                <div class="btn-primary-border"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <img class="top-section-bg-img-right---img" src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d662c156553bb641e879af_home-v2-hero-image-right-cryptomatic-webflow-ecommerce-template.jpg" alt="" style="opacity: 1; filter: blur(0px);" sizes="(max-width: 767px) 92vw, (max-width: 1439px) 86vw, 1118px" data-w-id="9f4d1131-f255-c237-25bf-d393edb46f2a" loading="eager">
            </div>
        </section>
    </div>

    <div data-w-id="6bb2631d-8226-c422-0ba3-4602f716ae36" style="opacity: 1; filter: blur(0px);"
        class="w-layout-blockcontainer container-default w-container">
        <div class="divider mg-0"></div>
    </div>

    <!-- @include('components.guest.companies-supported') -->

    @include('components.guest.why-us')

    @include('components.guest.features')

    @include('components.guest.take-away-attributes')

    @include('components.guest.how-it-works')

    <!-- @include('components.guest.testimonies') -->

    @include('components.guest.core-concepts')

    


    <!-- @include('components.guest.plans-overview') -->


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