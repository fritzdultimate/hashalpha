<div class="halpha-space-y-6">

    <div>
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Compounding Offers
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            When a stake matures, you may be offered the option to reinvest it into a new locked term.
        </p>
    </div>

    @if ($this->pendingOffer)
        @php($offer = $this->pendingOffer)
        <div class="halpha-card halpha-p-4 halpha-space-y-4 halpha-border halpha-border-accent-2">

            <div>
                <p class="halpha-text-sm halpha-font-semibold halpha-text-white">
                    You have a compounding offer waiting
                </p>
                <p class="halpha-text-xs halpha-text-gray-400 halpha-mt-1">
                    From your matured stake #stk{{ $offer->stake_id }}. Review the terms below before deciding.
                </p>
            </div>

            <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-4 halpha-gap-3 halpha-text-xs">
                <div class="halpha-card halpha-bg-card-soft halpha-p-3">
                    <p class="halpha-text-gray-400">Daily ROI</p>
                    <p class="halpha-text-white halpha-font-semibold halpha-mt-1">{{ $offer->min_roi }}% – {{ $offer->max_roi }}%</p>
                </div>
                <div class="halpha-card halpha-bg-card-soft halpha-p-3">
                    <p class="halpha-text-gray-400">Term</p>
                    <p class="halpha-text-white halpha-font-semibold halpha-mt-1">{{ $offer->duration_days }} days</p>
                </div>
                <div class="halpha-card halpha-bg-card-soft halpha-p-3">
                    <p class="halpha-text-gray-400">Amount to Lock</p>
                    <p class="halpha-text-white halpha-font-semibold halpha-mt-1">
                        ${{ number_format($offer->stake->capital ?? $offer->stake->amount, 2) }}
                    </p>
                </div>
                <div class="halpha-card halpha-bg-card-soft halpha-p-3">
                    <p class="halpha-text-gray-400">Offer Expires</p>
                    <p class="halpha-text-white halpha-font-semibold halpha-mt-1">{{ $offer->expires_at?->format('M d, Y') ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="halpha-card halpha-bg-card-soft halpha-p-3 halpha-text-xs halpha-text-gray-400">
                <ul class="halpha-list-disc halpha-pl-4 halpha-space-y-1">
                    <li>This is entirely optional -- you choose whether to accept.</li>
                    <li>If accepted, the locked amount cannot be withdrawn until the term ends.</li>
                    <li>Rates and duration come directly from your matured stake's own plan.</li>
                    <li>You'll receive a final summary email once the term completes.</li>
                </ul>
            </div>

            <label class="halpha-flex halpha-items-center halpha-gap-2 halpha-text-xs halpha-text-gray-300">
                <input type="checkbox" wire:model="notifyDaily" class="halpha-accent-2" />
                Email me a daily progress update while this term is active (optional)
            </label>

            @error('offer')
                <p class="halpha-text-xs halpha-text-danger">{{ $message }}</p>
            @enderror

            <div class="halpha-flex halpha-gap-3">
                <button
                    wire:loading.attr="disabled"
                    wire:click="accept"
                    class="halpha-bg-accent-2 halpha-text-white halpha-text-sm halpha-h-10 halpha-px-4 halpha-rounded halpha-flex halpha-items-center halpha-justify-center disabled:halpha-opacity-40"
                >
                    <span wire:loading.remove wire:target="accept">Accept Offer</span>
                    <span wire:loading wire:target="accept" class="halpha-flex halpha-items-center">
                        <x-ri-loader-4-fill class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
                    </span>
                </button>

                <button
                    wire:loading.attr="disabled"
                    wire:click="decline"
                    class="halpha-card halpha-text-gray-300 halpha-text-sm halpha-h-10 halpha-px-4 halpha-rounded halpha-flex halpha-items-center halpha-justify-center disabled:halpha-opacity-40"
                >
                    <span wire:loading.remove wire:target="decline">Decline</span>
                    <span wire:loading wire:target="decline" class="halpha-flex halpha-items-center">
                        <x-ri-loader-4-fill class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
                    </span>
                </button>
            </div>

        </div>
    @endif

    @if ($this->activeTerm)
        @php($term = $this->activeTerm)
        <div class="halpha-card halpha-p-4 halpha-space-y-2">
            <p class="halpha-text-sm halpha-font-semibold halpha-text-white">Active Compounding Term</p>
            <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-3 halpha-gap-3 halpha-text-xs halpha-mt-2">
                <div>
                    <p class="halpha-text-gray-400">Locked Amount</p>
                    <p class="halpha-text-white halpha-font-semibold halpha-mt-1">${{ number_format($term->amount, 2) }}</p>
                </div>
                <div>
                    <p class="halpha-text-gray-400">Ends</p>
                    <p class="halpha-text-white halpha-font-semibold halpha-mt-1">{{ $term->expected_end_date?->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="halpha-text-gray-400">Daily Emails</p>
                    <p class="halpha-text-white halpha-font-semibold halpha-mt-1">{{ $term->notify_daily ? 'Enabled' : 'Disabled' }}</p>
                </div>
            </div>
            <p class="halpha-text-xs halpha-text-gray-400 halpha-mt-2">
                Withdrawals are locked until this term completes.
            </p>
        </div>
    @endif

    @if (! $this->pendingOffer && ! $this->activeTerm)
        <div class="halpha-card halpha-p-4 halpha-text-xs halpha-text-gray-400">
            You don't have any pending compounding offers right now. When a stake matures, an offer may appear here.
        </div>
    @endif

    @if ($this->history->isNotEmpty())
        <div class="halpha-card halpha-p-4">
            <p class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-mb-3">History</p>
            <div class="halpha-overflow-x-auto">
                <table class="halpha-w-full halpha-text-xs halpha-text-left">
                    <thead class="halpha-text-gray-400">
                        <tr>
                            <th class="halpha-py-2 halpha-pr-4">Offered</th>
                            <th class="halpha-py-2 halpha-pr-4">Rate</th>
                            <th class="halpha-py-2 halpha-pr-4">Term</th>
                            <th class="halpha-py-2 halpha-pr-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="halpha-text-gray-300">
                        @foreach ($this->history as $item)
                            <tr class="halpha-border-t halpha-border-gray-800">
                                <td class="halpha-py-2 halpha-pr-4">{{ $item->offered_at?->format('M d, Y') }}</td>
                                <td class="halpha-py-2 halpha-pr-4">{{ $item->min_roi }}% – {{ $item->max_roi }}%</td>
                                <td class="halpha-py-2 halpha-pr-4">{{ $item->duration_days }} days</td>
                                <td class="halpha-py-2 halpha-pr-4 halpha-capitalize">{{ $item->status->value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
