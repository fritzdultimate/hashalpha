<section class="container halpha-py-16 md:halpha-py-32">
    <div class="container-default w-container">
        <div class="heading-and-content-grid mg-bottom-24px">
            <div class="inner-container _564px _100-tablet">
                <h2 class="display-2 heading-color-gradient mg-bottom-0">Why {{ env('APP_LONG_NAME') }}</h2>
                <p class="color-neutral-100 mg-bottom-24px !halpha-text-gray-400">Secure validator infrastructure,
                    transparent payouts, industry-grade operations — built for long-term staking yield.</p>
            </div>
        </div>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 lg:halpha-grid-cols-3 halpha-gap-6">
            @php
                $features = [
                    ['title' => 'Institutional Validator Ops', 'text' => 'Hardware-grade nodes, redundant validators, 99.9% uptime SLA.', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d51de3958bb0587e6e8a80_easy-to-create-wallet-circle-image-cryptomatic-webflow-ecommerce-template.png'],
                    ['title' => 'MEV-Boost Integration', 'text' => 'MEV-boost enabled to improve proposer revenue while remaining compliant.', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c058/64e3bc5e1a7dcf1cadcefa4e_ethereum-tokens-2025-blog-thumbnail-v1-cryptomatic-webflow-ecommerce-template.jpg'],
                    ['title' => 'Automated Payouts', 'text' => 'Daily settlement engine and clear payout schedule with on-chain proof.', 'img' => 'https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dac102eb9789e6c7dbb45d_floating-bg-shape-3-cryptomatic-webflow-ecommerce-template.jpg'],
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