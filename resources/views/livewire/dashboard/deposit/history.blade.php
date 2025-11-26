

<div class="halpha-w-full halpha-min-h-screen halpha-flex halpha-justify-center halpha-bg-transparent halpha-py-6">
  <div class="halpha-w-full halpha-max-w-[900px] halpha-shadow halpha-shadow-white/10 halpha-bg-gray-900 halpha-rounded-xl halpha-p-4 halpha-space-y-4">
    <header class="halpha-flex halpha-items-center halpha-justify-between">
      <h1 class="halpha-text-lg halpha-font-semibold halpha-text-white">Transaction history</h1>
      <div class="halpha-text-sm halpha-text-gray-400">Total: <span class="halpha-font-medium halpha-text-white">{{ number_format(array_sum(array_column($transactions->toArray(), 'amount')), 2) }}</span></div>
    </header>

    {{-- Search & filters --}}
    <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-flex-wrap">
      <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-w-full md:halpha-w-auto">
        <input
          x-data
          x-ref="search"
          placeholder="Search by currency, reference or label"
          class="halpha-w-full md:halpha-w-[340px] halpha-rounded halpha-px-3 halpha-py-2 halpha-bg-gray-800 halpha-text-sm halpha-text-white halpha-outline-none"
          @input.debounce.300="$dispatch('filter-transactions', { q: $event.target.value })"
        />
        <button
          @click="$refs.search.value=''; $dispatch('filter-transactions', { q: '' })"
          class="halpha-ml-2 halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700"
        >Clear</button>
      </div>

      <div class="halpha-ml-auto halpha-flex halpha-items-center halpha-gap-2">
        <select class="halpha-bg-gray-800 halpha-text-sm halpha-px-3 halpha-py-2 halpha-rounded" @change="$dispatch('filter-transactions', { status: $event.target.value })">
          <option value="">All statuses</option>
          <option value="completed">Completed</option>
          <option value="pending">Pending</option>
          <option value="failed">Failed</option>
        </select>
      </div>
    </div>

    {{-- List header (desktop) --}}
    <div class="halpha-hidden md:halpha-grid halpha-grid-cols-6 halpha-gap-4 halpha-items-center halpha-text-xs halpha-text-gray-400 halpha-py-2 halpha-border-b halpha-border-gray-800">
      <div>Transaction</div>
      <div>Amount</div>
      <div>Network / Currency</div>
      <div>Date</div>
      <div>Status</div>
      <div class="halpha-text-right">Action</div>
    </div>

    {{-- Items --}}
    <ul x-data="historyList({ transactions: @json($transactions) })" class="halpha-space-y-3">
      <template x-for="tx in filtered" :key="tx.id">
        <li class="halpha-flex halpha-items-center halpha-gap-3 halpha-bg-gray-800 halpha-p-3 halpha-rounded-md halpha-transition halpha-duration-150 halpha-ease-in-out hover:halpha-bg-gray-700">

          {{-- Left: icon and basic --}}
          <div class="halpha-flex halpha-items-center halpha-gap-3 halpha-w-[48%] md:halpha-w-[32%]">
            <div class="halpha-w-10 halpha-h-10 halpha-rounded-full halpha-flex halpha-items-center halpha-justify-center" :class="tx.bg">
              <span :class="tx.icon" class="icon"></span>
            </div>
            <div>
              <div class="halpha-text-sm halpha-font-semibold halpha-text-white" x-text="tx.label"></div>
              <div class="halpha-text-xs halpha-text-gray-400" x-text="tx.reference"></div>
            </div>
          </div>

          {{-- Amount --}}
          <div class="halpha-w-[24%] halpha-text-sm halpha-font-semibold halpha-text-white" x-text="formatAmount(tx.amount)"></div>

          {{-- Network / Currency --}}
          <div class="halpha-hidden md:halpha-block halpha-w-[18%] halpha-text-xs halpha-text-gray-300" x-text="tx.network + ' • ' + tx.currency"></div>

          {{-- Date --}}
          <div class="halpha-text-xs halpha-text-gray-400 halpha-w-[14%] md:halpha-w-[12%]" x-text="formatDate(tx.created_at)"></div>

          {{-- Status & action --}}
          <div class="halpha-flex halpha-items-center halpha-justify-between halpha-w-full md:halpha-w-auto">
            <div>
              <span x-bind:class="{
                'halpha-text-green-400 halpha-bg-green-900/10 halpha-px-2 halpha-py-1 halpha-rounded-full': tx.status=='completed',
                'halpha-text-yellow-300 halpha-bg-yellow-900/10 halpha-px-2 halpha-py-1 halpha-rounded-full': tx.status=='pending',
                'halpha-text-red-400 halpha-bg-red-900/10 halpha-px-2 halpha-py-1 halpha-rounded-full': tx.status=='failed'
              }" x-text="tx.status.toUpperCase()"></span>
            </div>

            <div class="halpha-ml-3 halpha-flex halpha-items-center halpha-gap-2">
              <button
                @click="openDetails(tx)"
                class="halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-1 halpha-rounded halpha-border halpha-border-gray-700"
              >More details</button>

              <div class="halpha-hidden md:halpha-block">
                <button
                  x-on:click.prevent="copyReference(tx.reference)"
                  class="halpha-text-xs halpha-text-gray-300 halpha-ml-2"
                  title="Copy reference"
                >Copy</button>
              </div>
            </div>
          </div>
        </li>
      </template>

      {{-- Empty state --}}
      <li x-show="filtered.length === 0" class="halpha-text-center halpha-text-gray-400 halpha-p-6 halpha-bg-gray-800 halpha-rounded">No transactions found.</li>
    </ul>

    {{-- Pagination placeholder (server side) --}}
    <div class="halpha-flex halpha-justify-between halpha-items-center halpha-text-sm halpha-text-gray-400">
      <div>Showing <span class="halpha-font-medium halpha-text-white" x-text="filtered.length"></span> items</div>
      <div>
        {{-- If using Laravel paginator, you can place: $transactions->links() --}}
        @if(method_exists($transactions, 'links'))
          {{ $transactions->links() }}
        @endif
      </div>
    </div>

    {{-- Details modal (Alpine) --}}
    <div x-show="showModal" x-cloak x-transition class="halpha-fixed halpha-inset-0 halpha-z-50 halpha-flex halpha-items-center halpha-justify-center">
      <div class="halpha-absolute halpha-inset-0 halpha-bg-black/60" @click="closeModal()"></div>

      <div class="halpha-bg-gray-900 halpha-rounded-lg halpha-w-[92%] md:halpha-w-[720px] halpha-p-4 halpha-z-50 halpha-shadow-lg">
        <div class="halpha-flex halpha-items-start halpha-justify-between halpha-gap-3">
          <div>
            <h2 class="halpha-text-lg halpha-font-semibold halpha-text-white" x-text="selected.label"></h2>
            <p class="halpha-text-xs halpha-text-gray-400" x-text="selected.reference"></p>
          </div>
          <button @click="closeModal()" class="halpha-text-gray-400">Close</button>
        </div>

        <div class="halpha-grid halpha-grid-cols-2 halpha-gap-4 halpha-mt-4">
          <div>
            <div class="halpha-text-xs halpha-text-gray-400">Amount</div>
            <div class="halpha-text-sm halpha-font-semibold halpha-text-white" x-text="formatAmount(selected.amount)"></div>
          </div>

          <div>
            <div class="halpha-text-xs halpha-text-gray-400">Status</div>
            <div class="halpha-text-sm halpha-font-semibold" x-text="selected.status"></div>
          </div>

          <div>
            <div class="halpha-text-xs halpha-text-gray-400">Network</div>
            <div class="halpha-text-sm halpha-font-semibold halpha-text-white" x-text="selected.network"></div>
          </div>

          <div>
            <div class="halpha-text-xs halpha-text-gray-400">Created</div>
            <div class="halpha-text-sm halpha-font-semibold halpha-text-white" x-text="formatDate(selected.created_at)"></div>
          </div>
        </div>

        <div class="halpha-mt-4 halpha-text-sm halpha-text-gray-300 halpha-space-y-2">
          <div><strong class="halpha-text-gray-200">Reference:</strong> <span x-text="selected.reference"></span></div>
          <div><strong class="halpha-text-gray-200">Notes:</strong> <span x-text="selected.note ?? '—'"></span></div>
          <div><strong class="halpha-text-gray-200">Address:</strong> <span x-text="selected.address ?? '—'"></span></div>
        </div>

        <div class="halpha-flex halpha-justify-end halpha-gap-2 halpha-mt-4">
          <a href="#" class="halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">View on explorer</a>
          <button @click="closeModal()" class="halpha-text-xs halpha-font-medium halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Done</button>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  function historyList({ transactions }){
    return {
      all: transactions || [],
      filtered: transactions || [],
      query: '',
      showModal: false,
      selected: {},

      init(){
        window.addEventListener('filter-transactions', e => {
          const q = (e.detail?.q || '').toLowerCase();
          const status = (e.detail?.status || '').toLowerCase();

          this.filtered = this.all.filter(tx => {
            const matchQ = q === '' || [tx.currency, tx.label, tx.reference, tx.network].join(' ').toLowerCase().includes(q);
            const matchStatus = status === '' || tx.status.toLowerCase() === status;
            return matchQ && matchStatus;
          });
        });
      },

      formatAmount(v){
        return (Number(v) >= 0 ? '+ ' : '- ') + Number(v).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
      },

      formatDate(d){
        const dt = new Date(d);
        return dt.toLocaleString();
      },

      openDetails(tx){
        this.selected = tx;
        this.showModal = true;
        // optionally emit Livewire event to fetch latest details
        if (window.Livewire) window.Livewire.emit('fetchTransactionDetails', tx.id);
      },

      closeModal(){ this.showModal = false; this.selected = {}; },

      copyReference(ref){ navigator.clipboard.writeText(ref).then(()=>{ /* toast if you want */ }) }
    }
  }
</script>
