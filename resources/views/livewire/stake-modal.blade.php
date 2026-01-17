<div wire:ignore.self>
    @if($this->show)
    <div x-data="{ open: @entangle('show') }" x-show="open" class="halpha-fixed halpha-inset-0 halpha-z-50" aria-modal="true" role="dialog">
        {{-- Backdrop --}}
        <div class="halpha-absolute halpha-inset-0 halpha-bg-black/70" wire:click="$set('show', false)"></div>

        {{-- Modal container --}}
        <div class="halpha-absolute halpha-inset-0 halpha-flex halpha-items-center halpha-justify-center halpha-p-4 md:halpha-p-6">
            <div class="halpha-bg-card-bg halpha-rounded-xl halpha-shadow-lg halpha-w-full halpha-max-w-md md:halpha-max-w-lg lg:halpha-max-w-2xl halpha-overflow-hidden halpha-flex halpha-flex-col md:halpha-flex-row halpha-border halpha-border-gray-800">
                
                {{-- Left section: plan info --}}
                <div class="halpha-bg-gray-900 halpha-p-6 halpha-flex halpha-flex-col halpha-gap-4 md:halpha-w-1/2">
                    <h2 class="halpha-text-2xl halpha-font-bold halpha-text-white truncate">{{ $this->plan->name }}</h2>
                    <p class="halpha-text-sm halpha-text-gray-400">{{ $this->plan->description ?? 'No description provided.' }}</p>

                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <div>
                            <p class="halpha-text-xs halpha-text-gray-400">ROI</p>
                            <p class="halpha-text-lg halpha-font-semibold halpha-text-white">
								{{ rtrim((string)$this->plan->daily_roi,'.') }}%
							</p>
                        </div>
                        <div>
                            <p class="halpha-text-xs halpha-text-gray-400">Min Stake</p>
                            <p class="halpha-text-lg halpha-font-semibold halpha-text-white">${{ number_format($this->plan->min_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="halpha-text-xs halpha-text-gray-400">Compound</p>
                            <p class="halpha-text-lg halpha-font-semibold halpha-text-white">{{ $this->plan->compound_allowed ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>

                    <div class="halpha-mt-4">
                        <p class="halpha-text-xs halpha-text-gray-400">Duration</p>
                        <p class="halpha-text-sm halpha-text-white">{{ $this->plan->duration ? $this->plan->duration . ' days' : 'Flexible' }}</p>
                    </div>
                </div>

                {{-- Available Bonus --}}
                <div class="halpha-bg-emerald-500/10 halpha-border halpha-border-emerald-500/30 halpha-rounded halpha-p-3 halpha-flex halpha-flex-col halpha-justify-center halpha-items-center">
                    <p class="halpha-text-xs halpha-text-emerald-400">
                        Available Bonus
                    </p>
                    <p class="halpha-text-lg halpha-font-bold halpha-text-emerald-300">
                        ${{ number_format($this->availableBonus, 2) }}
                    </p>
                    <p class="halpha-text-[11px] halpha-text-emerald-400 mt-1">
                        Your staking amount will be deducted from your available bonus first. Any remaining amount will be deducted from your main balance.
                    </p>
                </div>

                {{-- Right section: stake input --}}
                <div class="halpha-p-6 halpha-flex halpha-flex-col halpha-gap-4 md:halpha-w-1/2">
                    {{-- Amount input --}}
                    <div class="halpha-flex halpha-flex-col halpha-gap-1">
                        <label class="halpha-text-xs halpha-text-gray-400">Amount</label>
                        <div class="halpha-relative">
                            <span class="halpha-absolute halpha-left-3 halpha-top-1/2 -halpha-translate-y-1/2 halpha-text-gray-400">$</span>
                            <input 
                                type="number" 
                                step="0.00000001" 
                                wire:model.live.defer="amount" 
                                inputmode="decimal"
                                class="halpha-w-full halpha-pl-7 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-800 halpha-text-white halpha-outline-none no-spinner focus:halpha-ring-gray-600 focus:halpha-border-gray-600" 
                            />
                        </div>
                        @error('amount') <div class="halpha-text-xs halpha-text-red-400 mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- Estimated rewards --}}
                    <div class="halpha-bg-gray-800 halpha-p-3 halpha-rounded halpha-text-xs halpha-text-gray-300">
                        @php
                            $amountNumeric = is_numeric($amount) ? (float)$amount : 0;
                        @endphp
                        <p>
                            <strong>Estimated daily reward:</strong>
                            <span>
                                ${{ number_format($amountNumeric * 0.01 * $this->plan->daily_roi) }}
                            </span>
                        </p>
                        <p>
                            <strong>Estimated total reward:</strong>
                            <span>
                                ${{ number_format($amountNumeric * 0.01 * $this->plan->daily_roi * $this->plan->duration) }}
                            </span>
                        </p>
                    </div>

                    {{-- Buttons --}}
                    <div class="halpha-flex halpha-gap-3 halpha-justify-end halpha-mt-4">
                        <button wire:click="$set('show', false)" class="halpha-text-xs halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-700">
                            Cancel
                        </button>
                        <button 
                            wire:click="stake" 
                            class="halpha-text-xs halpha-px-4 halpha-py-2 halpha-rounded halpha-bg-accent-2 halpha-text-white halpha-font-semibold halpha-min-w-32 halpha-max-w-32"
                        >
                            
                            <span wire:loading.remove wire:target="stake">Confirm Stake</span>
                            <x-ri-loader-4-fill wire:loading wire:target="stake" class="halpha-w-4 halpha-h-4 halpha-animate-spin" />
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>
