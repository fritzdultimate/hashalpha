@extends('layouts.guest')

@section('content')

    @include('components.guest.referral-bonus-hero')

    @include('components.guest.referral-bonus-distribution')

    @include('components.guest.team-performance')

    <!-- Yield Strategy & Payout Schedule -->
    <section id="yield" class="halpha-py-5 md:halpha-py-12 halpha-bg-[rgba(255,255,255,0.01)]">
        <div class="container-default w-container">
            <div class="inner-container _608px _100-tablet">
                <h2 class="display-2 heading-color-gradient">Yield Strategy & Payout Schedule</h2>
                <p class="!halpha-text-gray-400">We combine protocol block rewards, MEV revenue and an operational model to deliver regular payouts. Below is an example schedule and sample calculation.</p>
            </div>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6 halpha-mt-6">
                <div>
                    <h4 class="halpha-text-white halpha-font-semibold">Payout cadence</h4>
                    <ul class="halpha-list-none halpha-space-y-2 halpha-text-sm halpha-text-gray-300">
                        <li>Daily aggregation of earned rewards → user balances updated every 24 hours.</li>
                        <li>Auto-compound option available for Pro and Institutional plans.</li>
                        <li>Withdrawals processed within 24–72 hours (subject to plan liquidity).</li>
                    </ul>

                    <h4 class="halpha-text-white halpha-font-semibold halpha-mt-4">Sample calculation</h4>
                    <pre class="halpha-bg-[#07121a] halpha-p-3 halpha-rounded-[8px] halpha-text-sm halpha-text-gray-300">
Example: $1,000 in Pro (9% APY)
Protocol gross daily reward ≈ (0.09 / 365) * 1,000 = $0.25/day
Net to user after fees & MEV (illustrative) = ~$0.18/day

Notes:
- The referral bonus is paid **when the team member receives their staking reward** (i.e., you get a share of their daily ROI).  
- Percentages are taken from the team member’s earned reward, not from your own balance.  
- If multiple downline members earn rewards on the same day, you receive the corresponding percentage from each earning member.
                    </pre>
                </div>

                <div class="halpha-mt-10 md:halpha-mt-0">
                    <!-- Chart placeholder: integrate chart library or image -->
                    <div class="halpha-bg-[#07121a] halpha-rounded-[12px] halpha-p-4 halpha-h-60 halpha-flex halpha-items-center halpha-justify-center">
                        <img 
                            src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d512580977960d0df28a84_crypto-wallet-from-the-future-image-cryptomatic-webflow-ecommerce-template.png" 
                            alt="A Crypto Wallet From The Future - Cryptomatic X Webflow Template" 
                            style="opacity: 1; filter: blur(0px);" 
                            sizes="(max-width: 479px) 100vw, (max-width: 767px) 86vw, (max-width: 991px) 84vw, (max-width: 1439px) 40vw, 540px" 
                            data-w-id="d9e12617-ce03-f00c-c812-d3cd9504d396" 
                            loading="eager" 
                            srcset="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d512580977960d0df28a84_crypto-wallet-from-the-future-image-cryptomatic-webflow-ecommerce-template-p-500.png 500w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d512580977960d0df28a84_crypto-wallet-from-the-future-image-cryptomatic-webflow-ecommerce-template-p-800.png 800w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d512580977960d0df28a84_crypto-wallet-from-the-future-image-cryptomatic-webflow-ecommerce-template.png 1084w"
                        >
                    </div>

                    <div class="halpha-mt-36">
                        <a href="#" class="btn-primary w-button">See detailed payout rules</a>
                    </div>
                </div>
            </div>

            <!-- Payout schedule table -->
            <div class="halpha-overflow-x-auto halpha-mt-6">
                <table class="halpha-w-full halpha-text-sm halpha-text-gray-300">
                    <thead class="halpha-text-left">
                        <tr>
                            <th class="halpha-p-3">Plan</th>
                            <th class="halpha-p-3">Payout Frequency</th>
                            <th class="halpha-p-3">Auto-compound</th>
                            <th class="halpha-p-3">Withdrawal window</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="halpha-border-t halpha-border-[#111316]">
                            <td class="halpha-p-3">Starter</td>
                            <td class="halpha-p-3">Daily</td>
                            <td class="halpha-p-3">No</td>
                            <td class="halpha-p-3">24 hours</td>
                        </tr>
                        <tr class="halpha-border-t halpha-border-[#111316]">
                            <td class="halpha-p-3">Pro</td>
                            <td class="halpha-p-3">Daily</td>
                            <td class="halpha-p-3">Optional</td>
                            <td class="halpha-p-3">24–48 hours</td>
                        </tr>
                        <tr class="halpha-border-t halpha-border-[#111316]">
                            <td class="halpha-p-3">Institutional</td>
                            <td class="halpha-p-3">Daily</td>
                            <td class="halpha-p-3">Optional</td>
                            <td class="halpha-p-3">Custom</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @include('components.guest.faqs')

@endsection
