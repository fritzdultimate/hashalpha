<div class="halpha-space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl md:halpha-text-3xl halpha-font-semibold halpha-text-white">
            Proof of Rewards
        </h1>
        <p class="halpha-text-xs md:halpha-text-sm halpha-text-gray-400 halpha-w-3/5 halpha-leading-loose">
            This page provides visibility into how network rewards are generated and distributed through {{ env('APP_NAME') }}'s validator infrastructure.
        </p>
    </div>

    <div class="halpha-card !halpha-rounded-md halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-4">
        <h3 class="halpha-text-sm md:halpha-text-base halpha-font-semibold halpha-text-gray-100 halpha-p-4 halpha-border-b halpha-border-b-gray-600 halpha-flex halpha-justify-between">
            Rewards Overview

            <x-heroicon-s-chevron-right class="halpha-w-5 halpha-h-5" />
        </h3>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-5 halpha-p-4">
            <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                <h4 class="halpha-text-xs md:halpha-text-sm halpha-text-gray-300">Total Reward Distributed</h4>
                <span class="halpha-text-xl halpha-text-white halpha-font-semibold">2,451.89 ETH</span>
            </div>

            <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                <h4 class="halpha-text-sm halpha-text-gray-300">Last Distribution</h4>
                <span class="halpha-text-base halpha-text-white">April 26, 2024, 10:42 UTC</span>
            </div>

            <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                <h4 class="halpha-text-sm halpha-text-gray-300">Reward Source</h4>
                <span class="halpha-text-base halpha-text-white">ValidatorNetwork Participation</span>
            </div>

            <div class="halpha-grid halpha-grid-cols-2 halpha-gap-5">
                <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                    <h4 class="halpha-text-sm halpha-text-gray-300">Reward Asset</h4>
                    <span class="halpha-text-base halpha-text-white" title="Ethereum">ETH</span>
                </div>

                <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                    <h4 class="halpha-text-sm halpha-text-gray-300">Distribution Frequency</h4>
                    <span class="halpha-text-base halpha-text-white" title="Ethereum">Hourly</span>
                </div>
            </div>
        </div>
    </div>

    {{-- REWARD ENGINE --}}
    <div class="halpha-card halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-gray-400 halpha-bg-card-soft halpha-p-4 halpha-uppercase">
            Reward Engine Status
        </h3>

        <div class="halpha-p-4 halpha-space-y-2 halpha-text-xs">
            <div class="halpha-flex halpha-justify-between">
                <span class="halpha-text-gray-400">Accrual State</span>
                <span class="halpha-text-green-400">Active</span>
            </div>

            <div class="halpha-flex halpha-justify-between">
                <span class="halpha-text-gray-400">Distribution Engine</span>
                <span class="halpha-text-green-400">Operational</span>
            </div>

            <div class="halpha-flex halpha-justify-between">
                <span class="halpha-text-gray-400">Settlement Model</span>
                <span class="halpha-text-white">Epoch-based</span>
            </div>
        </div>
    </div>

    {{-- REWARD HISTORY --}}
    <div class="halpha-card halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-gray-400 halpha-bg-card-soft halpha-p-4 halpha-uppercase">
            Recent Reward Cycles
        </h3>

        <div class="halpha-p-4 halpha-space-y-2 halpha-text-xs">
            <div class="halpha-flex halpha-justify-between">
                <span>Jan 07, 2026</span>
                <span class="halpha-text-white">$152,480.22</span>
            </div>

            <div class="halpha-flex halpha-justify-between">
                <span>Apr 27, 2024</span>
                <span class="halpha-text-white">$12,480.22</span>
            </div>

            <div class="halpha-flex halpha-justify-between">
                <span>Apr 20, 2024</span>
                <span class="halpha-text-white">$11,902.10</span>
            </div>

            <div class="halpha-flex halpha-justify-between">
                <span>Apr 13, 2024</span>
                <span class="halpha-text-white">$12,115.88</span>
            </div>
        </div>
    </div>

    {{-- DISCLAIMER --}}
    <div class="halpha-card halpha-rounded-xl">
        <div class="halpha-p-4 halpha-text-xs halpha-text-gray-400">
            Rewards shown are network-derived and subject to protocol conditions. Individual user outcomes may vary.
        </div>
    </div>

</div>
