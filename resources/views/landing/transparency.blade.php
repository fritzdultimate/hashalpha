
@extends('layouts.guest')

@section('content')
    <section class="section halpha-py-12">
        <div class="container-default w-container">
            <div class="inner-container _608px _100-tablet">
                <h1 class="display-2 heading-color-gradient">Transparency Hub</h1>
                <p class="!halpha-text-gray-400">Live validator stats, staking rewards proof, monthly operations and audit reports — all in one place. We publish on-chain proof and regular audits to keep operations accountable.</p>
            </div>

            <!-- KPI strip -->
            <div class="halpha-grid halpha-grid-cols-1 sm:halpha-grid-cols-4 halpha-gap-4 halpha-mt-8">
            <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                <div class="halpha-text-sm halpha-text-gray-300">Active Validators</div>
                <div class="halpha-text-2xl halpha-font-bold halpha-text-white">128</div>
            </div>
            <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                <div class="halpha-text-sm halpha-text-gray-300">Average Uptime</div>
                <div class="halpha-text-2xl halpha-font-bold halpha-text-white">99.9%</div>
            </div>
            <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                <div class="halpha-text-sm halpha-text-gray-300">Total Staked</div>
                <div class="halpha-text-2xl halpha-font-bold halpha-text-white">12,340 ETH</div>
            </div>
            <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                <div class="halpha-text-sm halpha-text-gray-300">Last Audit</div>
                <div class="halpha-text-2xl halpha-font-bold halpha-text-white">2025-09-20</div>
            </div>
            </div>

            <!-- Cards -->
            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-6 halpha-mt-8">
            <a href="{{ route('validator-explorer') }}" class="halpha-block halpha-rounded-[12px] halpha-p-6 halpha-bg-gradient-to-b halpha-from-[#04121a] halpha-to-[#07121a] halpha-border halpha-border-[#11161a]">
                <h3 class="halpha-text-lg halpha-font-semibold halpha-text-white">Validator Explorer</h3>
                <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-2">Live keys & performance stats. Search validators or inspect a validator timeline.</p>
            </a>

            <a href="{{ route('proof-of-stake-rewards') }}" class="halpha-block halpha-rounded-[12px] halpha-p-6 halpha-bg-gradient-to-b halpha-from-[#04121a] halpha-to-[#07121a] halpha-border halpha-border-[#11161a]">
                <h3 class="halpha-text-lg halpha-font-semibold halpha-text-white">Proof of Stake Rewards</h3>
                <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-2">On-chain transaction proof for all reward distributions and per-plan breakdowns.</p>
            </a>

            <a href="/transparency/reports" class="halpha-block halpha-rounded-[12px] halpha-p-6 halpha-bg-gradient-to-b halpha-from-[#04121a] halpha-to-[#07121a] halpha-border halpha-border-[#11161a]">
                <h3 class="halpha-text-lg halpha-font-semibold halpha-text-white">Operations Reports</h3>
                <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-2">Monthly operational reports: uptime, incidents, capacity and plans (downloadable PDFs).</p>
            </a>
            </div>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6 halpha-mt-6">
            <a href="/transparency/audits" class="halpha-block halpha-rounded-[12px] halpha-p-6 halpha-bg-gradient-to-b halpha-from-[#04121a] halpha-to-[#07121a] halpha-border halpha-border-[#11161a]">
                <h3 class="halpha-text-lg halpha-font-semibold halpha-text-white">Audit Dashboard</h3>
                <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-2">Third-party security audits and remediation timelines.</p>
            </a>

            <a href="/transparency/beacon" class="halpha-block halpha-rounded-[12px] halpha-p-6 halpha-bg-gradient-to-b halpha-from-[#04121a] halpha-to-[#07121a] halpha-border halpha-border-[#11161a]">
                <h3 class="halpha-text-lg halpha-font-semibold halpha-text-white">Real-Time Beacon Data</h3>
                <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-2">Live beacon chain metrics for validators and finality health.</p>
            </a>
            </div>

            <div class="halpha-mt-8">
            <a href="/transparency/explorer" class="btn-primary w-button">Open Validator Explorer</a>
            <a href="/transparency/reports" class="btn-secondary w-button">View Reports</a>
            </div>
        </div>
    </section>

    @include('components.guest.faqs')
@endsection
