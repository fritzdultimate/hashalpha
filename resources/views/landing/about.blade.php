@extends('layouts.guest')

@section('content')

    <section class="top-section halpha-py-16 md:halpha-py-32">

        <div class="w-layout-blockcontainer container-default z-index-1 w-container">
            <div class="text-center mg-bottom-40px halpha-flex halpha-flex-col halpha-gap-5">
                <div data-w-id="a4708a42-280d-b422-b575-8ac43cd058e5" style="opacity: 1; filter: blur(0px);"
                    class="inner-container _764px center">
                    <h1 class="display-1 heading-color-gradient mg-bottom-0">
                        Building the Infrastructure Layer of Web3
                    </h1>
                </div>
                <div data-w-id="c16957c9-54cf-1436-610a-b7a81345da1f" style="opacity: 1; filter: blur(0px);"
                    class="inner-container _694px center">
                    <p class="!halpha-text-gray-500 halpha-text-xl">
                        {{ env('APP_LONG_NAME') }} operates institutional-grade Ethereum validators and MEV-boosted infrastructure, enabling transparent and sustainable staking for users worldwide.
                    </p>
                </div>
            </div>


            <div data-w-id="5efe5cb4-a493-305f-011b-7f8e173d14a6" style="opacity: 1; filter: blur(0px);"
                class="buttons-flex-container center !halpha-hidden">
                <div data-w-id="5efe5cb4-a493-305f-011b-7f8e173d14a7" class="btn-primary-wrapper">
                    <a href="{{ route('register') }}" class="btn-primary w-button">
                        Get Started
                        <span class="line-rounded-icon link-icon-right" style=""></span></a>
                    <div class="btn-primary-border"></div>
                </div>
            </div>


            <div class="stats-container top-section-stats---bottom">
                <div data-w-id="b96e75cf-9174-8eb9-04d2-e2e1e253228d" style="opacity: 1; filter: blur(0px);"
                    class="text-center pd-24px-mbl pd-0-mbp">
                    <div class="display-3">99.9%</div>
                    <div class="halpha-text-gray-300">Infrastructure Uptime</div>
                </div>
                <div data-w-id="b96e75cf-9174-8eb9-04d2-e2e1e2532292" style="opacity: 1; filter: blur(0px);"
                    class="divider-vertical mg-0-mbl horizontal-mbp"></div>
                <div data-w-id="b96e75cf-9174-8eb9-04d2-e2e1e2532293" style="opacity: 1; filter: blur(0px);"
                    class="text-center pd-24px-mbl pd-0-mbp">
                    <div class="display-3">Distributed Validator</div>
                    <div class="halpha-text-gray-300">Operations</div>
                </div>
                <div id="w-node-b96e75cf-9174-8eb9-04d2-e2e1e2532298-75ed753f"
                    data-w-id="b96e75cf-9174-8eb9-04d2-e2e1e2532298" style="opacity: 1; filter: blur(0px);"
                    class="divider-vertical horizontal-mbl"></div>
                <div data-w-id="b96e75cf-9174-8eb9-04d2-e2e1e2532299" style="opacity: 1; filter: blur(0px);"
                    class="text-center pd-24px-mbl pd-0-mbp">
                    <div class="display-3">Protocol-Level Network</div>
                    <div class="halpha-text-gray-300">Participation</div>
                </div>
                <div data-w-id="b96e75cf-9174-8eb9-04d2-e2e1e253229e" style="opacity: 1; filter: blur(0px);"
                    class="divider-vertical mg-0-mbl horizontal-mbp"></div>
                <div data-w-id="b96e75cf-9174-8eb9-04d2-e2e1e253229f" style="opacity: 1; filter: blur(0px);"
                    class="text-center pd-24px-mbl pd-0-mbp">
                    <div class="display-3">Multi Region Validator</div>
                    <div class="halpha-text-gray-300">Coverage</div>
                </div>
            </div>
            <div data-w-id="c7f7bb0a-2217-b59e-4776-c51e51c2affa" style="opacity: 1; filter: blur(0px);"
                class="top-section---large-image-bottom-wrapper">
                <img
                    src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64e7c3049bfe71135fbda564_about-hero-image-cryptomatic-webflow-ecommerce-template.jpg"
                    loading="eager"
                    sizes="(max-width: 479px) 82vw, (max-width: 767px) 85vw, (max-width: 991px) 95vw, (max-width: 1439px) 96vw, 1112px"
                    alt="Our Main Mission Is To Democratize Finance - Cryptomatic X Webflow Template"></div>
        </div>
    </section>

    @include('components.guest.our-story')
    @include('components.guest.our-values')
    <!-- @include('components.guest.why-us') -->
    <!-- @include('components.guest.our-team') -->
    <!-- @include('components.guest.testimonies') -->



@endsection