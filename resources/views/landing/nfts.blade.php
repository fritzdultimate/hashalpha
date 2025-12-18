@extends('layouts.guest')

@section('content')
    <div class="halpha-space-y-16">
    {{-- HERO --}}
        <section class="top-section halpha-py-20">
            <div class="container-default w-container text-center">
                <h1 class="display-1 heading-color-gradient">
                    V-NFTs — Validator Network Tokens
                </h1>
                <p class="halpha-text-xl halpha-text-gray-400 mg-top-12px">
                    Digital Infrastructure Credentials for the HashAlpha Ecosystem
                </p>
            </div>
        </section>

        {{-- INTRO --}}
        <section class="small">
            <div class="container-default w-container inner-container _764px- center">
                <p class="halpha-text-gray-400 halpha-text-lg">
                    HashAlpha introduces V-NFTs (Validator Network Tokens) — a non-speculative digital credential
                    system designed to recognize verifiable contribution, long-term alignment, and network
                    participation within the HashAlpha infrastructure ecosystem.
                </p>

                <p class="halpha-text-gray-400 halpha-text-lg mg-top-12px">
                    Unlike traditional NFTs focused on art or trading, V-NFTs function as on-chain infrastructure
                    credentials. They represent measurable milestones achieved through staking participation,
                    validator support, and ecosystem growth.
                </p>

                <p class="halpha-text-gray-400 halpha-text-lg mg-top-12px">
                    V-NFTs are foundational to HashAlpha’s long-term vision and will play a central role in
                    governance, access, and future token utility.
                </p>
            </div>
        </section>

        {{-- WHAT MAKES THEM DIFFERENT --}}
        <section class="small !halpha-mt-10 md:!halpha-mt-20">
            <div class="container-default w-container">
                <div data-w-id="7097561c-a7f6-e18b-4fae-1fadcbfede47" style="opacity: 1; filter: blur(0px);"
                    class="inner-container _568px center">
                    <h2 class="display-2 text-center mg-bottom-32px">What Makes V-NFTs Different</h2>
                </div>

                <p class="halpha-text-gray-300 halpha-text-lg mg-bottom-24px">
                    V-NFTs are purpose-built for infrastructure alignment, not speculation or hype.
                </p>

                <div class="grid-3-columns gap-row-48px">
                    @foreach([
                        'Utility-driven',
                        'Milestone-based, not arbitrarily minted',
                        'On-chain verifiable, not centrally assigned',
                        'Integrated into future protocol mechanics, not static badges',
                    ] as $item)
                        <div class="halpha-card halpha-p-5">
                            <p class="halpha-text-gray-300 display-5">{{ $item }}</p>
                        </div>
                    @endforeach
                </div>

                <p class="halpha-text-gray-400 halpha-text-lg mg-top-24px">
                    Each V-NFT reflects real economic or operational contribution to the HashAlpha network.
                </p>
            </div>
        </section>

        {{-- HOW THEY ARE EARNED --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-32px">How V-NFTs Are Earned</h2>

                <p class="halpha-text-gray-300 halpha-text-lg mg-bottom-24px">
                    V-NFTs are not purchased directly. They are earned automatically when predefined,
                    verifiable milestones are reached.
                </p>

                <div class="grid-2-columns gap-row-24px">
                    @foreach([
                        'Completion of defined staking cycles',
                        'Achieving specific participation or rank tiers',
                        'Reaching cumulative team or network volume thresholds',
                        'Unlocking validator-level participation benchmarks',
                        'Long-term alignment with the HashAlpha ecosystem',
                    ] as $item)
                        <div class="halpha-card halpha-p-5">
                            <p class="halpha-text-gray-300">{{ $item }}</p>
                        </div>
                    @endforeach
                </div>

                <p class="halpha-text-gray-400 halpha-text-lg mg-top-24px">
                    Once earned, a V-NFT is minted on-chain and permanently linked to the holder’s wallet.
                </p>
            </div>
        </section>

        {{-- CORE PROPERTIES --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-32px">Core Properties of V-NFTs</h2>

                <div class="grid-2-columns gap-row-24px">
                    @foreach([
                        'Cryptographically verifiable on-chain',
                        'Represents real contribution, not artificial scarcity',
                        'Cannot be arbitrarily revoked or altered',
                        'Serves as a long-term identity marker',
                        'Gateway asset for future ecosystem utilities',
                    ] as $item)
                        <div class="halpha-card halpha-p-5">
                            <p class="halpha-text-gray-300">{{ $item }}</p>
                        </div>
                    @endforeach
                </div>

                <p class="halpha-text-gray-400 halpha-text-lg mg-top-24px">
                    V-NFTs establish a persistent on-chain reputation layer for participants aligned
                    with infrastructure growth.
                </p>
            </div>
        </section>

        {{-- ROLE IN ECOSYSTEM --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-32px">Role of V-NFTs in the HashAlpha Ecosystem</h2>

                <div class="halpha-flex halpha-flex-col halpha-gap-6">
                    <div class="halpha-card halpha-p-6">
                        <h3 class="display-3 mg-bottom-8px">1. Governance & Network Influence</h3>
                        <p class="halpha-text-gray-300">
                            Higher-tier V-NFTs provide enhanced weighting or eligibility within future
                            governance modules related to network parameters, validator expansion,
                            ecosystem upgrades, and treasury-aligned decisions.
                        </p>
                    </div>

                    <div class="halpha-card halpha-p-6">
                        <h3 class="display-3 mg-bottom-8px">2. Priority Access & Eligibility</h3>
                        <p class="halpha-text-gray-300">
                            Certain future products or features will require ownership of specific
                            V-NFT tiers, including advanced validator pools, early participation in
                            new infrastructure modules, and exclusive staking programs.
                        </p>
                    </div>

                    <div class="halpha-card halpha-p-6">
                        <h3 class="display-3 mg-bottom-8px">3. Reward Enhancements & Loyalty</h3>
                        <p class="halpha-text-gray-300">
                            V-NFTs unlock reward multipliers, reduced fees, priority settlement
                            windows, and benefits tied to longevity and contribution.
                        </p>
                    </div>

                    <div class="halpha-card halpha-p-6">
                        <h3 class="display-3 mg-bottom-8px">4. Token Integration ($HASH)</h3>
                        <p class="halpha-text-gray-300">
                            V-NFTs integrate deeply with the upcoming $HASH utility token ecosystem,
                            including staking multipliers, token-gated access, and long-term
                            alignment incentives.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- V-NFT + HASH --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-24px">V-NFTs and the $HASH Token</h2>

                <p class="halpha-text-gray-300 halpha-text-lg">
                    V-NFTs and $HASH are designed to work together — not independently.
                </p>

                <ul class="halpha-text-gray-300 halpha-text-lg mg-top-12px list-disc list-inside">
                    <li>V-NFTs represent contribution and credibility</li>
                    <li>$HASH represents utility and economic coordination</li>
                </ul>

                <p class="halpha-text-gray-300 halpha-text-lg mg-top-16px">
                    Together, they form the backbone of a sustainable,
                    participation-driven infrastructure ecosystem.
                </p>
            </div>
        </section>

        {{-- TRANSFERABILITY --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-24px">Transferability & Market Dynamics</h2>

                <p class="halpha-text-gray-300 halpha-text-lg">
                    V-NFTs are designed primarily as utility credentials, not trading assets.
                </p>

                <ul class="halpha-text-gray-300 halpha-text-lg mg-top-12px list-disc list-inside">
                    <li>Some tiers may be non-transferable</li>
                    <li>Other tiers may allow limited transferability</li>
                    <li>Any secondary market behavior is governed by protocol logic</li>
                </ul>

                <p class="halpha-text-gray-300 halpha-text-lg mg-top-16px">
                    HashAlpha’s priority is long-term network integrity, not short-term liquidity.
                </p>
            </div>
        </section>

        {{-- NOTICE --}}
        <section class="small">
            <div class="container-default w-container">
                <div class="halpha-card halpha-p-6 halpha-bg-gray-900">
                    <h3 class="display-3 mg-bottom-8px">Important Notice</h3>
                    <p class="halpha-text-gray-400 text-sm">
                        V-NFTs are utility credentials, not investment products. They do not represent
                        ownership, profit guarantees, or financial instruments. All utilities are subject
                        to protocol development, regulatory considerations, and governance decisions.
                    </p>
                </div>
            </div>
        </section>
    </div>

@endsection
