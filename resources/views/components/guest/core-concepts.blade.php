<section class="container pd-top-0">
    <div class="w-layout-blockcontainer container-default w-container">
        <div class="heading-and-content-grid mg-bottom-32px mg-bottom-48px-tablet">
            <div data-w-id="cc462d31-5306-fc83-d41c-ee8c7156a272" style="opacity: 1; filter: blur(0px);"
                class="inner-container _564px _100-tablet">
                <h2 class="display-2 heading-color-gradient mg-bottom-0">
                    Core Concept
                </h2>
            </div>
        </div>
        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-10">
            <div id="w-node-_674dba64-9d5a-dd21-5440-010de02acb6e-04e3ff82" class="halpha-w-full">
                <ul class="halpha-flex halpha-flex-col halpha-gap-5 halpha-w-full !halpha-pl-0">
                    @php
                        $concepts = [
                            'Each deposit contributes to HashAlpha’s diversified blockchain infrastructure engine — spanning validator operations, institutional delegation, node hosting, and performance-driven infrastructure strategies.', 
                            'Revenue is generated across multiple infrastructure verticals, including Ethereum consensus rewards, MEV optimization, delegation service fees, and enterprise infrastructure services.', 
                            'Infrastructure revenue is aggregated, risk-managed, and allocated to participant pools based on plan structure, lock-up period, and overall infrastructure performance',
                            'Distributions are backed by real on-chain activity and operational output — aligned with scaling capacity and network conditions.'
                        ]
                    @endphp
                    @foreach ($concepts as $concept)
                        <li data-w-id="60cd25b4-2ff9-8574-64f5-ad4d432d7346d"
                            class="halpha-relative halpha-rounded-[24px] halpha-p-4 md:halpha-p-4 halpha-py-6 halpha-w-full">
                            <div class="divider inside-card---top"></div>
                            <img src="{{ asset('images/landing/features-card-bg-top.png') }}"
                                loading="eager"
                                sizes="(max-width: 479px) 93vw, (max-width: 991px) 95vw, (max-width: 1439px) 96vw, 1268px"
                                alt="" class="bg-gradient-top">

                            <div
                                class="halpha-flex halpha-justify-between halpha-items-center halpha-gap-5 md:halpha-gap-10">
                               

                                <p class="halpha-text-sm md:halpha-text-base halpha-leading-6 halpha-text-gray-300">
                                    {{ $concept }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <img loading="eager" alt="5 new interesting Ethereum tokens you should pay attention to in 2025"
                src="{{ asset('images/landing/ethereum-tokens-2025-blog-thumbnail-v1.jpg') }}"
                sizes="(max-width: 479px) 100vw, (max-width: 767px) 95vw, (max-width: 991px) 46vw, (max-width: 1439px) 47vw, 620px"
                class="link-item-dark-image border-radius-24px mg-bottom-40px"
                style="filter: saturate(100%) contrast(100%);">
        </div>
    </div>
</section>