<div wire:key="my-stakes-root" class="halpha-space-y-4">

    {{-- Header --}}
    <div class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-3">
        <div class="halpha-flex halpha-items-center halpha-gap-3">
            <button 
                wire:click="switchTab('list')"
                class="halpha-px-3 halpha-py-2 halpha-rounded {{ $tab === 'list' ? 'halpha-bg-accent-2 halpha-text-white' : 'halpha-bg-gray-800 halpha-text-gray-300' }}"
            >
                My stakes
            </button>

            <button 
                wire:click="switchTab('earnings')"
                class="halpha-px-3 halpha-py-2 halpha-rounded {{ $tab === 'earnings' ? 'halpha-bg-accent-2 halpha-text-white' : 'halpha-bg-gray-800 halpha-text-gray-300' }}"
            >
                Earnings
            </button>
        </div>

        <div class="halpha-flex halpha-items-center halpha-gap-2">
            <button 
                wire:click="exportCsv"
                class="halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700 halpha-text-gray-300"
            >
                Export CSV
            </button>
        </div>
    </div>

    {{-- Stakes Summary --}}
    <div class="halpha-grid halpha-grid-cols-1 sm:halpha-grid-cols-3 halpha-gap-3">
        <div class="halpha-card halpha-p-4 halpha-bg-gray-900 halpha-border halpha-border-gray-800">
            <div class="halpha-text-xs halpha-text-gray-400">Active Stake Value</div>
            <div class="halpha-text-lg halpha-font-semibold halpha-text-white">
                ${{ number_format($totalActive, 2) }}
            </div>
        </div>
        <div class="halpha-card halpha-p-4 halpha-bg-gray-900 halpha-border halpha-border-gray-800">
            <div class="halpha-text-xs halpha-text-gray-400">Total Earned</div>
            <div class="halpha-text-lg halpha-font-semibold halpha-text-white">
                ${{ number_format($totalEarned, 2) }}
            </div>
        </div>
        <div class="halpha-card halpha-p-4 halpha-bg-gray-900 halpha-border halpha-border-gray-800">
            <div class="halpha-text-xs halpha-text-gray-400">Stakes</div>
            <div class="halpha-text-lg halpha-font-semibold halpha-text-white">
                {{ $stakes->total() }}
            </div>
        </div>
    </div>

    {{-- Content area --}}
    @if($tab === 'list')
        <div class="halpha-space-y-3">
            <div class="halpha-flex halpha-items-center halpha-gap-3">
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="search" 
                    placeholder="Search stakes"
                    class="halpha-w-full halpha-bg-gray-800 halpha-text-white halpha-rounded halpha-px-3 halpha-py-2 halpha-text-sm" 
                />
                <select wire:model.live="filterStatus"
                    class="halpha-bg-gray-800 halpha-text-sm halpha-px-3 halpha-py-2 halpha-rounded">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="halpha-space-y-3">
                @forelse($stakes as $stake)
                    <div
                        class="halpha-card halpha-p-3 halpha-bg-gray-900 halpha-border halpha-border-gray-800 halpha-flex halpha-items-center halpha-justify-between">
                        <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-min-w-0">
                            <div
                                class="halpha-min-w-10 halpha-h-10 halpha-rounded-full halpha-bg-gray-800 halpha-flex halpha-items-center halpha-justify-center halpha-text-sm halpha-text-gray-300">
                                {{ strtoupper(substr($stake->plan->name ?? 'PL', 0, 2)) }}
                            </div>
                            <div class="halpha-min-w-0">
                                <div class="halpha-text-sm halpha-text-white halpha-font-semibold halpha-truncate">
                                    {{ $stake->plan->name ?? '—' }}
                                </div>
                                <div class="halpha-text-xs halpha-text-gray-400 halpha-truncate halpha-flex halpha-flex-col md:halpha-flex-row">
                                    <span>Amount: {{ number_format($stake->amount, 2) }}</span>
                                    <span class="halpha-hidden md:halpha-block">&nbsp; • &nbsp;</span>
                                    <span>Started: {{ $stake->started_at->format('d M, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-text-right">
                            <div class="halpha-text-sm halpha-font-semibold halpha-text-white">
                                ${{ number_format($stake->earned_total ?? 0, 2) }}
                            </div>
                            <button 
                                wire:click="viewStake({{ $stake->id }})"
                                class="halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-text-xs halpha-text-gray-300"
                            >
                                View
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="halpha-text-center halpha-py-8 halpha-text-gray-400">You have no stakes yet.</div>
                @endforelse
            </div>

            <div class="halpha-mt-3">
                {{ $stakes->links() }}
            </div>
        </div>
    @elseif($tab === 'earnings')
        <div class="halpha-space-y-4">
            {{-- Chart --}}
            <div class="halpha-card halpha-p-4 halpha-bg-gray-900 halpha-border halpha-border-gray-800">
                <div class="halpha-text-sm halpha-text-gray-400">Earnings (last 30 days)</div>
                <div class="halpha-mt-3 halpha-h-20 halpha-w-full halpha-bg-gray-800 halpha-rounded overflow-hidden">
                    <svg viewBox="0 0 100 30" class="halpha-w-full halpha-h-full">
                        <polyline fill="none" stroke="var(--halpha-accent-2)" stroke-width="1.5"
                            points="0,20 10,15 20,12 30,9 40,11 50,7 60,10 70,5 80,9 90,6 100,4" />
                    </svg>
                </div>
            </div>

            {{-- Data Table --}}
            <div class="halpha-card halpha-p-4 halpha-bg-gray-900 halpha-border halpha-border-gray-800">
                <div class="halpha-flex halpha-items-center halpha-justify-between">
                    <div class="halpha-text-sm halpha-text-gray-400">Earnings by stake</div>
                    <button wire:click="exportCsv"
                        class="halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700 halpha-text-gray-300">Export
                        CSV</button>
                </div>

                <div class="halpha-mt-3 halpha-overflow-auto">
                    <table class="halpha-w-full halpha-text-left halpha-text-sm">
                        <thead>
                            <tr class="halpha-text-xs halpha-text-gray-400">
                                <th class="halpha-py-2">Stake</th>
                                <th class="halpha-py-2">Amount</th>
                                <th class="halpha-py-2">Earned</th>
                                <th class="halpha-py-2 halpha-hidden sm:halpha-block">APY</th>
                                <th class="halpha-py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stakes as $stake)
                                <tr class="halpha-border-t halpha-border-gray-800">
                                    <td class="halpha-py-3 halpha-capitalize">{{ $stake->plan->name ?? '—' }}</td>
                                    <td class="halpha-py-3">
                                        ${{ number_format($stake->amount, 2) }}
                                    </td>
                                    <td class="halpha-py-3">
                                        ${{ number_format($stake->earned_total ?? 0, 2) }}
                                    </td>
                                    <td class="halpha-py-3 halpha-hidden sm:halpha-block">
                                        {{ rtrim((string) $stake->plan->daily_roi, '.') }}%
                                    </td>
                                    <td class="halpha-py-3 halpha-text-xs halpha-text-gray-400">
                                        <span class="halpha-bg-accent-2 halpha-text-white halpha-px-2 halpha-rounded-full halpha-py-0.5">
                                            {{ ucfirst($stake->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Details --}}
    @if($tab === 'details' && $selectedStakeId)
        @php $s = \App\Models\Stake::with('plan')->find($selectedStakeId); @endphp
        @if($s)
            <div class="halpha-card halpha-p-4 halpha-bg-gray-900 halpha-border halpha-border-gray-800">
                <div class="halpha-flex halpha-items-start halpha-gap-4">
                    <div>
                        <div class="halpha-text-sm halpha-text-gray-400">Stake #{{ $s->id }}</div>
                        <div class="halpha-text-lg halpha-font-semibold halpha-text-white">{{ $s->plan->name ?? '—' }}</div>
                        <div class="halpha-text-xs halpha-text-gray-400">
                            Started: {{ optional($s->started_at)->format('d M, Y') }}
                        </div>
                    </div>
                    <div class="halpha-ml-auto halpha-text-right">
                        <div class="halpha-text-xs halpha-text-gray-400">Amount</div>
                        <div class="halpha-text-lg halpha-font-semibold halpha-text-white">
                            ${{ number_format($s->amount, 2) }}
                        </div>
                    </div>
                </div>

                <div class="halpha-mt-4 halpha-space-y-2">
                    <div class="halpha-text-sm halpha-text-gray-400">Total earned</div>
                    <div class="halpha-text-lg halpha-font-semibold halpha-text-white">
                        ${{ number_format($s->earned_total ?? 0, 2) }}
                    </div>

                    <div class="halpha-flex halpha-items-center halpha-gap-2">
                        <button 
                            wire:click="$set('tab','list')"
                            class="halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700 halpha-text-xs halpha-text-gray-300"
                        >
                            Back
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endif

</div>