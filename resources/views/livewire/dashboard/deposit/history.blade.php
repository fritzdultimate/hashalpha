<div class="halpha-w-full halpha-min-h-screen halpha-flex halpha-justify-center halpha-bg-transparent halpha-py-6">
    @php
        $statusClasses = [
            'completed' => 'halpha-text-green-400 halpha-bg-green-900/20',
            'pending'   => 'halpha-text-yellow-300 halpha-bg-yellow-900/20',
            'waiting'   => 'halpha-text-orange-300 halpha-bg-orange-900/20',
            'failed'    => 'halpha-text-red-400 halpha-bg-red-900/20',
        ];
    @endphp
    <div
        class="halpha-w-full halpha-max-w-[900px] halpha-rounded-xl md:halpha-p-4 halpha-space-y-4">

        <header class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-4">
            <h1 class="halpha-text-lg halpha-font-semibold halpha-text-white">Transaction history</h1>
            <div class="halpha-text-sm halpha-text-gray-400 halpha-whitespace-nowrap">
                Total: <span
                    class="halpha-font-medium halpha-text-white">${{ number_format($totalAmount ?? 0, 2) }}</span>
            </div>
        </header>

        {{-- Search & filters (Livewire-controlled) --}}
        <div
            class="halpha-flex halpha-flex-col halpha-gap-3 sm:halpha-flex-row halpha-items-start sm:halpha-items-center">
            <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-w-full sm:halpha-w-auto">
                <input wire:model.live="search" placeholder="Search by currency, reference or label"
                    class="halpha-w-full sm:halpha-w-[340px] halpha-rounded halpha-px-3 halpha-py-2 halpha-bg-gray-800 halpha-text-sm halpha-text-white halpha-outline-none" />
                <button wire:click="$set('search','')"
                    class="halpha-ml-2 halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Clear</button>
            </div>

            <div class="halpha-mt-2 sm:halpha-mt-0 halpha-ml-auto halpha-flex halpha-items-center halpha-gap-2">
                <select wire:model.live="status"
                    class="halpha-bg-gray-800 halpha-text-sm halpha-px-3 halpha-py-2 halpha-rounded">
                    <option value="">All statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
        </div>

        {{-- Table header (desktop) --}}
        <div
            class="halpha-hidden md:halpha-grid halpha-grid-cols-6 halpha-gap-4 halpha-items-center halpha-text-xs halpha-text-gray-400 halpha-py-2 halpha-border-b halpha-border-gray-800">
            <div>Transaction</div>
            <div>Amount</div>
            <div>Network / Currency</div>
            <div>Date</div>
            <div>Status</div>
            <div class="halpha-text-right">Action</div>
        </div>

        {{-- Items (server-rendered by Livewire) --}}
        <ul class="halpha-space-y-3">
            @forelse ($transactions as $tx)
                @php
                    $ref = $tx->address;
                    // create short form: first 10 chars + ... + last 6 chars (only if longer)
                    $shortRef = strlen($ref) > 18 ? substr($ref, 0, 10) . '...' . substr($ref, -6) : $ref;
                @endphp

                <li
                    class="halpha-bg-gray-800 halpha-p-3 halpha-rounded-md halpha-transition halpha-duration-150 hover:halpha-bg-gray-700
                            halpha-flex halpha-flex-col md:halpha-grid md:halpha-grid-cols-6 md:halpha-items-center halpha-gap-3">

                    {{-- Transaction (label + reference) - occupies 2 cols on md+ --}}
                    <div class="halpha-flex halpha-items-start halpha-gap-3 halpha-min-w-0">
                        <div
                            class="halpha-flex halpha-items-center halpha-justify-center halpha-w-10 halpha-h-10 halpha-rounded-full halpha-flex-shrink-0">
                            <div
                                class="halpha-w-10 halpha-h-10 halpha-rounded-full halpha-flex halpha-items-center halpha-justify-center
                                        {{ $tx->currency ? 'halpha-bg-' . \Illuminate\Support\Str::slug(strtolower($tx->currency), '-') : 'halpha-bg-gray-700' }}">
                                <span class="icon {{ $tx->currency ? 'icon-' . strtolower($tx->currency) : '' }}"></span>
                            </div>
                        </div>

                        <div class="halpha-min-w-0">
                            <div class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-truncate">
                                {{ $this->mapCurrencyLabel($tx->currency) ?? 'Bitcoin' }}
                            </div>
                            {{-- short reference ensures no overflow on mobile --}}
                            <div class="halpha-text-xs halpha-text-gray-400 halpha-truncate" title="{{ $ref }}">
                                {{ $shortRef }}
                            </div>
                        </div>
                    </div>

                    {{-- Amount (fixed column) --}}
                    <div
                        class="halpha-text-sm halpha-font-semibold halpha-text-white/30 halpha-w-full md:halpha-col-span-1 halpha-flex halpha-justify-end md:halpha-justify-start halpha-items-center halpha-flex-none halpha-whitespace-nowrap">
                        ${{ number_format($tx->amount, 2) }}
                    </div>

                    {{-- Network / Currency (desktop only) --}}
                    <div
                        class="halpha-hidden md:halpha-flex md:halpha-items-center md:halpha-col-span-1 halpha-text-xs halpha-text-gray-300 halpha-truncate">
                        {{ $tx->currency ?? '—' }} &middot;  {{ $this->mapCurrencyLabel($tx->currency) }}
                    </div>

                    {{-- Date --}}
                    <div class="halpha-text-xs halpha-text-gray-400 md:halpha-col-span-1 halpha-whitespace-nowrap">
                        {{ $tx->created_at->format('M d, Y H:i') }}
                    </div>

                    {{-- Status + Actions --}}
                    <div class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-3 md:halpha-col-span-2">
                        <div class="halpha-flex halpha-items-center halpha-gap-2">
                            <span
                                class="{{ $statusClasses[$tx->status->value] ?? 'halpha-text-gray-400 halpha-bg-gray-900/10' }} halpha-px-2 halpha-py-1 halpha-rounded-full halpha-text-xs halpha-font-semibold">
                                {{ strtolower($tx->status->value) }}
                            </span>
                        </div>

                        <div class="halpha-flex halpha-items-center halpha-gap-2">
                            <button wire:click="showDetails({{ $tx->id }})"
                                class="halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-1 halpha-rounded halpha-border halpha-border-gray-700">Details</button>

                            {{-- inline copy (small) - uses Livewire method and also does instant client copy with JS for
                            snappy UX --}}
                            <button onclick="copyRefAndEmit('{{ addslashes($ref) }}')"
                                class="halpha-text-xs halpha-text-gray-300 halpha-ml-2 halpha-flex halpha-items-center halpha-gap-1"
                                title="Copy reference" aria-label="Copy reference">
                                <x-heroicon-o-clipboard class="halpha-w-4 halpha-h-4" />
                            </button>
                        </div>
                    </div>
                </li>
            @empty
                <li class="halpha-text-center halpha-text-gray-400 halpha-p-6 halpha-bg-gray-800 halpha-rounded">No
                    transactions found.</li>
            @endforelse
        </ul>


        {{-- Pagination --}}

        <div
            class="halpha-flex halpha-flex-col md:halpha-flex-row halpha-items-center halpha-justify-between halpha-gap-3 halpha-p-4 halpha-border-t halpha-border-white/5 halpha-border-red-600 halpha-border"
        >
            <div class="halpha-text-xs halpha-text-muted">Showing {{ $transactions->firstItem() ?? 0 }} to
                {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() ?? count($transactions) }}</div>
            <div class="halpha-text-sm halpha-pagination halpha-flex halpha-items-center halpha-gap-2 halpha-w-full">{{ $transactions->links() }}</div>
        </div>

        {{-- Details modal (Livewire-driven) --}}
        @if($showModal && $selected)
            <div wire:keydown.escape="closeModal" tabindex="-1"
                class="halpha-fixed halpha-inset-0 halpha-z-50 halpha-flex halpha-items-center halpha-justify-center">
                <div class="halpha-absolute halpha-inset-0 halpha-bg-black/60" wire:click="closeModal"></div>

                <div class="halpha-bg-gray-900 halpha-rounded-lg halpha-w-[92%] md:halpha-w-[720px] halpha-p-4 halpha-z-50 halpha-shadow-lg"
                    role="dialog" aria-modal="true">
                    <div class="halpha-flex halpha-items-start halpha-justify-between halpha-gap-3">
                        <div>
                            <h2 class="halpha-text-lg halpha-font-semibold halpha-text-white">{{ $this->mapCurrencyLabel($selected->currency) }}</h2>
                            <p class="halpha-text-xs halpha-text-gray-400 truncate">{{ $selected->tx_hash ?? '—' }}</p>
                        </div>
                        <button wire:click="closeModal" class="halpha-text-gray-400">Close</button>
                    </div>

                    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-4 halpha-mt-4">
                        <div>
                            <div class="halpha-text-xs halpha-text-gray-400">Amount</div>
                            <div class="halpha-text-sm halpha-font-semibold halpha-text-white">
                                {{ number_format($selected->amount, 2) }}
                            </div>
                        </div>

                        <div class="halpha-flex halpha-flex-col halpha-gap-2 halpha-items-center">
                            <div class="halpha-text-xs halpha-text-gray-400">Status</div>
                            <div class="halpha-text-sm halpha-font-semibold {{ $statusClasses[$selected->status->value] ?? 'halpha-text-gray-400 halpha-bg-gray-900/10' }} halpha-inline-block halpha-px-3 halpha-py-0.5 halpha-rounded-full halpha-shadow">{{ $selected->status->value }}</div>
                        </div>

                        <div>
                            <div class="halpha-text-xs halpha-text-gray-400">Network</div>
                            <div class="halpha-text-sm halpha-font-semibold halpha-text-white halpha-uppercase">{{ $selected->currency }}
                            </div>
                        </div>

                        <div>
                            <div class="halpha-text-xs halpha-text-gray-400">Created</div>
                            <div class="halpha-text-sm halpha-font-semibold halpha-text-white">
                                {{ $selected->created_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="halpha-mt-4 halpha-text-sm halpha-text-gray-300 halpha-space-y-2">
                        <div><strong class="halpha-text-gray-200">Reference:</strong> <span
                                class="truncate block">{{ $selected->tx_hash ?? '—' }}</span></div>
                        <div><strong class="halpha-text-gray-200">Notes:</strong> <span>{{ $selected->note ?? '—' }}</span>
                        </div>
                        <div><strong class="halpha-text-gray-200">Address:</strong>
                            <span>{{ $selected->address ?? '—' }}</span>
                        </div>
                    </div>

                    <div class="halpha-flex halpha-justify-end halpha-gap-2 halpha-mt-4">
                        <a href="{{ $selected->explorer_url ?? '#' }}" target="_blank"
                            class="halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700 halpha-hidden">View
                            on explorer</a>
                        <button wire:click="closeModal"
                            class="halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Done</button>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

<script>
    function copyRefAndEmit(ref) {
        if (!ref) return;
        if (navigator.clipboard) {
            navigator.clipboard.writeText(ref).then(() => {
                // toast
                const t = document.createElement('div');
                t.textContent = 'Reference copied';
                t.className = 'halpha-fixed halpha-bottom-4 halpha-right-4 halpha-bg-gray-800 halpha-text-white halpha-p-2 halpha-rounded';
                document.body.appendChild(t);
                setTimeout(() => t.remove(), 1600);
            }).catch(() => {  });
        }
    }
</script>