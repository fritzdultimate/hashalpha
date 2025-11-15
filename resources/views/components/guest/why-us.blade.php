<section class="container halpha-py-16 md:halpha-py-32">
    <div class="container-default w-container">
        <div class="heading-and-content-grid mg-bottom-24px">
            <div class="inner-container _564px _100-tablet">
                <h2 class="display-2 heading-color-gradient mg-bottom-0">
                    Why {{ env('APP_NAME') }} Exists
                </h2>
                <p class="color-neutral-100 mg-bottom-24px !halpha-text-gray-400">
                    The world runs on blockchain infrastructure, and Ethereum stands at the center of it. HashAlpha Global provides direct access to the validator economy — the same infrastructure large institutions rely on to secure billions in value. We combine enterprise-grade node operations, transparent reporting, and a global reward system to bring validator-level income to everyday users.
                </p>
            </div>
        </div>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 lg:halpha-grid-cols-3 halpha-gap-6">
            @php
                $features = [
                    ['title' => 'Institutional Validator Infrastructure', 'text' => 'Enterprise-grade ETH validators operating across multiple Tier-4 data centers with MEV-boosted performance.', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d51de3958bb0587e6e8a80_easy-to-create-wallet-circle-image-cryptomatic-webflow-ecommerce-template.png'],
                    ['title' => 'Real Daily Staking Rewards', 'text' => 'Rewards sourced directly from Ethereum’s Proof-of-Stake issuance and MEV relay optimization.', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d51de38b5b8b51a375978a_send-and-receive-circle-image-cryptomatic-webflow-ecommerce-template.png'],
                    ['title' => 'Bulletproof Transparency', 'text' => 'Live validator keys, on-chain activity, uptime metrics, and monthly operational reports.', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dac102eb9789e6c7dbb45d_floating-bg-shape-3-cryptomatic-webflow-ecommerce-template.jpg'], ['title' => 'Global Affiliate Ecosystem', 'text' => 'A structured multi-tier partner program that rewards network growth sustainably and transparently.', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dac102eb9789e6c7dbb45d_floating-bg-shape-3-cryptomatic-webflow-ecommerce-template.jpg']
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