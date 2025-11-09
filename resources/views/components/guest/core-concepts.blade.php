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
                            'Every process, from validation to reward distribution, is open and verifiable. We maintain full visibility in how funds move and how returns are generated, ensuring lasting trust with our community.', 
                            'We believe everyone should have the power to grow and control their own digital assets without relying on intermediaries. Our platform is built to give investors full ownership and participation in decentralized systems.', 
                            'We continuously adopt cutting-edge blockchain technologies to improve performance, security, and returns. Our commitment to innovation keeps us — and our investors — ahead in the evolving digital finance landscape.'
                        ] //dummy
                    @endphp
                    @foreach ($concepts as $concept)
                        <li data-w-id="60cd25b4-2ff9-8574-64f5-ad4d432d7346d"
                            class="halpha-relative halpha-rounded-[24px] halpha-p-4 md:halpha-p-4 halpha-py-6 halpha-w-full">
                            <div class="divider inside-card---top"></div>
                            <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64e7eb2aef37364669954a14_features-card-bg-top-cryptomatic-webflow-ecommerce-template.png"
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
                src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c058/64e3bc5e1a7dcf1cadcefa4e_ethereum-tokens-2025-blog-thumbnail-v1-cryptomatic-webflow-ecommerce-template.jpg"
                sizes="(max-width: 479px) 100vw, (max-width: 767px) 95vw, (max-width: 991px) 46vw, (max-width: 1439px) 47vw, 620px"
                class="link-item-dark-image border-radius-24px mg-bottom-40px"
                style="filter: saturate(100%) contrast(100%);">
        </div>
    </div>
</section>