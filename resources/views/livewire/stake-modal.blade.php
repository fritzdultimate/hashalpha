@if($this->show)
  <div class="fixed inset-0 z-50" aria-modal="true" role="dialog">
    <div class="absolute inset-0 halpha-bg-black/60" wire:click="$set('show', false)"></div>

    <!-- Mobile full-sheet -->
    <div class="absolute left-0 right-0 bottom-0 max-h-[92vh] overflow-auto bg-card rounded-t-2xl p-4"
         style="backdrop-filter: blur(6px);">
      <div class="halpha-flex halpha-justify-between halpha-items-center halpha-gap-2">
        <div>
          <h3 class="halpha-text-lg halpha-font-semibold halpha-text-white">{{ $this->plan->name }}</h3>
          <p class="halpha-text-xs halpha-text-gray-400">APY: {{ rtrim(rtrim((string)$this->plan->apy_decimal,'0'),'.') }}% • Min {{ number_format($this->plan->min_amount_decimal,2) }}</p>
        </div>
        <button wire:click="$set('show', false)" class="halpha-text-sm halpha-text-gray-400">Close</button>
      </div>

      <div class="halpha-mt-4 halpha-space-y-3">
        <div>
          <label class="halpha-text-xs halpha-text-gray-400">Amount</label>
          <input type="number" step="0.00000001" wire:model.defer="amount" inputmode="decimal"
                 class="halpha-w-full halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-800 halpha-text-white halpha-outline-none" />
          @error('amount') <div class="halpha-text-xs halpha-text-red-400 mt-1">{{ $message }}</div> @enderror
        </div>

        @if($this->plan->compound_allowed)
          <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-text-xs">
            <input type="checkbox" wire:model="autoCompound" id="autoCompound" class="halpha-checked:halpha-ring" />
            <label for="autoCompound" class="halpha-text-gray-300">Auto-compound rewards (if allowed)</label>
          </div>
        @endif

        <div class="halpha-mt-2 halpha-text-xs halpha-text-gray-400">
          <strong>Estimated daily reward:</strong>
          @if($amount)
            <?php
              // compute estimate server-side quickly - small extra
            ?>
            <span>
              {{ \App\Services\RewardCalculator::rewardForDays(number_format((float)$amount, 8, '.', ''), $this->plan->apy_decimal, 1) }} (approx)
            </span>
          @else
            <span>Enter amount to estimate</span>
          @endif
        </div>

        <div class="halpha-flex halpha-justify-end halpha-gap-2 halpha-mt-3">
          <button wire:click="$set('show', false)" class="halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Cancel</button>
          <button wire:click="stake" class="halpha-text-xs halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-accent-2 halpha-text-white halpha-font-semibold">Confirm Stake</button>
        </div>
      </div>
    </div>
  </div>
@endif
