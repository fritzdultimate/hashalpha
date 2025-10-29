@extends('layouts.guest')

@section('title', 'Frequently Asked Questions')

@section('content')
    <section class="halpha-pt-10">
        <div class="w-layout-blockcontainer container-default w-container">
            <div data-w-id="5f2a25f3-4b9d-f871-1f58-aa6a06d6f117" style="opacity: 1; filter: blur(0px);"
                class="text-center mg-bottom-48px">
                <div class="inner-container _470px center">
                    <h2 class="display-2 mg-bottom-0">Frequently asked questions</h2>
                    <p class="color-neutral-300">
                        Lorem ipsum dolor sit amet consectetur adipiscing elit arcu cras posuere
                        gravida neque felis lorem.
                    </p>
                </div>
            </div>
            <div data-w-id="d8ed2722-29c2-7bf9-4472-af3aa87ac732" style="opacity: 1; filter: blur(0px);"
                class="card faqs-card">
                <img
                    src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff2505220ff8b852ecfc4_faqs-card-gradient-top-cryptomatic-webflow-ecommerce-template.png"
                    loading="eager" sizes="(max-width: 479px) 93vw, (max-width: 767px) 95vw, (max-width: 991px) 94vw, 890px"
                    srcset="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff2505220ff8b852ecfc4_faqs-card-gradient-top-cryptomatic-webflow-ecommerce-template-p-500.png 500w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff2505220ff8b852ecfc4_faqs-card-gradient-top-cryptomatic-webflow-ecommerce-template-p-800.png 800w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff2505220ff8b852ecfc4_faqs-card-gradient-top-cryptomatic-webflow-ecommerce-template-p-1080.png 1080w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff2505220ff8b852ecfc4_faqs-card-gradient-top-cryptomatic-webflow-ecommerce-template.png 1784w"
                    alt="" class="bg-gradient-top"
                >
                <div class="divider inside-card---top"></div>

                @foreach ($faqs as $id => $faq)
                    <div data-w-id="d8ed2722-29c2-7bf9-4472-af3aa87ac733" class="accordion-item-wrapper" x-data="{ open: false }">
                        <div class="accordion-content-wrapper">
                            <div class="accordion-header" @click="open = !open" >
                                <h3 class="display-4">{{ $faq['q'] }}</h3>
                                <div class="accordion-icon-wrapper">
                                    <div class="accordion-btn-line horizontal"></div>
                                    <div class="accordion-btn-line vertical x-cloak" x-show="!open"></div>
                                </div>
                            </div>
                            <div 
                                class="halpha-overflow-hidden halpha-text-gray-400 halpha-text-sm acordion-body x-cloak"
                                x-show="open"
                                x-transition:enter="halpha-transition-all halpha-duration-300 halpha-ease-out"
                                x-transition:enter-start="halpha-opacity-0 halpha-translate-y-5 halpha-scale-[0.96] halpha-max-h-0"
                                x-transition:enter-end="halpha-opacity-100 halpha-translate-y-0 halpha-scale-100 halpha-max-h-[500px]"
                                x-transition:leave="halpha-transition-all halpha-duration-300 halpha-ease-in"
                                x-transition:leave-start="halpha-opacity-100 halpha-translate-y-0 halpha-scale-100 halpha-max-h-[500px]"
                                x-transition:leave-end="halpha-opacity-0 halpha-translate-y-5 halpha-scale-[0.96] halpha-max-h-0"
                            >
                                <div class="accordion-spacer"></div>
                                <div class="inner-container _640px">
                                    <p class="mg-bottom-0 halpha-text-gray-300">
                                        {{ $faq['a'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ( $id < (collect($faqs)->count() - 1))
                        <div class="divider _48px"></div>
                    @endif
                @endforeach

                <div class="divider inside-card---bottom"></div>
                <img
                    src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff250d9f2b6bb259e1cf9_faqs-card-gradient-bottom-cryptomatic-webflow-ecommerce-template.png"
                    loading="eager" sizes="(max-width: 479px) 93vw, (max-width: 767px) 95vw, (max-width: 991px) 94vw, 890px"
                    srcset="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff250d9f2b6bb259e1cf9_faqs-card-gradient-bottom-cryptomatic-webflow-ecommerce-template-p-500.png 500w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff250d9f2b6bb259e1cf9_faqs-card-gradient-bottom-cryptomatic-webflow-ecommerce-template-p-800.png 800w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff250d9f2b6bb259e1cf9_faqs-card-gradient-bottom-cryptomatic-webflow-ecommerce-template-p-1080.png 1080w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dff250d9f2b6bb259e1cf9_faqs-card-gradient-bottom-cryptomatic-webflow-ecommerce-template.png 1784w"
                    alt="" class="bg-gradient-bottom"
                >
            </div>
        </div>
    </section>
@endsection