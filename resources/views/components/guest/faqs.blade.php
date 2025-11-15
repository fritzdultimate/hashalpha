
<section class="halpha-bg-[rgba(255,255,255,0.01)]">
    <div class="container-default w-container">
        <div class="heading-and-content-grid mg-bottom-24px">
            <div class="inner-container _564px _100-tablet">
                <h2 class="display-2 heading-color-gradient mg-bottom-0">FAQ</h2>
                <p class="color-neutral-100 mg-bottom-16px !halpha-text-gray-400">
                    Quick answers to common questions.
                </p>
            </div>
        </div>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6">
            @php
                $active = isset($showing) ? $showing : 10;
                $faqs = [
                    [
                        'q' => 'How do I verify the validators?',
                        'a' => 'You can check all our validators on public Ethereum explorers like BeaconScan and Beaconcha.in. We provide each validator’s information so you can confirm they are real and active on the blockchain.'
                    ],
                    [
                        'q' => 'How are rewards generated?',
                        'a' => 'Rewards come from the normal work validators do on Ethereum, such as: confirming transactions, proposing blocks, staying online'
                    ],
                    [
                        'q' => 'What is MEV?',
                        'a' => 'MEV (Maximal Extractable Value) is extra income earned when validators include certain profitable transactions in a block. It increases your staking rewards without adding extra risk.'
                    ],
                    [
                        'q' => 'How does the affiliate system work?',
                        'a' => 'You get a referral link. When someone signs up and invests using your link, you earn a commission from their plan. The more people you invite, the more you earn.'
                    ],
                    [
                        'q' => 'How is my crypto secured?',
                        'a' => 'Your crypto stays on the Ethereum blockchain and is staked safely inside the official staking contract. Validator keys are stored securely, and we use strict protection to prevent slashing, misuse, or unauthorized access.'
                    ]
                ]
            @endphp

            @foreach ($faqs as $faq)
                @continue($loop->index >= $active)
                <div>
                    <h5 class="halpha-text-white halpha-font-semibold">{{ $faq['q'] }}</h5>
                    <p class="halpha-text-sm halpha-text-gray-300">
                        {{ $faq['a'] }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="halpha-mt-6">
            <a href="/support" class="btn-primary w-button">See full FAQ & Support</a>
        </div>
    </div>
</section>