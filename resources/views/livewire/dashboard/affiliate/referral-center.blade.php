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

    <div
    class="halpha-bg-card-bg halpha-rounded-xl halpha-border halpha-border-white/5 halpha-p-5 halpha-shadow-[0_0_2px_rgba(0,255,255,0.50)]">

        <div class="halpha-flex halpha-items-center halpha-justify-between halpha-mb-4">
            <h6 class="halpha-text-muted halpha-flex halpha-items-center halpha-gap-2 halpha-text-sm halpha-uppercase halpha-tracking-wide">
                <x-fas-user-tie class="halpha-w-4 halpha-h-4 halpha-text-accent-2" />
                My Sponsor
            </h6>

            @if($sponsor)
                <span class="halpha-text-xs halpha-bg-success/20 halpha-text-success halpha-px-2 halpha-py-1 halpha-rounded-full">
                    {{ $active ? 'Active' : 'Inactive' }}
                </span>
            @endif
        </div>

        @if($sponsor)

            @php
                $initials = strtoupper(substr($sponsor->name, 0, 1));
                $maskedEmail = preg_replace('/(^.).*(@.*$)/', '$1***$2', $sponsor->email);
            @endphp

            <div class="halpha-flex halpha-items-center halpha-gap-4">

                <!-- Avatar -->
                <div class="halpha-w-12 halpha-h-12 halpha-rounded-full halpha-bg-gradient-to-r halpha-from-accent-3 halpha-to-accent-2 halpha-flex halpha-items-center halpha-justify-center halpha-text-white halpha-font-semibold halpha-text-lg">
                    {{ $initials }}
                </div>

                <!-- Sponsor Info -->
                <div class="halpha-flex halpha-flex-col halpha-gap-1">
                    <span class="halpha-text-lg halpha-font-semibold halpha-text-white">
                        {{ ucwords($sponsor->name) }}
                    </span>

                    <span class="halpha-text-xs halpha-text-muted">
                        {{ $maskedEmail }}
                    </span>

                    <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-text-xs halpha-mt-1">
                        <span class="halpha-flex halpha-items-center halpha-gap-1">
                            <x-fas-id-badge class="halpha-w-3 halpha-h-3 halpha-text-accent-2" />
                            {{ $sponsor->affiliate_code ?? 'N/A' }}
                        </span>

                        <span class="halpha-flex halpha-items-center halpha-gap-1">
                            <x-fas-layer-group class="halpha-w-3 halpha-h-3 halpha-text-accent-2" />
                            {{ $sponsor->rank->rank->name ?? 'Member' }}
                        </span>
                    </div>
                </div>

            </div>

        @else

            <div class="halpha-text-xs halpha-text-muted">
                You joined without a sponsor.
            </div>

        @endif
    </div>

    <div class="halpha-card halpha-p-4 halpha-rounded-xl">
        <div class="halpha-flex halpha-justify-between halpha-items-center">
            <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-mb-3">
                Recent referrals
            </h3>

            @if (count($referrals))
                <select 
                    wire:model="levelFilter"
                    class="halpha-bg-gray-800 halpha-text-xs halpha-rounded halpha-px-3 halpha-py-2"
                >
                    <option value="0">All Levels</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">Level {{ $i }}</option>
                    @endfor
                </select>
            @endif
        </div>

       

        @if(count($referrals))
            <div class="halpha-space-y-3">
                @foreach($referrals as $ref)
                    <div class="halpha-flex halpha-justify-between halpha-text-xs">
                        <span class="halpha-text-gray-300 halpha-cursor-pointer hover:halpha-underline" wire:click="viewTree({{ $ref['user']->id }})">
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

    @if($showTree)
        <div class="halpha-card halpha-p-4 halpha-mt-4">
            <h4 class="halpha-text-sm halpha-font-semibold mb-2">Referral Tree</h4>

            @forelse($tree as $node)
                <div class="halpha-text-xs text-gray-400">
                    {{ $node->user->email }}
                </div>
            @empty
                <div class="text-gray-500 text-xs">No downlines</div>
            @endforelse
        </div>
    @endif




    <!-- Main content -->
</div>
@push('scripts')
    <script src="{{ asset('js/fn.js') }}"></script>
@endpush