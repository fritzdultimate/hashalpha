<section class="container halpha-py-16 md:halpha-py-32">
    <div class="container-default w-container">
        <div class="heading-and-content-grid mg-bottom-24px">
            <div class="inner-container _564px _100-tablet">
                <h2 class="display-2 heading-color-gradient mg-bottom-0">
                    Why {{ env('APP_NAME') }} Exists
                </h2>
                <p class="color-neutral-100 mg-bottom-24px !halpha-text-gray-400">
                    Blockchain networks are becoming the backbone of global digital Infrastructure - yet access to the economic layer behind them remains fragmented and complex.

                </p>

                <p class="color-neutral-100 mg-bottom-24px !halpha-text-gray-400">
                    {{ env('APP_NAME') }} exists to bridge that gap.

                </p>

                <p class="color-neutral-100 mg-bottom-24px !halpha-text-gray-400">
                    We build and operate a diversified blockchain infrastructure engine — expanding beyond validator operations into delegation services, node hosting, and performance-driven infrastructure strategies — transforming professional-grade digital asset infrastructure into accessible participation.

                </p>
            </div>
        </div>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 lg:halpha-grid-cols-3 halpha-gap-6">
            @php
                $features = [
                    [
                        'title' => 'Institutional-Grade Infrastructure Engine', 
                        'text' => [
                            'Enterprise validator operations, geographically distributed node architecture, institutional delegation channels, and scalable infrastructure services designed for performance, uptime, and long-term resilience.',
                            'Our infrastructure layer continues to expand as capacity grows — aligning revenue generation with real network contribution.'
                        ], 
                        'img' => asset('images/landing/easy-to-create-wallet-circle-image.png')
                    ],
                    [
                        'title' => 'Multi-Vertical Revenue Model', 
                        'text' => [
                            'Revenue is generated across diversified infrastructure channels, including:',
                            [
                                'Ethereum validator rewards',
                                'MEV optimization and block execution strategies',
                                'Institutional delegation service fees',
                                'Enterprise node hosting subscriptions',
                                'Performance-based infrastructure strategies'
                            ],
                            'This diversified model strengthens scalability and reduces reliance on a single revenue source.'
                        ], 
                        'img' => asset('images/landing/send-and-receive-circle-image.png')
                    ],
                    [
                        'title' => 'Digital Infrastructure Identity (V-NFTs & $HASH)', 
                        'text' => [
                            'A utility-driven ecosystem of digital infrastructure credentials and governance tools designed to support participation, alignment, and long-term ecosystem growth.'
                        ], 
                        'img' => asset('images/landing/floating-bg-shape-3.jpg')
                    ], 
                    [
                        'title' => 'Global Partner Ecosystem', 
                        'text' => [
                            'A structured, performance-aligned partner program that rewards responsible network expansion — built to support sustainable scaling rather than short-term incentives.'
                        ], 
                        'img' => asset('images/landing/floating-bg-shape-3.jpg')
                    ]
                ];
            @endphp

            @foreach($features as $f)
                <article
                    class="halpha-relative halpha-rounded-[20px] halpha-p-4 md:halpha-p-6 halpha-bg-[#0b0d10] halpha-flex halpha-gap-4 halpha-items-start">
                    <img src="{{ $f['img'] }}" alt="{{ $f['title'] }}"
                        class="halpha-w-12 halpha-h-12 md:halpha-w-14 md:halpha-h-14 halpha-object-cover halpha-flex-shrink-0">
                    <div class="halpha-flex-1">
                        <h3 class="halpha-text-lg md:halpha-text-xl halpha-font-semibold halpha-text-white">
                            {{ $f['title'] }}</h3>
                        <div>
                            @foreach ($f['text'] as $text)
                                @if (is_array($text))
                                    <ul class="halpha-list-disc">
                                        @foreach ($text as $t)
                                            <li class="halpha-text-gray-300 halpha-text-sm">{{ $t }}</li>
                                        @endforeach
                                    </ul>

                                    @continue
                                @endif
                                <p class="halpha-text-sm md:halpha-text-base halpha-text-gray-300 halpha-mt-2">
                                    {{ $text }}
                                </p>  
                            @endforeach
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>