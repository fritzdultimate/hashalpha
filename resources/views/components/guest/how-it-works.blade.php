<section class="section">
    <div class="w-layout-blockcontainer container-default w-container">
        <div class="heading-and-content-grid mg-bottom-32px">
            <div id="w-node-_842d6593-77bf-0612-6737-8260bf2447fb-bd0d2b38"
                data-w-id="842d6593-77bf-0612-6737-8260bf2447fb" style="opacity: 1; filter: blur(0px);"
                class="inner-container _604px _100-tablet">
                <h2 class="display-2 heading-color-gradient mg-bottom-0">
                    How does {{ env('APP_NAME') }} work?
                </h2>
            </div>
        </div>

        <div class="grid-2-columns gap-row-64px">
            <div data-w-id="7461cf72-8e3d-e1fb-68d0-073db3cb7445" style="opacity: 1; filter: blur(0px);"
                class="max-w-540px">
                <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d67758c9670a06dc2e1e00_cryptomatic-app-image-cryptomatic-webflow-ecommerce-template.png"
                    loading="eager"
                    sizes="(max-width: 479px) 100vw, (max-width: 767px) 92vw, (max-width: 991px) 46vw, (max-width: 1439px) 47vw, 540px"
                    alt="How Does Cryptomatic App Work - Cryptomatic X Webflow Template">
            </div>

            <div id="w-node-_8b3978d1-4458-f5aa-7def-32b724eece21-bd0d2b38" class="inner-container _600px _100-tablet halpha-w-full">

                @php
                    $steps = [
                        [
                            'title' => 'Create an Account',
                            'description' => 'Sign up in seconds and secure your profile with advanced encryption — your data and assets
                            stay protected from the start.',
                            'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d539504d98654e1c7fa66f_create-an-account-circle-icon-cryptomatic-webflow-ecommerce-template.png'
                        ],
                        [
                            'title' => 'Invest on Blockchain',
                            'description' => 'Choose a plan, stake your assets, and start earning through our decentralized validator network with full transparency.',
                            'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d51de3958bb0587e6e8a80_easy-to-create-wallet-circle-image-cryptomatic-webflow-ecommerce-template.png'
                        ],
                        [
                            'title' => 'Track and Earn',
                            'description' => 'Monitor your portfolio growth in real time, withdraw rewards anytime, and enjoy consistent returns backed by blockchain reliability.',
                            'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d51de3df0f41b21172d648_earn-passively-circle-image-cryptomatic-webflow-ecommerce-template.png'
                        ]
                    ]
                @endphp

                @foreach ($steps as $step)
                    <div x-data="{ open: false }" class="halpha-bg-card-bg halpha-overflow-hidden halpha-transition-all halpha-duration-300 accordion-item-wrapper !halpha-flex-col halpha-w-full">
                        <!-- Header -->
                        <button @click="open = !open"
                            class="halpha-flex halpha-items-center halpha-justify-between halpha-w-full halpha-py-3 halpha-text-left focus:halpha-outline-none hover:halpha-bg-accent-2-darker accordion-header">
                            <div class="halpha-flex halpha-items-center halpha-gap-3">
                                <img src="{{ $step['img'] }}"
                                    alt="Create an Account" class="max-w-48px max-w-40px-mbl" loading="lazy">
                                <h3 class="accordion-title">
                                    {{ $step['title'] }}
                                </h3>
                            </div>
                            <div
                                class="halpha-relative halpha-w-5 halpha-h-5 halpha-flex halpha-items-center halpha-justify-center">
                                <span
                                    class="halpha-absolute halpha-w-3.5 halpha-h-0.5 halpha-bg-gray-300 halpha-rounded halpha-transition-transform halpha-duration-300"
                                    :class="open ? 'halpha-rotate-45' : ''"></span>
                                <span
                                    class="halpha-absolute halpha-w-3.5 halpha-h-0.5 halpha-bg-gray-300 halpha-rounded halpha-transition-transform halpha-duration-300"
                                    :class="open ? '-halpha-rotate-45' : 'halpha-rotate-90'"></span>
                            </div>
                        </button>

                        <!-- Body -->
                        <div x-show="open" x-collapse
                            x-transition:enter="halpha-transition halpha-ease-out halpha-duration-300"
                            x-transition:enter-start="halpha-opacity-0 halpha-translate-y-2"
                            x-transition:enter-end="halpha-opacity-100 halpha-translate-y-0"
                            x-transition:leave="halpha-transition halpha-ease-in halpha-duration-200"
                            x-transition:leave-start="halpha-opacity-100 halpha-translate-y-0"
                            x-transition:leave-end="halpha-opacity-0 halpha-translate-y-2"
                            class="halpha-px-4 halpha-pb-4 halpha-text-sm halpha-text-muted">
                            <p class="halpha-text-lg halpha-text-gray-400 halpha-ml-10">
                                {{ $step['description'] }}
                            </p>
                        </div>
                    </div>

                    <div data-w-id="8b3978d1-4458-f5aa-7def-32b724eece30" style="opacity: 1; filter: blur(0px);"
                    class="divider _48px"></div>
                @endforeach

            </div>
        </div>
    </div>
</section>