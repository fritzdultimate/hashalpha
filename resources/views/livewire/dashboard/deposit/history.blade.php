<div class="halpha-w-full halpha-min-h-screen halpha-flex halpha-justify-center halpha-bg-transparent halpha-py-6">
  <div class="halpha-w-full halpha-max-w-[900px] halpha-shadow halpha-shadow-white/10 halpha-bg-gray-900 halpha-rounded-xl halpha-p-4 halpha-space-y-4">

    <header class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-4">
      <h1 class="halpha-text-lg halpha-font-semibold halpha-text-white">Transaction history</h1>
      <div class="halpha-text-sm halpha-text-gray-400 halpha-whitespace-nowrap">
        Total: <span class="halpha-font-medium halpha-text-white">{{ number_format($totalAmount ?? 0, 2) }}</span>
      </div>
    </header>

    {{-- Search & filters (Livewire-controlled) --}}
    <div class="halpha-flex halpha-flex-col halpha-gap-3 sm:halpha-flex-row halpha-items-start sm:halpha-items-center">
      <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-w-full sm:halpha-w-auto">
        <input
          wire:model.debounce.300ms="search"
          placeholder="Search by currency, reference or label"
          class="halpha-w-full sm:halpha-w-[340px] halpha-rounded halpha-px-3 halpha-py-2 halpha-bg-gray-800 halpha-text-sm halpha-text-white halpha-outline-none"
        />
        <button
          wire:click="$set('search','')"
          class="halpha-ml-2 halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700"
        >Clear</button>
      </div>

      <div class="halpha-mt-2 sm:halpha-mt-0 halpha-ml-auto halpha-flex halpha-items-center halpha-gap-2">
        {{-- corrected wire:model.live -> wire:model --}}
        <select wire:model="status" class="halpha-bg-gray-800 halpha-text-sm halpha-px-3 halpha-py-2 halpha-rounded">
            <option value="">All statuses</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
        </select>
        <span class="halpha-text-xs halpha-text-gray-400 halpha-ml-2 halpha-hidden sm:halpha-inline-block">{{ $status }}</span>
      </div>
    </div>

    {{-- Table header (desktop) --}}
    <div class="halpha-hidden md:halpha-grid halpha-grid-cols-6 halpha-gap-4 halpha-items-center halpha-text-xs halpha-text-gray-400 halpha-py-2 halpha-border-b halpha-border-gray-800">
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
            {{-- mobile-first: stacked with responsive grid on md+ --}}
            <li class="halpha-flex halpha-flex-col md:halpha-grid md:halpha-grid-cols-6 halpha-gap-3 halpha-bg-gray-800 halpha-p-3 halpha-rounded-md halpha-transition halpha-duration-150 halpha-ease-in-out hover:halpha-bg-gray-700">
              {{-- Transaction (label + reference) --}}
              <div class="halpha-flex halpha-items-start halpha-gap-3 md:halpha-col-span-2">
                  <div class="halpha-flex halpha-items-center halpha-justify-center halpha-w-10 halpha-h-10 halpha-rounded-full halpha-flex-shrink-0">
                      {{-- safe avatar background: keep existing dynamic class but add fallback class to avoid invalid Tailwind classes --}}
                      <div class="halpha-w-10 halpha-h-10 halpha-rounded-full halpha-flex halpha-items-center halpha-justify-center
                                  {{ $tx->currency ? 'halpha-bg-' . Str::slug(strtolower($tx->currency), '-') : 'halpha-bg-gray-700' }}">
                          <span class="icon {{ $tx->currency ? 'icon-' . strtolower($tx->currency) : '' }}"></span>
                      </div>
                  </div>

                  <div class="halpha-min-w-0">
                      <div class="halpha-text-sm halpha-font-semibold halpha-text-white truncate">{{ $tx->label ?? 'Bitcoin' }}</div>
                      <div class="halpha-text-xs halpha-text-gray-400 truncate">{{ $tx->reference ?? 'd18373egetrfdhdjsu73uhsjsshgsb223sss' }}</div>
                  </div>
              </div>

              {{-- Amount --}}
              <div class="halpha-mt-2 md:halpha-mt-0 md:halpha-col-span-1 halpha-text-sm halpha-font-semibold halpha-text-white halpha-w-full">
                  {{ number_format($tx->amount, 2) }}
              </div>

              {{-- Network / Currency --}}
              <div class="halpha-hidden md:halpha-flex md:halpha-items-center md:halpha-col-span-1 halpha-text-xs halpha-text-gray-300 truncate">
                  {{ $tx->network ?? 'Bitcoin' }} • {{ $tx->currency }}
              </div>

              {{-- Date --}}
              <div class="halpha-mt-2 md:halpha-mt-0 halpha-text-xs halpha-text-gray-400 halpha-col-span-1 halpha-whitespace-nowrap">
                  {{ $tx->created_at->format('M d, Y H:i') }}
              </div>

              {{-- Status + Actions --}}
              <div class="halpha-flex halpha-items-center halpha-justify-between halpha-gap-3 halpha-mt-3 md:halpha-mt-0 md:halpha-col-span-1">
                  <div class="halpha-flex halpha-items-center halpha-gap-2">
                    <span class="@if($tx->status=='completed') halpha-text-green-400 halpha-bg-green-900/10 halpha-px-2 halpha-py-1 halpha-rounded-full 
                                    @elseif($tx->status=='pending') halpha-text-yellow-300 halpha-bg-yellow-900/10 halpha-px-2 halpha-py-1 halpha-rounded-full 
                                    @else halpha-text-red-400 halpha-bg-red-900/10 halpha-px-2 halpha-py-1 halpha-rounded-full @endif halpha-text-xs halpha-font-semibold halpha-uppercase">
                        {{ strtoupper($tx->status) }}
                    </span>
                  </div>

                  <div class="halpha-flex halpha-items-center halpha-gap-2">
                    <button wire:click="showDetails({{ $tx->id }})" class="halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-1 halpha-rounded halpha-border halpha-border-gray-700">More details</button>

                    <button wire:click.prevent="requestCopyReference('{{ $tx->reference }}')" class="halpha-text-xs halpha-text-gray-300 halpha-ml-2" title="Copy reference">Copy</button>
                  </div>
              </div>
            </li>
        @empty
            <li class="halpha-text-center halpha-text-gray-400 halpha-p-6 halpha-bg-gray-800 halpha-rounded">No transactions found.</li>
        @endforelse
    </ul>

    {{-- Pagination --}}
    <div class="halpha-flex halpha-flex-col sm:halpha-flex-row halpha-justify-between halpha-items-center halpha-text-sm halpha-text-gray-400 halpha-gap-2">
        <div>Showing <span class="halpha-font-medium halpha-text-white">{{ $transactions->count() }}</span> items</div>
        <div class="halpha-w-full sm:halpha-w-auto">{{ $transactions->links() }}</div>
    </div>

    {{-- Details modal (Livewire-driven) --}}
    @if($showModal && $selected)
        <div wire:keydown.escape="closeModal" tabindex="-1" class="halpha-fixed halpha-inset-0 halpha-z-50 halpha-flex halpha-items-center halpha-justify-center">
            <div class="halpha-absolute halpha-inset-0 halpha-bg-black/60" wire:click="closeModal"></div>

            <div class="halpha-bg-gray-900 halpha-rounded-lg halpha-w-[92%] md:halpha-w-[720px] halpha-p-4 halpha-z-50 halpha-shadow-lg" role="dialog" aria-modal="true">
            <div class="halpha-flex halpha-items-start halpha-justify-between halpha-gap-3">
                <div>
                <h2 class="halpha-text-lg halpha-font-semibold halpha-text-white">{{ $selected->label }}</h2>
                <p class="halpha-text-xs halpha-text-gray-400 truncate">{{ $selected->reference }}</p>
                </div>
                <button wire:click="closeModal" class="halpha-text-gray-400">Close</button>
            </div>

            <div class="halpha-grid halpha-grid-cols-2 halpha-gap-4 halpha-mt-4">
                <div>
                <div class="halpha-text-xs halpha-text-gray-400">Amount</div>
                <div class="halpha-text-sm halpha-font-semibold halpha-text-white">{{ number_format($selected->amount, 2) }}</div>
                </div>

                <div>
                <div class="halpha-text-xs halpha-text-gray-400">Status</div>
                <div class="halpha-text-sm halpha-font-semibold">{{ $selected->status }}</div>
                </div>

                <div>
                <div class="halpha-text-xs halpha-text-gray-400">Network</div>
                <div class="halpha-text-sm halpha-font-semibold halpha-text-white">{{ $selected->network }}</div>
                </div>

                <div>
                <div class="halpha-text-xs halpha-text-gray-400">Created</div>
                <div class="halpha-text-sm halpha-font-semibold halpha-text-white">{{ $selected->created_at->format('M d, Y H:i') }}</div>
                </div>
            </div>

            <div class="halpha-mt-4 halpha-text-sm halpha-text-gray-300 halpha-space-y-2">
                <div><strong class="halpha-text-gray-200">Reference:</strong> <span class="truncate block">{{ $selected->reference }}</span></div>
                <div><strong class="halpha-text-gray-200">Notes:</strong> <span>{{ $selected->note ?? '—' }}</span></div>
                <div><strong class="halpha-text-gray-200">Address:</strong> <span>{{ $selected->address ?? '—' }}</span></div>
            </div>

            <div class="halpha-flex halpha-justify-end halpha-gap-2 halpha-mt-4">
                <a href="{{ $selected->explorer_url ?? '#' }}" target="_blank" class="halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">View on explorer</a>
                <button wire:click="closeModal" class="halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Done</button>
            </div>
            </div>
        </div>
    @endif

  </div>
</div>

<script>
    // listen for Livewire browser events to copy to clipboard
    window.addEventListener('copy-ref', e => {
        if (!navigator.clipboard) return;
        navigator.clipboard.writeText(e.detail.ref).then(() => {
        // optional: show small toast; you can replace with your toast system
        const t = document.createElement('div');
        t.textContent = 'Reference copied';
        t.className = 'halpha-fixed halpha-bottom-4 halpha-right-4 halpha-bg-gray-800 halpha-text-white halpha-p-2 halpha-rounded';
        document.body.appendChild(t);
        setTimeout(()=> t.remove(), 1800);
        });
    });
</script>
