<div class="halpha-space-y-3">
  @forelse($this->stakes as $stake)
    <div class="halpha-card halpha-p-3 halpha-flex halpha-flex-col">
      <div class="halpha-flex halpha-justify-between halpha-items-start halpha-gap-3">
        <div class="halpha-min-w-0">
          <h4 class="halpha-text-sm halpha-font-semibold halpha-text-white truncate">Stake #{{ $stake->id }} • {{ $stake->plan->name }}</h4>
          <p class="halpha-text-xs halpha-text-gray-400">Principal: {{ number_format($stake->principal_decimal, 8) }}</p>
          <p class="halpha-text-xs halpha-text-gray-400">Accrued: {{ number_format($stake->accrued_rewards_decimal, 8) }}</p>
          <p class="halpha-text-xs halpha-text-gray-400">Withdrawable: {{ number_format($stake->withdrawable_decimal, 8) }}</p>
        </div>

        <div class="halpha-flex halpha-flex-col halpha-justify-center halpha-items-end halpha-gap-2">
          <div class="halpha-text-xs halpha-text-gray-400">Started {{ $stake->start_at->diffForHumans() }}</div>
          <div class="halpha-flex halpha-gap-2">
            <button wire:click="claim({{ $stake->id }})" class="halpha-text-xs halpha-px-2 halpha-py-1 halpha-rounded halpha-border halpha-border-gray-700">Claim</button>

            @if($stake->plan->compound_allowed)
              <button wire:click="compound({{ $stake->id }})" class="halpha-text-xs halpha-px-2 halpha-py-1 halpha-rounded halpha-bg-accent-2 halpha-text-white">Compound</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="halpha-text-center halpha-text-gray-400 halpha-p-4">No active stakes</div>
  @endforelse
</div>
