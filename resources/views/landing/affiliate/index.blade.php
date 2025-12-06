@extends('layouts.guest')

@section('title', 'Affiliate Program')

@section('content')

    <div class="halpha-px-3 md:halpha-px-6 halpha-py-12 halpha-bg-[#070707] halpha-text-white">
        <div class="halpha-max-w-6xl halpha-mx-auto">
            <header class="halpha-mb-8">
                <h1 class="halpha-text-4xl halpha-font-semibold halpha-leading-tight">Affiliate Program</h1>
                <p class="halpha-mt-2 halpha-text-gray-300">Earn by referring new users — follow ranks, unlock bonuses, and
                    access ready-made banners and tools.</p>
            </header>

            <section class="halpha-grid halpha-grid-cols-1 lg:halpha-grid-cols-3 halpha-gap-6 halpha-mb-8">
                {{-- How It Works --}}
                <article class="halpha-bg-[#0b0b0d] halpha-rounded-2xl halpha-p-6 halpha-shadow-sm">
                    <h2 class="halpha-text-xl halpha-font-medium">How It Works</h2>
                    <p class="halpha-mt-3 halpha-text-gray-300 halpha-text-sm">
                        Share your referral link. When your referrals deposit and build team volume, you'll progress through
                        ranks and receive one-time cash bonuses and ongoing commissions.
                    </p>
                    <ul class="halpha-mt-4 halpha-space-y-2 halpha-text-sm halpha-text-gray-300">
                        <li>• Track your progress with the Rank Progress Tracker.</li>
                        <li>• Bonuses are paid when rank conditions are met.</li>
                        <li>• Team volume accumulates long-term — it doesn't reset monthly.</li>
                    </ul>
                    <a href="{{ route('affiliate.ranks') }}"
                        class="halpha-inline-block halpha-mt-4 halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-text-white halpha-text-sm">See
                        Rank Tracker</a>
                </article>

                
                <article class="halpha-bg-[#0b0b0d] halpha-rounded-2xl halpha-p-6 halpha-shadow-sm">
                    <h2 class="halpha-text-xl halpha-font-medium">Compensation Plan Summary</h2>
                    <p class="halpha-mt-3 halpha-text-gray-300 halpha-text-sm">A simplified view of how ranks, team volume
                        (TV), and personal deposit (PD) translate into cash bonuses.</p>
                    <dl class="halpha-mt-4 halpha-grid halpha-grid-cols-1 gap-2 halpha-text-sm">
                        <div class="halpha-flex halpha-justify-between halpha-text-gray-300">
                            <dt>Ranks based on</dt>
                            <dd>Team Volume (TV) + Personal Deposit (PD)</dd>
                        </div>
                        <div class="halpha-flex halpha-justify-between halpha-text-gray-300">
                            <dt>Bonuses</dt>
                            <dd>One-time cash reward when rank achieved</dd>
                        </div>
                        <div class="halpha-flex halpha-justify-between halpha-text-gray-300">
                            <dt>Direct referrals</dt>
                            <dd>Minimum direct referrals required per rank</dd>
                        </div>
                    </dl>
                    <a href="{{ route('affiliate.compensation') }}"
                        class="halpha-inline-block halpha-mt-4 halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-text-white halpha-text-sm">Full
                        Summary</a>
                </article>

                
                <article class="halpha-bg-[#0b0b0d] halpha-rounded-2xl halpha-p-6 halpha-shadow-sm !halpha-hidden">
                    <h2 class="halpha-text-xl halpha-font-medium">Affiliate Tools & Banners</h2>
                    <p class="halpha-mt-3 halpha-text-gray-300 halpha-text-sm">Download pre-built banners, tracking links,
                        and copy templates to get started quickly.</p>
                    <ul class="halpha-mt-4 halpha-space-y-2 halpha-text-sm halpha-text-gray-300">
                        <li>• Banner pack (sizes: 300x250, 728x90, 160x600)</li>
                        <li>• Email swipe copy</li>
                        <li>• Social post templates</li>
                    </ul>
                    <a href="{{ route('affiliate.tools') }}"
                        class="halpha-inline-block halpha-mt-4 halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-text-white halpha-text-sm">Open
                        Tools</a>
                </article>
            </section>

            <section class="halpha-mt-8 halpha-bg-gradient-to-b halpha-from-transparent halpha-to-[#040405] halpha-rounded-2xl md:halpha-p-6">
                <div class="halpha-flex halpha-items-center halpha-justify-between halpha-mb-4">
                    <h3 class="halpha-text-xl md:halpha-text-2xl halpha-font-semibold">Rank Progress Tracker</h3>
                    <a href="{{ route('affiliate.ranks') }}" class="halpha-text-xs md:halpha-text-sm halpha-opacity-80">View full tracker
                        →</a>
                </div>

                @include('landing.affiliate._rank-table', ['ranks' => $ranks, 'compact' => true])
            </section>
        </div>

    </div>
    @include('components.guest.faqs')
@endsection