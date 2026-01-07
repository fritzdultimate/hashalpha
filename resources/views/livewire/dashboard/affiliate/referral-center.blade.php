<div class="halpha-space-y-5">
    <div class="halpha-space-y-5">
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Referral Center
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            Invite friends and earn from their activity
        </p>

        <div class="halpha-card halpha-p-4 halpha-rounded-xl halpha-bg-gray-900 halpha-border halpha-border-gray-800">
            <div class="halpha-text-xs halpha-text-gray-400">Your referral link</div>

            <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-mt-2">
                <input 
                    readonly 
                    value="{{ $referralLink  }}"
                    class="halpha-flex-1 halpha-bg-gray-800 halpha-text-xs halpha-text-white halpha-rounded halpha-px-3 halpha-py-2" 
                />

                <button onclick="copyToClipboard('{{ $referralLink }}', 'Referral link copied.')" class="halpha-px-3 halpha-py-2 halpha-bg-accent-2 halpha-text-white halpha-rounded halpha-text-xs hover:halpha-bg-accent-3">
                    Copy
                </button>
            </div>
        </div>
    </div>

    <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-4 halpha-gap-3">
        <x-affiliate.stat label="Total Referrals(Direct)" :value="$totalReferrals" />
        <x-affiliate.stat label="Active Referrals" :value="$activeReferrals" />
        <x-affiliate.stat label="Total Earnings" :value="number_format($totalEarnings, 2)" prefix="$" />
        <x-affiliate.stat label="This Month" :value="number_format($thisMonth, 2)" prefix="$" />
    </div>

    <div class="halpha-card halpha-p-4 halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-mb-3">
            Recent referrals
        </h3>

        @if(count($referrals))
            <div class="halpha-space-y-3">
                @foreach($referrals as $ref)
                    <div class="halpha-flex halpha-justify-between halpha-text-xs">
                        <span class="halpha-text-gray-300">
                            {{ Str::mask($ref['user']->email, '*', 3) }}
                            <span class="halpha-text-gray-500">
                                (Level {{ $ref['level'] }})
                            </span>
                        </span>

                        @if($ref['active'])
                            <span class="halpha-text-green-400">Active</span>
                        @else
                            <span class="halpha-text-gray-500">Inactive</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="halpha-text-xs halpha-text-gray-500 text-center py-6">
                No referrals yet. Share your referral link to start earning.
            </div>
        @endif
    </div>



    <!-- Main content -->
</div>
@push('scripts')
    <script src="{{ asset('js/fn.js') }}"></script>
@endpush