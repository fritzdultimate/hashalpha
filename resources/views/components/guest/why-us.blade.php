<section class="container halpha-py-16 md:halpha-py-32">
    <div class="container-default w-container">
        <div class="heading-and-content-grid mg-bottom-24px">
            <div class="inner-container _564px _100-tablet">
                <h2 class="display-2 heading-color-gradient mg-bottom-0">
                    Why {{ env('APP_NAME') }} Exists
                </h2>
                <p class="color-neutral-100 mg-bottom-24px !halpha-text-gray-400">
                    Blockchain has become critical infrastructure, yet accessing the economics behind it remains complex and inaccessible for most people. HashAlpha exists to bridge that gap — operating validator infrastructure and exposing it through a structured, transparent platform for participation and growth.

                </p>
            </div>
        </div>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 lg:halpha-grid-cols-3 halpha-gap-6">
            @php
                $features = [
                    [
                        'title' => 'Institutional Validator Infrastructure', 
                        'text' => 'Enterprise-grade ETH validators operating across multiple Tier-4 data centers with MEV-boosted performance.', 
                        'img' => asset('images/landing/easy-to-create-wallet-circle-image.png')
                    ],
                    [
                        'title' => 'Real Daily Staking Rewards', 
                        'text' => 'Rewards sourced directly from Ethereum’s Proof-of-Stake issuance and MEV relay optimization.', 'img' => asset('images/landing/send-and-receive-circle-image.png')
                    ],
                    [
                        'title' => 'Digital Infrastructure Identity (V-NFTs & $HASH)', 
                        'text' => 'A layered ecosystem of validator credentials and utility tokens designed to power long-term participation, access, and governance.', 
                        'img' => asset('images/landing/floating-bg-shape-3.jpg')
                    ], 
                    [
                        'title' => 'Global Affiliate Ecosystem', 
                        'text' => 'A structured multi-tier partner program that rewards network growth sustainably and transparently.', 
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
                        <p class="halpha-text-sm md:halpha-text-base halpha-text-gray-300 halpha-mt-2">{{ $f['text'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>