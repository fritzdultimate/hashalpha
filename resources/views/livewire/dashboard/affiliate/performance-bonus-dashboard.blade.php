<div class="halpha-space-y-6">

    
    <div class="halpha-card halpha-p-5 halpha-bg-gradient-to-r halpha-from-gray-900 halpha-to-gray-800">

        <div class="halpha-flex halpha-justify-between halpha-items-center">

            <div>
                <div class="halpha-text-xs halpha-text-gray-400">Current Rank</div>
                <div class="halpha-text-xl halpha-text-white halpha-font-semibold">
                    {{ $rank->name ?? 'No Rank' }}
                </div>

                <div class="halpha-text-xs halpha-text-accent-2 halpha-mt-1">
                    Performance Bonus Active
                </div>
            </div>

            <div class="halpha-text-right">
                <div class="halpha-text-xs halpha-text-gray-400">Total Earned</div>
                <div class="halpha-text-xl halpha-text-white halpha-font-bold">
                    ${{ number_format($totalBonus, 2) }}
                </div>

                <div class="halpha-text-xs halpha-text-success">
                    +${{ number_format($todayBonus, 2) }} today
                </div>
            </div>
        </div>

        <!-- Progress -->
        <div class="halpha-mt-4">
            <div class="halpha-flex halpha-justify-between halpha-text-xs halpha-text-gray-400">
                <span>Rank Progress</span>
                <span>{{ $progress }}%</span>
            </div>

            <div class="halpha-w-full halpha-bg-gray-700 halpha-h-2 halpha-rounded halpha-mt-1">
                <div class="halpha-bg-accent-2 halpha-h-2 halpha-rounded halpha-transition-all"
                     style="width: {{ $progress }}%">
                </div>
            </div>
        </div>
    </div>

    <div class="halpha-card halpha-p-4 halpha-border halpha-border-red-500/20">

        <div class="halpha-flex halpha-justify-between halpha-items-center">

            <div>
                <div class="halpha-text-xs halpha-text-gray-400">
                    Missed Earnings
                </div>

                <div class="halpha-text-lg halpha-text-red-400 halpha-font-semibold">
                    ${{ number_format($missedTotal, 2) }}
                </div>

                <div class="halpha-text-xs halpha-text-gray-500">
                    Upgrade your rank to unlock these earnings
                </div>
            </div>

            <div class="halpha-text-right">
                <div class="halpha-text-xs halpha-text-gray-400">
                    Locked Levels
                </div>

                <div class="halpha-text-sm halpha-text-white">
                    L{{ ($rank->level ?? 1)+1 }} - L10
                </div>
            </div>
        </div>
    </div>


    <!--  LEVEL BREAKDOWN -->
    <div class="halpha-card halpha-p-4">
        <div class="halpha-text-sm halpha-text-gray-400 halpha-mb-3">
            Earnings by Level
        </div>

        <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-3 halpha-gap-3">

            @foreach($levels as $lvl)
                <div class="halpha-bg-gray-800 halpha-rounded halpha-p-3 halpha-text-center">

                    <div class="halpha-text-xs halpha-text-gray-400">
                        L{{ $lvl['level'] }}
                    </div>

                    <div class="halpha-text-sm halpha-text-accent-2">
                        {{ $lvl['percent'] }}%
                    </div>

                    <div class="halpha-text-white halpha-font-semibold">
                        ${{ number_format($lvl['amount'], 2) }}
                    </div>

                </div>
            @endforeach

        </div>
    </div>


    <!--  BONUS TYPES -->
    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">

        <div class="halpha-card halpha-p-3">
            <div class="halpha-text-xs halpha-text-gray-400">ROI Bonus</div>
            <div class="halpha-text-white halpha-font-semibold">
                ${{ number_format(collect($bonuses)->where('type','roi')->sum('amount'), 2) }}
            </div>
        </div>

        <div class="halpha-card halpha-p-3">
            <div class="halpha-text-xs halpha-text-gray-400">Global Bonus</div>
            <div class="halpha-text-white halpha-font-semibold">
                ${{ number_format(collect($bonuses)->whereIn('type',['global_override','global_pool'])->sum('amount'), 2) }}
            </div>
        </div>

    </div>


    <!--  ACTIVITY FEED -->
    <div class="halpha-card halpha-p-4 halpha-space-y-3">

        <div class="halpha-flex halpha-justify-between">
            <div class="halpha-text-sm halpha-text-gray-400">
                Bonus Activity
            </div>
        </div>

        @forelse($bonuses as $bonus)
            <div class="halpha-flex halpha-justify-between halpha-items-center halpha-border-b halpha-border-gray-800 halpha-pb-2">

                <div>
                    <div class="halpha-text-sm halpha-text-white">
                        +${{ number_format($bonus->amount, 2) }}
                    </div>

                    <div class="halpha-text-xs halpha-text-gray-400">
                        {{ $bonus->sourceUser->name ?? 'System' }}
                        • L{{ $bonus->level }}
                        • {{ ucfirst(str_replace('_',' ', $bonus->type)) }}
                    </div>
                </div>

                <div class="halpha-text-xs halpha-text-gray-500">
                    {{ $bonus->created_at->diffForHumans() }}
                </div>
            </div>

        @empty
            <div class="halpha-text-center halpha-text-gray-500 text-sm">
                No bonus activity yet
            </div>
        @endforelse

    </div>

    <div class="halpha-card halpha-p-4 halpha-space-y-2">

        <div class="halpha-text-sm halpha-text-gray-400">
            Missed Breakdown
        </div>

        @foreach($missedBreakdown as $miss)
            <div class="halpha-flex halpha-justify-between halpha-text-xs">

                <span class="halpha-text-gray-300">
                    Level {{ $miss->level }}
                </span>

                <span class="halpha-text-red-400">
                    ${{ number_format($miss->amount, 2) }}
                </span>

            </div>
        @endforeach

    </div>

</div>