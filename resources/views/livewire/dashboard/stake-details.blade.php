{{-- Details --}}
<div>
    @if($selectedStakeId)
        @php $s = \App\Models\Stake::with('plan')->find($selectedStakeId); @endphp
        @if($s)
            <div class="halpha-card halpha-p-4 halpha-bg-gray-900 halpha-border halpha-border-gray-800">
                <div class="halpha-flex halpha-items-start halpha-gap-4">
                    <div>
                        <div class="halpha-text-sm halpha-text-gray-400">Stake #{{ $s->id }}</div>
                        <div class="halpha-text-lg halpha-font-semibold halpha-text-white">{{ $s->plan->name ?? '—' }}</div>
                        <div class="halpha-text-xs halpha-text-gray-400">
                            Started: {{ optional($s->started_at)->format('d M, Y • h:i A') }}
                        </div>
                    </div>
                    <div class="halpha-ml-auto halpha-text-right">
                        <div class="halpha-text-xs halpha-text-gray-400">Amount</div>
                        <div class="halpha-text-lg halpha-font-semibold halpha-text-white">
                            ${{ number_format($s->amount, 2) }}
                        </div>
                    </div>
                </div>

                <div class="halpha-mt-4 halpha-flex halpha-justify-between">
                    <div class="halpha-space-y-2">
                        <div class="halpha-text-sm halpha-text-gray-400">Total earned</div>
                        <div class="halpha-text-lg halpha-font-semibold halpha-text-white">
                            ${{ number_format($s->total_claimed ?? 0, 2) }}
                        </div>

                        <div class="halpha-flex halpha-items-center halpha-gap-2">
                            <button 
                                wire:click="goBack"
                                class="halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700 halpha-text-xs halpha-text-gray-300"
                            >
                                Back
                            </button>
                        </div>
                    </div>

                    <div class="halpha-mt-auto">
                        <x-halpha-rounded-progress
                            :started-at="$s->started_at"
                            :duration-days="10"
                            size="56"
                            stroke="6"
                        />
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>