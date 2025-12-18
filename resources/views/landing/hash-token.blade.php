@extends('layouts.guest')

@section('content')
    <div class="!halpha-space-y-16">
        {{-- HERO --}}
        <section class="top-section halpha-py-20">
            <div class="container-default w-container text-center">
                <h1 class="display-1 heading-color-gradient">
                    $HASH — The Infrastructure Utility Token
                </h1>
                <p class="halpha-text-xl halpha-text-gray-400 mg-top-12px">
                    The native coordination and utility layer of the HashAlpha ecosystem
                </p>
            </div>
        </section>

        {{-- INTRO --}}
        <section class="small">
            <div class="container-default w-container inner-container _764px center">
                <p class="halpha-text-gray-400 halpha-text-lg">
                    $HASH is the native utility token powering the HashAlpha ecosystem.
                </p>

                <p class="halpha-text-gray-400 halpha-text-lg mg-top-12px">
                    It is designed to align infrastructure growth, validator participation,
                    long-term incentives, and ecosystem governance into a single, scalable
                    economic layer.
                </p>

                <p class="halpha-text-gray-400 halpha-text-lg mg-top-12px">
                    $HASH is not positioned as a speculative asset, but as an operational token
                    that connects users, validators, V-NFT credentials, and future protocol
                    utilities into one coherent system.
                </p>
            </div>
        </section>

        {{-- PURPOSE --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-32px">Purpose of $HASH</h2>

                <p class="halpha-text-gray-300 halpha-text-lg mg-bottom-24px">
                    The role of $HASH is to:
                </p>

                <div class="grid-2-columns gap-row-24px">
                    @foreach([
                        'Anchor value within the HashAlpha infrastructure',
                        'Incentivize long-term participation and ecosystem loyalty',
                        'Enable future protocol-level utilities',
                        'Coordinate governance and access rights',
                        'Support sustainable validator expansion',
                    ] as $item)
                        <div class="halpha-card halpha-p-5">
                            <p class="halpha-text-gray-300">{{ $item }}</p>
                        </div>
                    @endforeach
                </div>

                <p class="halpha-text-gray-300 halpha-text-lg mg-top-24px">
                    $HASH functions as a participation and coordination token,
                    not a short-term trading instrument.
                </p>
            </div>
        </section>

        {{-- CORE UTILITIES --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-32px">Core Utilities of $HASH</h2>

                {{-- 1 --}}
                <div class="halpha-card halpha-p-6 mg-bottom-24px">
                    <h3 class="display-3 mg-bottom-8px">1. Staking & Yield Enhancement</h3>
                    <p class="halpha-text-gray-300 mg-bottom-12px">
                        In future phases, $HASH will be stakeable within the HashAlpha ecosystem.
                    </p>
                    <ul class="halpha-text-gray-300 list-disc list-inside">
                        <li>Enhanced reward tiers</li>
                        <li>Loyalty multipliers</li>
                        <li>Priority access to validator pools</li>
                        <li>Reduced platform fees</li>
                        <li>Eligibility for advanced infrastructure products</li>
                    </ul>
                </div>

                {{-- 2 --}}
                <div class="halpha-card halpha-p-6 mg-bottom-24px">
                    <h3 class="display-3 mg-bottom-8px">2. Validator & Infrastructure Access</h3>
                    <p class="halpha-text-gray-300">
                        Certain infrastructure features and participation thresholds will require
                        $HASH holdings or staking, directly tying token demand to real operational infrastructure.
                    </p>
                </div>

                {{-- 3 --}}
                <div class="halpha-card halpha-p-6 mg-bottom-24px">
                    <h3 class="display-3 mg-bottom-8px">3. Governance & Ecosystem Direction</h3>
                    <p class="halpha-text-gray-300 mg-bottom-12px">
                        $HASH will play a role in future governance frameworks, including:
                    </p>
                    <ul class="halpha-text-gray-300 list-disc list-inside">
                        <li>Ecosystem upgrades</li>
                        <li>Validator expansion decisions</li>
                        <li>Reward structure adjustments</li>
                        <li>New product launches</li>
                        <li>Treasury allocation frameworks</li>
                    </ul>

                    <p class="halpha-text-gray-300 mg-top-12px">
                        Governance influence may be weighted by V-NFT tier,
                        reinforcing merit-based participation.
                    </p>
                </div>

                {{-- 4 --}}
                <div class="halpha-card halpha-p-6 mg-bottom-24px">
                    <h3 class="display-3 mg-bottom-8px">4. V-NFT Integration</h3>
                    <p class="halpha-text-gray-300 mg-bottom-12px">
                        $HASH and V-NFTs are structurally connected.
                    </p>

                    <ul class="halpha-text-gray-300 list-disc list-inside">
                        <li>V-NFTs act as achievement credentials, access keys, and reputation markers</li>
                        <li>$HASH acts as the economic engine and governance layer</li>
                    </ul>

                    <p class="halpha-text-gray-300 mg-top-12px">
                        Certain V-NFT tiers may require $HASH staking to activate,
                        enhance rewards, or unlock token-gated utilities.
                    </p>
                </div>

                {{-- 5 --}}
                <div class="halpha-card halpha-p-6">
                    <h3 class="display-3 mg-bottom-8px">5. Ecosystem Expansion & Partner Integration</h3>
                    <p class="halpha-text-gray-300">
                        As HashAlpha grows, $HASH will be used across partner infrastructure platforms,
                        validator services, DeFi integrations, and cross-chain tools.
                    </p>
                </div>

            </div>
        </section>

        {{-- DESIGN PHILOSOPHY --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-32px">Token Design Philosophy</h2>

                <div class="grid-2-columns gap-row-24px">
                    @foreach([
                        'Utility',
                        'Long-term participation incentives',
                        'Infrastructure-backed demand',
                        'Merit-based access via V-NFTs',
                        'Regulatory-conscious architecture',
                    ] as $item)
                        <div class="halpha-card halpha-p-5">
                            <p class="halpha-text-gray-300">{{ $item }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- SUPPLY --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-24px">Supply & Distribution (High-Level)</h2>

                <p class="halpha-text-gray-300 halpha-text-lg mg-bottom-12px">
                    Final tokenomics will be published prior to launch.
                </p>

                <ul class="halpha-text-gray-300 list-disc list-inside">
                    <li>Fixed maximum supply</li>
                    <li>No inflationary minting beyond governance-approved frameworks</li>
                    <li>Allocation aligned with infrastructure growth</li>
                    <li>Long-term vesting for ecosystem and team allocations</li>
                    <li>Utility-driven release schedules</li>
                </ul>

                <p class="halpha-text-gray-300 mg-top-12px">
                    No aggressive emission mechanics or unsustainable yield promises will be implemented.
                </p>
            </div>
        </section>

        {{-- REGULATORY --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-24px">Regulatory & Compliance Considerations</h2>

                <ul class="halpha-text-gray-300 list-disc list-inside">
                    <li>Utility-focused design</li>
                    <li>No profit guarantees</li>
                    <li>No dividend rights</li>
                    <li>No ownership claims</li>
                    <li>Governance and access-based functionality</li>
                </ul>

                <p class="halpha-text-gray-300 mg-top-12px">
                    HashAlpha will release detailed disclosures prior to launch.
                </p>
            </div>
        </section>

        {{-- ROADMAP --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-24px">Roadmap Positioning</h2>

                <p class="halpha-text-gray-300 halpha-text-lg">
                    $HASH is a Phase-Two and Phase-Three ecosystem component.
                </p>

                <ul class="halpha-text-gray-300 list-disc list-inside mg-top-12px">
                    <li>Validator infrastructure</li>
                    <li>ETH staking operations</li>
                    <li>Operational transparency</li>
                    <li>Platform stability</li>
                </ul>

                <p class="halpha-text-gray-300 mg-top-12px">
                    Token utility will expand progressively as infrastructure scales.
                </p>
            </div>
        </section>

        {{-- LONG TERM --}}
        <section class="small">
            <div class="container-default w-container">
                <h2 class="display-2 mg-bottom-24px">Long-Term Vision</h2>

                <ul class="halpha-text-gray-300 list-disc list-inside">
                    <li>A coordination layer for validator infrastructure</li>
                    <li>A governance and access mechanism</li>
                    <li>A loyalty and participation engine</li>
                    <li>A bridge between infrastructure and users</li>
                </ul>
            </div>
        </section>

        {{-- NOTICE --}}
        <section class="small">
            <div class="container-default w-container">
                <div class="halpha-card halpha-p-6 halpha-bg-gray-900">
                    <h3 class="display-3 mg-bottom-8px">Important Notice</h3>
                    <p class="halpha-text-gray-400 text-sm">
                        $HASH is a utility token intended for ecosystem participation.
                        It does not represent equity, ownership, or guaranteed returns.
                        Token functionality and availability are subject to ongoing development
                        and regulatory considerations.
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection
