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
                    ${{ number_format($totalBonus, 5) }}
                </div>

                <div class="halpha-text-xs halpha-text-success">
                    +${{ number_format($todayBonus, 8) }} today
                </div>
            </div>
        </div>

        <!-- Progress -->
        <div class="halpha-mt-4">
            <div class="halpha-flex halpha-justify-between halpha-text-xs halpha-text-gray-400">
                <span>Rank Progress to <strong class="halpha-capitalize halpha-text-white">{{ $nextRank->name }}</strong></span>
                <span>{{ $progress }}%</span>
            </div>

            <div class="halpha-w-full halpha-bg-gray-700 halpha-h-2 halpha-rounded halpha-mt-1">
                <div class="halpha-bg-accent-2 halpha-h-2 halpha-rounded halpha-transition-all"
                     style="width: {{ $progress }}%">
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ open: false }" class="halpha-card halpha-p-4">

        <div class="halpha-flex halpha-justify-between">
            <p class="halpha-text-sm halpha-text-gray-400">
                Rank Requirements
            </p>

            <button @click="open = !open"
                class="halpha-text-xs halpha-text-accent-2">
                View
            </button>
        </div>

        <div x-show="open" x-transition class="halpha-mt-3 halpha-space-y-2">

            <div class="halpha-card halpha-p-5 halpha-space-y-4">

                <!-- HEADER -->
                <div class="halpha-flex halpha-justify-between halpha-items-center">
                    <div>
                        <p class="halpha-text-sm halpha-text-gray-400">
                            Rank Progression
                        </p>
                        <p class="halpha-text-xs halpha-text-gray-500">
                            Unlock deeper earning levels as you advance
                        </p>
                    </div>
                </div>

                <!-- RANK LADDER -->
                <div class="halpha-space-y-3">

                    @foreach($allRanks as $r)

                        @php
                            $isCurrent = ($rank?->id === $r->id);
                            $isUnlocked = ($rank?->level ?? 0) >= $r->level;
                        @endphp

                        <div class="halpha-rounded-xl halpha-p-4 halpha-transition halpha-border
                            {{ $isCurrent 
                                ? 'halpha-bg-gradient-to-r halpha-from-emerald-500/10 halpha-to-green-500/10 halpha-border-emerald-400/30 halpha-shadow-[0_0_25px_rgba(16,185,129,0.15)]'
                                : ($isUnlocked 
                                    ? 'halpha-bg-gray-900 halpha-border-white/5'
                                    : 'halpha-bg-gray-900/50 halpha-border-white/5 halpha-opacity-60') }}">

                            <div class="halpha-flex halpha-justify-between halpha-items-center">

                                <!-- LEFT -->
                                <div class="halpha-space-y-1">

                                    <p class="halpha-text-white halpha-text-sm halpha-font-semibold">
                                        {{ $r->name }}
                                    </p>

                                    <p class="halpha-text-[11px] halpha-text-gray-400">
                                        Unlocks up to <span class="halpha-text-white">Level {{ $r->level }}</span>
                                    </p>

                                </div>

                                <!-- STATUS -->
                                <div class="halpha-text-xs">
                                    @if($isCurrent)
                                        <span class="halpha-text-emerald-400 halpha-font-semibold">
                                            ● Current
                                        </span>
                                    @elseif($isUnlocked)
                                        <span class="halpha-text-green-400">
                                            ✓ Unlocked
                                        </span>
                                    @else
                                        <span class="halpha-text-gray-500">
                                            🔒 Locked
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <!-- REQUIREMENTS -->
                            <div class="halpha-mt-3 halpha-space-y-2">

                                <!-- Deposit -->
                                <div>
                                    <div class="halpha-flex halpha-justify-between halpha-text-[11px] halpha-text-gray-400">
                                        <span>Capital</span>
                                        <span><strong>${{ number_format($currentPersonalVolume) }}</strong>/${{ number_format($r->deposits) }}</span>
                                    </div>

                                    <div class="halpha-w-full halpha-h-1 halpha-bg-gray-800 halpha-rounded mt-1">
                                        <div class="halpha-h-full halpha-bg-accent-2 halpha-rounded"
                                            style="width: {{ min(100, ($currentPersonalVolume / max(1, $r->deposits)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Directs -->
                                <div>
                                    <div class="halpha-flex halpha-justify-between halpha-text-[11px] halpha-text-gray-400">
                                        <span>Direct Referrals</span>
                                        <span><strong>{{ $userDirects }}</strong>/{{ $r->direct_referrals }}</span>
                                    </div>

                                    <div class="halpha-w-full halpha-h-1 halpha-bg-gray-800 halpha-rounded halpha-mt-1">
                                        <div class="halpha-h-full halpha-bg-accent-2 halpha-rounded"
                                            style="width: {{ min(100, ($userDirects / max(1, $r->direct_referrals)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- CTA FOR LOCKED -->
                            @if(!$isUnlocked)
                                <div class="halpha-mt-3 halpha-text-[11px] halpha-text-yellow-400">
                                    Complete requirements to unlock this rank
                                </div>
                            @endif

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    <!-- Missed -->
    <div class="halpha-card halpha-p-4 halpha-border halpha-border-red-500/20">

        <div class="halpha-flex halpha-justify-between halpha-items-center">

            <div>
                <div class="halpha-text-xs halpha-text-gray-400">
                    Missed Earnings
                </div>

                <div class="halpha-text-lg halpha-text-red-400 halpha-font-semibold">
                    ${{ number_format($missedTotal, 5) }}
                </div>

                <div class="halpha-text-xs halpha-text-gray-500">
                    Upgrade your rank and meet up requirements to unlock these earnings
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

    <div class="halpha-text-xs halpha-text-yellow-400 halpha-bg-yellow-400/10 halpha-p-3 halpha-rounded-lg">

        💡 You're close to unlocking more earnings.
        Complete your remaining requirements to activate higher-level bonuses.

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
                        ${{ number_format($lvl['amount'], 8) }}
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
                ${{ number_format(collect($bonuses)->where('type','roi')->sum('amount'), 5) }}
            </div>
        </div>

        <div class="halpha-card halpha-p-3">
            <div class="halpha-text-xs halpha-text-gray-400">Global Bonus</div>
            <div class="halpha-text-white halpha-font-semibold">
                ${{ number_format(collect($bonuses)->whereIn('type',['global_override','global_pool'])->sum('amount'), 5) }}
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
                        +${{ number_format($bonus->amount, 5) }}
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

        <div class="halpha-mt-4 halpha-pagination">
            {{ $bonuses->links() }}
        </div>

    </div>

    <div class="halpha-card halpha-p-4 halpha-space-y-2 halpha-hidden">

        <div class="halpha-text-sm halpha-text-gray-400">
            Missed Breakdown
        </div>

        @foreach($missedBreakdown as $miss)
            <div class="halpha-flex halpha-justify-between halpha-text-xs">

                <span class="halpha-text-gray-300">
                    Level {{ $miss['level'] }}
                </span>

                <span class="halpha-text-red-400">
                    ${{ number_format($miss['amount'], 5) }}
                </span>

            </div>
        @endforeach

    </div>

    <div x-data="{ open: false }" class="halpha-card halpha-p-5 halpha-space-y-4">

    <!-- HEADER -->
    <div class="halpha-flex halpha-justify-between halpha-items-center">
        <div>
            <p class="halpha-text-sm halpha-text-gray-400">
                Missed Breakdown
            </p>
            <p class="halpha-text-xs halpha-text-gray-500">
                Why earnings are locked
            </p>
        </div>

        <button @click="open = !open"
            class="halpha-text-xs halpha-text-accent-2 halpha-bg-accent-2/10 halpha-px-3 halpha-py-1 halpha-rounded-md hover:halpha-bg-accent-2/20 transition">
            View Insights
        </button>
    </div>

    <!-- CONTENT -->
    <div x-show="open" x-transition class="halpha-space-y-4">

        @foreach($bonuses->whereIn('type', ['missed', 'missed_rank']) as $miss)

            @php 
            
                $meta = json_decode($miss->meta ?? '{}', true); 
                $type = $miss->type;
            @endphp

            @if($type === 'missed')
                <div class="halpha-bg-gradient-to-br halpha-from-gray-900 halpha-to-gray-800 halpha-rounded-xl halpha-p-4 halpha-space-y-3 halpha-border halpha-border-white/5">

                    <!-- TOP -->
                    <div class="halpha-flex halpha-justify-between halpha-items-center">
                        <div>
                            <p class="halpha-text-white halpha-text-sm halpha-font-semibold">
                                Level {{ $miss->level }} Earnings Locked
                            </p>
                            <p class="halpha-text-xs halpha-text-gray-400">
                                You missed <span class="halpha-text-red-400 font-medium">
                                    ${{ number_format($miss->amount, 5) }}
                                </span>
                            </p>
                        </div>

                        <div class="halpha-text-xs halpha-text-red-400">
                            Not Qualified
                        </div>
                    </div>

                    <div>
                        <div class="halpha-flex halpha-justify-between halpha-text-[11px] halpha-text-gray-400">
                            <span>Capital Requirement</span>
                            <span>
                                ${{ number_format($meta['deposit_current'] ?? 0) }} /
                                ${{ number_format($meta['deposit_required'] ?? 0) }}
                            </span>
                        </div>

                        <div class="halpha-w-full halpha-h-1.5 halpha-bg-gray-800 halpha-rounded mt-1">
                            <div class="halpha-h-full halpha-bg-red-400 halpha-rounded"
                                style="width: {{ min(100, (($meta['deposit_current'] ?? 0) / max(1, $meta['deposit_required'] ?? 1)) * 100) }}%">
                            </div>
                        </div>
                    </div>

                    <!-- PROGRESS: DIRECTS -->
                    <div>
                        <div class="halpha-flex halpha-justify-between halpha-text-[11px] halpha-text-gray-400">
                            <span>Direct Referrals</span>
                            <span>
                                {{ $meta['direct_current'] ?? 0 }} /
                                {{ $meta['direct_required'] ?? 0 }}
                            </span>
                        </div>

                        <div class="halpha-w-full halpha-h-1.5 halpha-bg-gray-800 halpha-rounded mt-1">
                            <div class="halpha-h-full halpha-bg-red-400 halpha-rounded"
                                style="width: {{ min(100, (($meta['direct_current'] ?? 0) / max(1, $meta['direct_required'] ?? 1)) * 100) }}%">
                            </div>
                        </div>
                    </div>

                    <!-- WHY (HUMAN LANGUAGE) -->
                    <div class="halpha-text-[11px] halpha-text-gray-400 halpha-bg-white/5 halpha-p-2 halpha-rounded">

                        @if(($meta['missing_deposit'] ?? 0) > 0 && ($meta['missing_directs'] ?? 0) > 0)
                            You need an additional
                            <span class="halpha-text-red-400 font-medium">
                                ${{ number_format($meta['missing_deposit']) }}
                            </span>
                            in capital and
                            <span class="halpha-text-red-400 font-medium">
                                {{ $meta['missing_directs'] }} referrals
                            </span>
                            to unlock this level.
                        @elseif(($meta['missing_deposit'] ?? 0) > 0)
                            You need an additional
                            <span class="halpha-text-red-400 font-medium">
                                ${{ number_format($meta['missing_deposit']) }}
                            </span>
                            in capital to qualify.
                        @elseif(($meta['missing_directs'] ?? 0) > 0)
                            You need
                            <span class="halpha-text-red-400 font-medium">
                                {{ $meta['missing_directs'] }} more referrals
                            </span>
                            to qualify.
                        @else
                            Requirements not met.
                        @endif

                    </div>

                </div>
            @endif

            @if($type === 'missed_rank')

                <div class="halpha-bg-indigo-500/10 halpha-border halpha-border-indigo-400/20 halpha-p-3 halpha-rounded-lg">

                    <p class="halpha-text-xs halpha-text-indigo-300 font-semibold">
                        🔒 Rank Restriction
                    </p>

                    <p class="halpha-text-[11px] halpha-text-gray-400 mt-1">
                        Your current rank unlocks up to <span class="halpha-text-white font-medium">
                            Level {{ $meta['current_rank_level'] ?? '?' }}
                        </span>.

                        This earning was generated at
                        <span class="halpha-text-white font-medium">
                            Level {{ $meta['required_level'] ?? '?' }}
                        </span>.
                    </p>

                    <p class="halpha-text-[11px] halpha-text-indigo-300 mt-1">
                        Upgrade your rank to unlock deeper level earnings.
                    </p>

                </div>

            @endif

        @endforeach

        <div class="halpha-mt-4 halpha-pagination">
            {{ $bonuses->onEachSide(1)->links() }}
        </div>

    </div>

</div>

</div>