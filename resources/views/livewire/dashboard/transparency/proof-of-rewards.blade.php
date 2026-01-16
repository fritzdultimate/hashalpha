<div class="halpha-space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl md:halpha-text-3xl halpha-font-semibold halpha-text-white">
            Proof of Rewards
        </h1>
        <p class="halpha-text-xs md:halpha-text-sm halpha-text-gray-400 md:halpha-w-3/5 halpha-leading-loose">
            This page provides visibility into how network rewards are generated and distributed through {{ env('APP_NAME') }}'s validator infrastructure.
        </p>
    </div>

    <div 
        x-data="{ open: true }"   
        class="halpha-card !halpha-rounded-md halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2"
        @click="open = !open"
    >

    <h3 class="halpha-text-sm md:halpha-text-base halpha-font-semibold halpha-text-gray-100 halpha-p-4 halpha-border-b-gray-600 halpha-flex halpha-justify-between items-center halpha-cursor-pointer" x-bind:class="open ? 'halpha-border-b' : ''">
        Rewards Overview

        <div class="halpha-flex halpha-gap-2">
            <x-heroicon-s-chevron-right x-show="open" class="halpha-w-5 halpha-h-5" />
            <x-heroicon-s-chevron-down x-show="!open" class="halpha-w-5 halpha-h-5" />
        </div>
    </h3>

        <div 
            class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-3 halpha-p-4"
            x-show="open"
            x-transition
        >
            <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                <h4 class="halpha-text-xs md:halpha-text-sm halpha-text-gray-300">Total Reward Distributed</h4>
                <span class="halpha-text-xl halpha-text-white halpha-font-semibold">{{ $distributedRewards }} ETH</span>
            </div>

            <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                <h4 class="halpha-text-xs md:halpha-text-sm halpha-text-gray-300">Last Distribution</h4>
                <span class="halpha-text-sm md:halpha-text-base halpha-text-white">January 12, 2026, 10:42 UTC</span>
            </div>

            <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                <h4 class="halpha-text-xs md:halpha-text-sm halpha-text-gray-300">Reward Source</h4>
                <span class="halpha-text-sm md:halpha-text-base halpha-text-white">ValidatorNetwork Participation</span>
            </div>

            <div class="halpha-grid halpha-grid-cols-2 halpha-gap-2">
                <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                    <h4 class="halpha-text-xs md:halpha-text-sm halpha-text-gray-300">Reward Asset</h4>
                    <span class="halpha-text-sm md:halpha-text-base halpha-text-white" title="Ethereum">ETH</span>
                </div>

                <div class="halpha-card halpha-p-4 halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2">
                    <h4 class="halpha-text-xs md:halpha-text-sm halpha-text-gray-300 halpha-truncate">Distribution Frequency</h4>
                    <span class="halpha-text-sm md:halpha-text-base halpha-text-white" title="Ethereum">Hourly</span>
                </div>
            </div>
        </div>
    </div>

    <div 
        x-data="{ open: true }"   
        class="halpha-card !halpha-rounded-md halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2"
        @click="open = !open"
    >

        <h3 class="halpha-text-sm md:halpha-text-base halpha-font-semibold halpha-text-gray-100 halpha-p-4 halpha-border-b-gray-600 halpha-flex halpha-justify-between items-center halpha-cursor-pointer" x-bind:class="open ? 'halpha-border-b' : ''">
            Validator Reward Source

            <div class="halpha-flex halpha-gap-2">
                <x-heroicon-s-chevron-right x-show="open" class="halpha-w-5 halpha-h-5" />
                <x-heroicon-s-chevron-down x-show="!open" class="halpha-w-5 halpha-h-5" />
            </div>
        </h3>

        <div
            class="halpha-flex halpha-flex-col md:halpha-flex-row halpha-gap-4 halpha-px-4 halpha-py-3"
            x-show="open"
            x-transition
        >
            <!-- Left Column -->
            <div class="halpha-flex-1 halpha-px-2 halpha-flex halpha-flex-col halpha-gap-4">
                <div class="halpha-flex halpha-items-center halpha-gap-5">
                    <span class="halpha-text-sm halpha-text-gray-300">Network:</span>
                    <span class="halpha-text-base halpha-text-white">Ethereum</span>
                </div>

                <div >
                    <div class="halpha-flex halpha-items-center halpha-gap-5">
                        <span class="halpha-text-sm halpha-text-gray-300">Reward Type:</span>
                        <span class="halpha-text-sm md:halpha-text-base halpha-text-white">Consensus rewards</span>
                    </div>
                    <ul class="halpha-list-disc halpha-ml-24">
                        <li class="halpha-text-white halpha-text-sm md:halpha-text-base">Transaction fees <span class="halpha-text-gray-300">(if applicable)</span></li>
                    </ul>
                </div>

                <div class="halpha-flex halpha-flex-col halpha-gap-1">
                    <span class="halpha-text-sm halpha-text-white">Validator Participation Model:</span>
                    <span class="halpha-text-base halpha-text-white halpha-flex halpha-items-center halpha-gap-1">
                        <x-heroicon-s-chevron-right x-show="open" class="halpha-w-4 halpha-h-4 halpha-text-gray-500" />
                        Distributed validator clusters
                    </span>

                    <p class="halpha-text-xs halpha-text-gray-400 halpha-w-4/5">Rewards are generated from protocol-ie-level validator activity, not from deposits or internal transfers.</p>
                </div>
            </div>

            <!-- Vertical Divider -->
            <div class="halpha-hidden md:halpha-flex halpha-items-stretch">
                <div class="halpha-w-px halpha-bg-gray-600"></div>
            </div>

            <!-- Right Column -->
            <div class="halpha-flex-1 halpha-px-2 halpha-flex halpha-flex-col halpha-gap-4 halpha-justify-start halpha-items-start">
                <h4 class="halpha-text-sm md:halpha-text-base halpha-text-white">
                    Validator Audit Trail
                </h4>
                <ul class="halpha-space-y-4 halpha-list-disc halpha-text-gray-400 halpha-text-xs md:halpha-text-sm halpha-ml-5">
                    <li>
                        Active Validator Keys: <span class="halpha-text-white">104</span> of 350 active
                    </li>
                    <li>
                        Network uptime: <span class="halpha-text-white">99.9%</span>
                    </li>
                    <li>
                        Average Participation Rate: <span class="halpha-text-white">99.7%</span>
                    </li>
                </ul>

                <a class="halpha-bg-card-bg halpha-border halpha-rounded halpha-border-gray-600 halpha-flex halpha-gap-2 halpha-items-center halpha-p-2 halpha-px-6 halpha-text-accent-2 halpha-text-sm hover:halpha-opacity-70" href="#" target="_blank">
                    <x-heroicon-s-link class="halpha-h-4 halpha-w-4" />
                    View on Beacon Explorer
                </a>
            </div>
        </div>


    </div>

    <div   
        class="halpha-card !halpha-rounded-md halpha-border halpha-border-gray-600 halpha-flex halpha-flex-col halpha-gap-2"
        
    >

        <h3 class="halpha-text-sm md:halpha-text-base halpha-font-semibold halpha-text-gray-100 halpha-p-4 halpha-border-b-gray-600 halpha-flex halpha-justify-between items-center halpha-cursor-pointer halpha-border-b">
            Reward History

            <div class="halpha-flex halpha-gap-2 halpha-text-sm halpha-text-gray-400">
                <span class="halpha-hidden md:halpha-block">Cumulative Rewards Earned:</span>
                <span class="halpha-text-white">0 ETH</span>
            </div>
        </h3>

        <div class="halpha-overflow-x-auto halpha-w-full">
            <table class="halpha-w-full halpha-min-w-[640px] halpha-text-left">
                <thead
                    class="halpha-hidden md:halpha-table-header-group
                        halpha-text-xs halpha-uppercase halpha-tracking-wide
                        halpha-border-b halpha-border-white/10"
                >
                    <tr>
                        <th class="halpha-py-3 halpha-px-4 halpha-text-white">Date</th>
                        <th class="halpha-py-3 halpha-px-4 halpha-text-white">Amount</th>
                        <th class="halpha-py-3 halpha-px-4 halpha-text-white">Reward Status</th>
                        <th class="halpha-py-3 halpha-px-4 halpha-text-white">Source</th>
                    </tr>
                </thead>

                <tbody class="halpha-text-sm halpha-font-sans">
                    @php
                        $rewards = [
                            [
                                'amount' => 0,
                                'date' => 'April 26, 2022 UTC'
                            ], 
                            [
                                'amount' => 0,
                                'date' => 'April 26, 2022 UTC'
                            ], 
                            [
                                'amount' => 0,
                                'date' => 'April 25, 2022 UTC'
                            ], 
                            [
                                'amount' => 0,
                                'date' => 'April 25, 2022 UTC'
                            ]
                        ]
                    @endphp

                    @foreach ($rewards as $reward)
                        <tr
                            class="halpha-border-b halpha-border-gray-700
                                hover:halpha-bg-white/10
                                halpha-grid halpha-grid-cols-1 md:halpha-table-row
                                halpha-gap-2 md:halpha-gap-0
                                halpha-p-3 md:halpha-p-0"
                        >
                            <td class="halpha-py-2 md:halpha-py-3.5 halpha-px-4 halpha-text-[#f0f0f0]">
                                <span class="halpha-block md:halpha-hidden halpha-text-xs halpha-text-gray-400">Date</span>
                                {{ $reward['date'] }}
                            </td>

                            <td class="halpha-py-2 md:halpha-py-3.5 halpha-px-4 halpha-text-[#f0f0f0]">
                                <span class="halpha-block md:halpha-hidden halpha-text-xs halpha-text-gray-400">Amount</span>
                                {{ $reward['amount'] }} ETH
                            </td>

                            <td class="halpha-py-2 md:halpha-py-3.5 halpha-px-4 halpha-text-[#f0f0f0]">
                                <span class="halpha-block md:halpha-hidden halpha-text-xs halpha-text-gray-400">Reward Status</span>
                                Credited
                            </td>

                            <td class="halpha-py-2 md:halpha-py-3.5 halpha-px-4 halpha-text-[#f0f0f0]">
                                <span class="halpha-block md:halpha-hidden halpha-text-xs halpha-text-gray-400">Source</span>
                                Validator Rewards
                            </td>
                        </tr>
                    @endforeach

                    <!-- Duplicate rows as needed -->
                </tbody>
            </table>
        </div>



    </div>

    <div class="halpha-space-y-4">
        <div class="halpha-flex halpha-items-center halpha-gap-2">
            <x-heroicon-s-check-circle class="halpha-w-4 halpha-h-4 halpha-text-green-300 halpha-opacity-80" />
            <span class="halpha-text-xs md:halpha-text-sm halpha-text-gray-300">Validator monitoring active</span>
        </div>

        <div class="halpha-flex halpha-items-center halpha-gap-2">
            <x-heroicon-s-check-circle class="halpha-w-4 halpha-h-4 halpha-text-green-300 halpha-opacity-80" />
            <span class="halpha-text-xs md:halpha-text-sm halpha-text-gray-300">Distribution engine operational</span>
        </div>

        <div class="halpha-flex halpha-items-center halpha-gap-2">
            <x-heroicon-s-check-circle class="halpha-w-4 halpha-h-4 halpha-text-green-300 halpha-opacity-80" />
            <span class="halpha-text-xs md:halpha-text-sm halpha-text-gray-300">No reward processing incidents reported</span>
        </div>
    </div>

    {{-- DISCLAIMER --}}
    <div class="halpha-card halpha-rounded-xl halpha-border halpha-border-gray-600">
        <div class="halpha-p-3 halpha-text-xs md:halpha-text-sm halpha-text-gray-400">
            Reward amounts may vary based on network conditions, validator performance, and protocol-level changes. Past reward distributions do not guarantee future results.
        </div>
    </div>

</div>
