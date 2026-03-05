<div class="halpha-space-y-6">
    <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
        Rank Progress
    </h1>
    <p class="halpha-text-xs halpha-text-gray-400">
        View your downline bonuses and <strong class="halpha-text-white">rank bonus</strong>
    </p>

    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
        <x-affiliate.stat label="Total Available" :value="number_format($totalAvailable)" prefix="$" highlight />
        <x-affiliate.stat label="Total Withdrawn" :value="number_format($withdrawn)" prefix="$" />
    </div>


    <div class="halpha-card halpha-p-5 halpha-text-center">
        <p class="halpha-text-xs halpha-text-gray-400">Your rank</p>
        <h2 class="halpha-text-2xl halpha-font-bold halpha-text-accent-2">
            {{ $currentRank->name ?? 'Unranked' }}
        </h2>
    </div>

    <div class="halpha-card halpha-p-4">
        <div class="halpha-flex halpha-justify-between halpha-text-xs halpha-text-gray-400 mb-1">
            <span>Progress to {{ $nextRank->name }}</span>
            <span>{{ $progressPercent }}%</span>
        </div>

        <div class="halpha-h-2 halpha-bg-gray-800 halpha-rounded">
            <div class="halpha-h-2 halpha-bg-accent-2 halpha-rounded" style="width:{{ $progressPercent }}%"></div>
        </div>
    </div>

    <div class="halpha-space-y-2">
        {{-- Hint --}}
        <div
            class="halpha-card halpha-bg-card-soft halpha-p-3 halpha-text-[11px] halpha-text-gray-400 halpha-flex halpha-items-center halpha-gap-2">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="halpha-h-12 halpha-w-12 halpha-text-accent-2 halpha-opacity-80"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 18a6 6 0 100-12 6 6 0 000 12z" />
            </svg>

            <span>
                Tap on any <strong class="halpha-text-gray-300">rank</strong> below to view detailed qualification
                requirements and your progress.
            </span>
        </div>

        @foreach($ranks as $rank)
            <x-affiliate.step :name="$rank->name" :active="$rank->level <= ($currentRank->level ?? 0)"
                wire:click="showRankDetails({{ $rank->id }})" class="halpha-cursor-pointer" />
        @endforeach
    </div>

    {{-- Ranking Information --}}
    <div
        class="halpha-card halpha-rounded-lg halpha-bg-card-soft halpha-p-3 halpha-text-[11px] halpha-text-gray-400 halpha-leading-relaxed">
        <p class="halpha-font-medium halpha-text-gray-300 halpha-mb-1">
            Rank Qualification Rules
        </p>

        <ul class="halpha-list-disc halpha-pl-4 halpha-space-y-1">
            <li>Ranks are determined by total team volume, active referrals, and earned rewards.</li>
            <li>Rank upgrades occur automatically once all requirements are met.</li>
            <li>Higher ranks unlock increased bonus eligibility and platform privileges.</li>
            <li>Rank status is permanent and will not downgrade once achieved.</li>
            <li>All calculations are performed system-wide and cannot be manually altered.</li>
        </ul>
    </div>

    @if($showRankModal && $selectedRank)
        <div
            x-data="{ show: true }"
            x-on:keydown.escape.window="show = false"
            x-cloak
        >
            <div
                x-show="show"
                x-transition.opacity
                class="halpha-fixed halpha-inset-0 halpha-bg-black/70 halpha-backdrop-blur-sm halpha-z-50"
                @click.self="show = false"
            >
                <div
                    x-show="show"
                    x-transition:enter="halpha-transition halpha-duration-200 halpha-ease-out"
                    x-transition:enter-start="halpha-opacity-0 halpha-scale-95"
                    x-transition:enter-end="halpha-opacity-100 halpha-scale-100"
                    x-transition:leave="halpha-transition halpha-duration-150 halpha-ease-in"
                    x-transition:leave-start="halpha-opacity-100 halpha-scale-100"
                    x-transition:leave-end="halpha-opacity-0 halpha-scale-95"
                    class="halpha-min-h-screen halpha-flex halpha-items-center halpha-justify-center halpha-px-4"
                >
                    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm halpha-w-full">

                        <div
                            class="halpha-card halpha-bg-gray-900 halpha-w-full max-w-md halpha-rounded-2xl halpha-p-6 halpha-relative halpha-border halpha-border-gray-800 shadow-xl halpha-space-y-4">

                            {{-- Close --}}
                            <button wire:click="closeRankModal"
                                class="absolute top-4 right-4 halpha-text-white hover:halpha-text-white transition">
                                <span class="halpha-w-5 halpha-h-5 halpha-bg-accent-2 halpha-rounded halpha-p-1 halpha-px-2 hover:halpha-opacity-80">
                                    ✕
                                </span>
                                
                            </button>

                            {{-- Header --}}
                            <div class="halpha-text-center halpha-mb-6">
                                <div
                                    class="halpha-inline-flex halpha-items-center halpha-justify-center halpha-w-12 halpha-h-12 halpha-rounded-full halpha-mb-3">
                                    <x-heroicon-s-trophy class="halpha-text-accent-2 halpha-opacity-80" />
                                </div>

                                <h2 class="halpha-text-xl halpha-font-bold halpha-text-white">
                                    {{ $selectedRank->name }}
                                </h2>

                                <p class="halpha-text-xs halpha-text-gray-400 mt-1">
                                    Rank Qualification Overview
                                </p>
                            </div>

                            {{-- REQUIREMENTS --}}
                            <div class="halpha-space-y-4 halpha-mb-6">
                                <h3 class="halpha-text-xs halpha-uppercase halpha-text-gray-500 halpha-tracking-wide">
                                    Requirements
                                </h3>

                                <div class="halpha-space-y-3 halpha-text-sm">

                                    <div class="halpha-flex halpha-justify-between">
                                        <span class="halpha-text-gray-400">Team Volume</span>
                                        <span class="halpha-text-white halpha-font-semibold">
                                            ${{ number_format($selectedRank->required_volume) }}
                                        </span>
                                    </div>

                                    <div class="halpha-flex halpha-justify-between">
                                        <span class="halpha-text-gray-400">Active Referrals</span>
                                        <span class="halpha-text-white halpha-font-semibold">
                                            {{ $selectedRank->required_active_referrals }}
                                        </span>
                                    </div>

                                    <div class="halpha-flex halpha-justify-between">
                                        <span class="halpha-text-gray-400">Total Earnings</span>
                                        <span class="halpha-text-white halpha-font-semibold">
                                            ${{ number_format($selectedRank->required_earnings) }}
                                        </span>
                                    </div>

                                </div>
                            </div>

                            {{-- USER PROGRESS --}}
                            <div class="halpha-space-y-4 halpha-mb-6">
                                <h3 class="halpha-text-xs halpha-uppercase halpha-text-gray-500 halpha-tracking-wide">
                                    Your Progress
                                </h3>

                                {{-- Volume --}}
                                <div>
                                    <div class="halpha-flex halpha-justify-between halpha-text-xs halpha-mb-1">
                                        <span class="halpha-text-gray-400">Team Volume</span>
                                        <span class="halpha-text-gray-300">
                                            ${{ number_format($userVolume ?? 0) }}
                                        </span>
                                    </div>
                                    <div class="halpha-h-2 halpha-bg-gray-800 halpha-rounded">
                                        <div class="halpha-h-2 halpha-bg-accent-2 halpha-rounded"
                                            style="width: {{ min(100, ($userVolume / max(1,$selectedRank->required_volume)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>

                                {{-- Referrals --}}
                                <div>
                                    <div class="halpha-flex halpha-justify-between halpha-text-xs halpha-mb-1">
                                        <span class="halpha-text-gray-400">Active Referrals</span>
                                        <span class="halpha-text-gray-300">
                                            {{ $userActiveReferrals ?? 0 }}
                                        </span>
                                    </div>
                                    <div class="halpha-h-2 halpha-bg-gray-800 halpha-rounded">
                                        <div class="halpha-h-2 halpha-bg-accent-2 halpha-rounded"
                                            style="width: {{ min(100, ($userActiveReferrals / max(1,$selectedRank->required_active_referrals)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>

                                {{-- Earnings --}}
                                <div>
                                    <div class="halpha-flex halpha-justify-between halpha-text-xs halpha-mb-1">
                                        <span class="halpha-text-gray-400">Total Earnings</span>
                                        <span class="halpha-text-gray-300">
                                            ${{ number_format($userEarnings ?? 0) }}
                                        </span>
                                    </div>
                                    <div class="halpha-h-2 halpha-bg-gray-800 halpha-rounded">
                                        <div class="halpha-h-2 halpha-bg-accent-2 halpha-rounded"
                                            style="width: {{ min(100, ($userEarnings / max(1,$selectedRank->required_earnings)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- STATUS --}}
                            <div class="text-center pt-4 border-t border-gray-800">
                                @if($selectedRank->level <= ($currentRank->level ?? 0))
                                    <span
                                        class="inline-flex items-center gap-1 halpha-text-xs halpha-text-accent-2 halpha-font-semibold">
                                        ✔ Rank Achieved
                                    </span>
                                @else
                                    <span class="halpha-text-xs halpha-text-gray-500">
                                        Locked — keep progressing
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif





</div>