<div wire:ignore.self>
    @if($this->show)
    <div class="halpha-fixed halpha-inset-0 halpha-z-50" aria-modal="true" role="dialog">
        {{-- Backdrop --}}
        <div class="halpha-absolute halpha-inset-0 halpha-bg-black/70" wire:click="$set('show', false)"></div>

        {{-- Modal container --}}
        <div class="halpha-absolute halpha-inset-0 halpha-flex halpha-items-center halpha-justify-center halpha-p-4 md:halpha-p-6">
            <div class="halpha-bg-card-bg halpha-rounded-xl halpha-shadow-lg w-full max-w-md md:max-w-lg lg:max-w-2xl overflow-hidden flex flex-col md:flex-row">
                
                {{-- Left section: plan info --}}
                <div class="halpha-bg-gray-900 halpha-p-6 halpha-flex halpha-flex-col halpha-gap-4 md:halpha-w-1/2">
                    <h2 class="halpha-text-2xl halpha-font-bold halpha-text-white truncate">{{ $this->plan->name }}</h2>
                    <p class="halpha-text-sm halpha-text-gray-400">{{ $this->plan->description ?? 'No description provided.' }}</p>

                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <div>
                            <p class="halpha-text-xs halpha-text-gray-400">APY</p>
                            <p class="halpha-text-lg halpha-font-semibold halpha-text-white">
								{{ rtrim((string)$this->plan->daily_roi,'.') }}%
							</p>
                        </div>
                        <div>
                            <p class="halpha-text-xs halpha-text-gray-400">Min Stake</p>
                            <p class="halpha-text-lg halpha-font-semibold halpha-text-white">{{ number_format($this->plan->min_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="halpha-text-xs halpha-text-gray-400">Compound</p>
                            <p class="halpha-text-lg halpha-font-semibold halpha-text-white">{{ $this->plan->compound_allowed ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>

                    <div class="halpha-mt-4">
                        <p class="halpha-text-xs halpha-text-gray-400">Duration</p>
                        <p class="halpha-text-sm halpha-text-white">{{ $this->plan->duration_days ? $this->plan->duration_days . ' days' : 'Flexible' }}</p>
                    </div>
                </div>

                {{-- Right section: stake input --}}
                <div class="halpha-p-6 halpha-flex halpha-flex-col halpha-gap-4 md:halpha-w-1/2">
                    {{-- Amount input --}}
                    <div class="halpha-flex halpha-flex-col halpha-gap-1">
                        <label class="halpha-text-xs halpha-text-gray-400">Amount</label>
                        <input 
							type="number" 
							step="0.00000001" 
							wire:model.defer="amount" 
							inputmode="decimal"
                        	class="halpha-w-full halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-800 halpha-text-white halpha-outline-none no-spinner" 
						/>
                        @error('amount') <div class="halpha-text-xs halpha-text-red-400 mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- Auto-compound --}}
                    @if($this->plan->compound_allowed)
                    <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-text-xs">
                        <input type="checkbox" wire:model="autoCompound" id="autoCompound" class="halpha-checked:halpha-ring" />
                        <label for="autoCompound" class="halpha-text-gray-300">Auto-compound rewards</label>
                    </div>
                    @endif

                    {{-- Estimated rewards --}}
                    <div class="halpha-bg-gray-800 halpha-p-3 halpha-rounded halpha-text-xs halpha-text-gray-300">
                        <p><strong>Estimated daily reward:</strong>
                        @if($amount)
                            <span>{{ \App\Services\RewardCalculator::rewardForDays(number_format((float)$amount, 8, '.', ''), $this->plan->apy_decimal, 1) }} approx</span>
                        @else
                            <span>Enter amount to estimate</span>
                        @endif
                        </p>
                        <p><strong>Estimated weekly reward:</strong>
                        @if($amount)
                            <span>{{ \App\Services\RewardCalculator::rewardForDays(number_format((float)$amount, 8, '.', ''), $this->plan->apy_decimal, 7) }} approx</span>
                        @else
                            <span>Enter amount to estimate</span>
                        @endif
                        </p>
                    </div>

                    {{-- Buttons --}}
                    <div class="halpha-flex halpha-gap-3 halpha-justify-end halpha-mt-4">
                        <button wire:click="$set('show', false)" class="halpha-text-xs halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">Cancel</button>
                        <button wire:click="stake" class="halpha-text-xs halpha-px-4 halpha-py-2 halpha-rounded halpha-bg-accent-2 halpha-text-white halpha-font-semibold">Confirm Stake</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>
