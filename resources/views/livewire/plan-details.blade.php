@if($this->show && $this->plan)
  <div class="fixed inset-0 z-50" aria-modal="true" role="dialog">
    <div class="absolute inset-0 halpha-bg-black/60" wire:click="close"></div>

    <div class="halpha-bg-card halpha-rounded-lg halpha-w-[94%] md:halpha-w-[720px] halpha-p-4 halpha-z-50 halpha-mx-auto halpha-mt-12">
      <div class="halpha-flex halpha-justify-between halpha-items-start">
        <div>
          <h2 class="halpha-text-lg halpha-font-semibold halpha-text-white">{{ $this->plan->name }}</h2>
          <p class="halpha-text-xs halpha-text-gray-400 truncate">{{ $this->plan->description }}</p>
        </div>
        <button wire:click="close" class="halpha-text-gray-400">Close</button>
      </div>

      <div class="halpha-grid halpha-grid-cols-2 halpha-gap-4 halpha-mt-4">
        <div>
          <div class="halpha-text-xs halpha-text-gray-400">APY</div>
          <div class="halpha-text-sm halpha-font-semibold halpha-text-white">{{ rtrim(rtrim((string)$this->plan->apy_decimal,'0'),'.') }}%</div>
        </div>
        <div>
          <div class="halpha-text-xs halpha-text-gray-400">Min amount</div>
          <div class="halpha-text-sm halpha-font-semibold halpha-text-white">{{ number_format($this->plan->min_amount_decimal, 2) }}</div>
        </div>

        <div>
          <div class="halpha-text-xs halpha-text-gray-400">Duration</div>
          <div class="halpha-text-sm halpha-font-semibold halpha-text-white">{{ $this->plan->duration_days ? $this->plan->duration_days . ' days' : 'Flexible' }}</div>
        </div>

        <div>
          <div class="halpha-text-xs halpha-text-gray-400">Compound</div>
          <div class="halpha-text-sm halpha-font-semibold halpha-text-white">{{ $this->plan->compound_allowed ? 'Yes' : 'No' }}</div>
        </div>
      </div>

      <div class="halpha-mt-4 halpha-flex halpha-justify-end halpha-gap-2">
        <button wire:click="close" class="halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Close</button>
        <button wire:click="$emit('openStakeModal', {{ $this->plan->id }})" class="halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-accent-2 halpha-text-white">Stake</button>
      </div>
    </div>
  </div>
@endif


<script>
     window.addEventListener('toast', (e) => {
        const msg = e.detail?.message ?? 'Done';
        const t = document.createElement('div');
        t.textContent = msg;
        t.className = 'halpha-fixed halpha-bottom-4 halpha-right-4 halpha-bg-gray-800 halpha-text-white halpha-p-3 halpha-rounded';
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 1800);
  });
</script>
