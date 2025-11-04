@extends('layouts.guest')

@section('content')
    <div class="top-section top-section-bg-img-center dfloating-shapes-section---content">
        <div class="container-default w-container">
            <div class="grid-2-columns _1-col-tablet gap-row-8px">
                <div data-w-id="bc6f8e73-abc8-b69a-68e1-73c6d3a67216" style="opacity: 1; filter: blur(0px);"
                    class="inner-container _558px _100-tablet">
                    <h1 class="display-2 heading-color-gradient mg-bottom-0 halpha-uppercase">
                        {{ env('APP_LONG_NAME') }}, THE BACKBONE OF BLOCKCHAIN
                    </h1>
                </div>
                <div id="w-node-_64d41687-720e-ca5c-a050-26b768b07fcc-04e3ff82"
                    data-w-id="64d41687-720e-ca5c-a050-26b768b07fcc" style="opacity: 1; filter: blur(0px);"
                    class="inner-container _504px _100-tablet">
                    <p class="color-neutral-100 mg-bottom-32px !halpha-text-gray-400">
                        {{ env('APP_LONG_NAME') }}, the operational brand of {{ env('APP_NAME') }} Ltd - a legally registered blockchain infrastructure company - enables you to earn daily from the backbone of blockchain through validator nodes and masternodes powering web3.
                    </p>
                    <div class="buttons-flex-container">
                        <div data-w-id="64d41687-720e-ca5c-a050-26b768b07fd0" class="btn-primary-wrapper">
                            <a href="{{ route('login') }}" class="btn-primary w-button">
                                {{ env('APP_LINK') }}
                                <span class="line-rounded-icon link-icon-right" style=""></span>
                            </a>

                            <div class="btn-primary-border"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dac102eb9789e6c7dbb45d_floating-bg-shape-3-cryptomatic-webflow-ecommerce-template.jpg" loading="eager" sizes="(max-width: 479px) 56vw, (max-width: 767px) 19vw, (max-width: 991px) 16vw, 160px" srcset="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dac102eb9789e6c7dbb45d_floating-bg-shape-3-cryptomatic-webflow-ecommerce-template-p-500.jpg 500w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dac102eb9789e6c7dbb45d_floating-bg-shape-3-cryptomatic-webflow-ecommerce-template.jpg 640w" alt="" class="floating-bg-shape _04 !halpha-top-[170px] !halpha-rotate-[22deg] !halpha-blur-[5px]">

        <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d6542870a418ff73139219_floating-bg-shape-2-cryptomatic-webflow-eocmmerce-template.jpg" loading="eager" sizes="(max-width: 479px) 62vw, (max-width: 767px) 21vw, (max-width: 991px) 20vw, 198px" srcset="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d6542870a418ff73139219_floating-bg-shape-2-cryptomatic-webflow-eocmmerce-template-p-500.jpg 500w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d6542870a418ff73139219_floating-bg-shape-2-cryptomatic-webflow-eocmmerce-template.jpg 792w" alt="" class="floating-bg-shape _05 !halpha-right-[8%] !halpha-top-[45px]">

        <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dac102eb9789e6c7dbb45d_floating-bg-shape-3-cryptomatic-webflow-ecommerce-template.jpg" loading="eager" sizes="(max-width: 479px) 56vw, (max-width: 767px) 19vw, (max-width: 991px) 16vw, 160px" srcset="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dac102eb9789e6c7dbb45d_floating-bg-shape-3-cryptomatic-webflow-ecommerce-template-p-500.jpg 500w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dac102eb9789e6c7dbb45d_floating-bg-shape-3-cryptomatic-webflow-ecommerce-template.jpg 640w" alt="" class="floating-bg-shape _11 halpha-scale-x-[-1] !halpha-blur-[5px]">
        
    </div>

    @include('components.guest.core-concepts')

    @include('components.guest.why-us')


    @include('components.guest.plans-overview')


    {{-- 3) How it works — responsive 3-step --}}
    <section class="halpha-py-16 md:halpha-py-32">
        <div class="container-default w-container">
            <div class="heading-and-content-grid mg-bottom-24px">
                <div class="inner-container _564px _100-tablet">
                    <h2 class="display-2 heading-color-gradient mg-bottom-0">How it works</h2>
                    <p class="color-neutral-100 mg-bottom-16px !halpha-text-gray-400">
                        From deposit to daily earnings — simple, transparent steps.
                    </p>
                </div>
            </div>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-6">
                <div class="halpha-text-center halpha-p-6 halpha-rounded-[20px] halpha-bg-[#07121a]">
                    <div class="halpha-text-2xl halpha-font-bold halpha-text-gray-500">1</div>
                    <h4 class="halpha-mt-3 halpha-text-white">Deposit</h4>
                    <p class="halpha-text-sm halpha-text-gray-300">Fund your account using card, bank transfer or crypto.</p>
                </div>
                <div class="halpha-text-center halpha-p-6 halpha-rounded-[20px] halpha-bg-[#07121a]">
                    <div class="halpha-text-2xl halpha-font-bold halpha-text-gray-500">2</div>
                    <h4 class="halpha-mt-3 halpha-text-white">Stake / Pool</h4>
                    <p class="halpha-text-sm halpha-text-gray-300">Your funds join our validator pool or assigned slot depending on plan.</p>
                </div>
                <div class="halpha-text-center halpha-p-6 halpha-rounded-[20px] halpha-bg-[#07121a]">
                    <div class="halpha-text-2xl halpha-font-bold halpha-text-gray-500">3</div>
                    <h4 class="halpha-mt-3 halpha-text-white">Earn & Withdraw</h4>
                    <p class="halpha-text-sm halpha-text-gray-300">Daily payouts, proof of stake reporting, and easy withdrawals.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 4) Transparency (responsive KPIs + CTA) --}}
    <section class="halpha-bg-[rgba(255,255,255,0.02)]">
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
            <a href="/transparency/validator-explorer" class="btn-primary w-full sm:!halpha-w-auto">Open Validator Explorer</a>
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
                            <h5 class="halpha-text-white halpha-font-semibold">Validator expansion</h5>
                            <p class="halpha-text-sm halpha-text-gray-300">
                                Add 50+ new high-availability validators across regions.
                            </p>
                        </div>
                    </div>

                    <div class="halpha-flex halpha-gap-4">
                        <div class="halpha-w-10 halpha-text-center halpha-text-white">Q2</div>
                        <div>
                            <h5 class="halpha-text-white halpha-font-semibold">MEV improvements</h5>
                            <p class="halpha-text-sm halpha-text-gray-300">
                                MEV revenue sharing model refinement and auditor review.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="halpha-space-y-6">
                    <div class="halpha-flex halpha-gap-4">
                        <div class="halpha-w-10 halpha-text-center halpha-text-white">Q3</div>
                        <div>
                            <h5 class="halpha-text-white halpha-font-semibold">Mobile dashboard</h5>
                            <p class="halpha-text-sm halpha-text-gray-300">
                                Release mobile app for dashboard, withdrawals and notifications.
                            </p>
                        </div>
                    </div>

                    <div class="halpha-flex halpha-gap-4">
                        <div class="halpha-w-10 halpha-text-center halpha-text-white">Q4</div>
                        <div>
                            <h5 class="halpha-text-white halpha-font-semibold">Institutional products</h5>
                            <p class="halpha-text-sm halpha-text-gray-300">
                                Launch tailored SLAs and escrow integrations for partners.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.guest.team')

    @include('components.guest.faqs')


@endsection