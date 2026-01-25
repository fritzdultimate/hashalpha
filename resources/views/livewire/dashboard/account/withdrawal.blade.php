<div
    x-data="{showOtpForm: @entangle('showOtpForm')}"
    class="halpha-space-y-6 halpha-max-w-xl"
>

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Withdraw Funds
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            Send funds from your account to an external wallet
        </p>

        <div>
            <a 
                href="{{ route('withdrawal.history') }}"
                class="halpha-text-accent-2 halpha-text-xs halpha-font-semibold hover:underline"
            >
                View Withdrawal History
            </a>
        </div>
    </div>

    {{-- Warning --}}
    <div class="halpha-card halpha-p-4 halpha-border halpha-border-amber-600/30">
        <p class="halpha-text-xs halpha-text-amber-500">
            Make sure the withdrawal address matches the selected currency and network.
            Sending to a wrong address may result in permanent loss.
        </p>
    </div>

    {{-- Withdrawal Disclaimer --}}
    <div class="halpha-card halpha-rounded-lg halpha-bg-card-soft halpha-p-3 halpha-text-[11px] halpha-text-gray-400 halpha-leading-relaxed">
        <p class="halpha-font-medium halpha-text-gray-300 halpha-mb-1">
            Important Withdrawal Information
        </p>

        <ul class="halpha-list-disc halpha-pl-4 halpha-space-y-1">
            <li>
                Ensure the <span class="halpha-text-gray-200">destination address and network</span> are correct before submitting your withdrawal. Funds sent to an incorrect address or network cannot be recovered.
            </li>
            <li>
                Withdrawals are processed on-chain and are <span class="halpha-text-gray-200">irreversible</span> once broadcast to the network.
            </li>
            <li>
                Processing times may vary depending on network congestion and blockchain conditions.
            </li>
            <li>
                Withdrawal requests may be subject to security checks, compliance reviews, or temporary delays to protect your account.
            </li>
            <li>
                You are fully responsible for verifying all withdrawal details prior to confirmation.
            </li>
        </ul>
    </div>

    @if ($withdrawalPlaced)
        <div class="halpha-card halpha-p-6 halpha-rounded-xl halpha-text-center halpha-space-y-4">

            {{-- Success Icon --}}
            <div class="halpha-flex halpha-justify-center">
                <div class="halpha-bg-green-500/10 halpha-rounded-full halpha-p-4">
                    <x-ri-checkbox-circle-fill class="halpha-w-10 halpha-h-10 halpha-text-green-500" />
                </div>
            </div>

            {{-- Title --}}
            <h2 class="halpha-text-lg halpha-font-semibold halpha-text-white">
                Withdrawal Submitted Successfully
            </h2>

            {{-- Message --}}
            <p class="halpha-text-sm halpha-text-gray-400 halpha-leading-relaxed">
                Your withdrawal request has been received and is currently being processed.
                For security reasons, withdrawals may undergo additional verification before
                being broadcast to the blockchain.
            </p>

            {{-- Info Box --}}
            <div class="halpha-bg-card-soft halpha-border halpha-border-white/5 halpha-rounded-lg halpha-p-3 halpha-text-left halpha-text-xs halpha-text-gray-400 halpha-space-y-1">
                <div>
                    <span class="halpha-text-gray-300">Status:</span>
                    <span class="halpha-text-amber-400">{{ $withdrawal?->status ?? 'pending' }}</span>
                </div>
                <div>
                    <span class="halpha-text-gray-300">Amount:</span>
                    <span>${{ number_format($withdrawal?->amount ?? 0, 8) }}</span>
                </div>
                <div>
                    <span class="halpha-text-gray-300">Destination:</span>
                    <span class="halpha-truncate">{{ $withdrawal?->address ?? '--' }}</span>
                </div>
                <div>
                    <span class="halpha-text-gray-300">Estimated Time:</span>
                    <span>Depends on network conditions</span>
                </div>
            </div>

            {{-- CTA --}}
            <div class="halpha-flex halpha-flex-col halpha-gap-2">
                <a href="{{ route('withdrawal.history') }}"
                class="halpha-bg-accent-2 halpha-text-white halpha-py-2 halpha-rounded halpha-text-xs">
                    View Withdrawal History
                </a>

                <button wire:click="makeAnotherWithdrawal"
                    class="halpha-text-xs halpha-text-gray-400 hover:halpha-text-gray-300">
                    Make another withdrawal
                </button>
            </div>
        </div>
    @else
        {{-- Form --}}
        <form x-show="!showOtpForm" wire:submit.prevent="confirm" class="halpha-card halpha-p-4 halpha-space-y-5">

            {{-- Amount --}}
            <div>
                <label class="halpha-text-xs halpha-text-gray-400">Amount</label>
                <input 
                    wire:model.defer="amount" 
                    type="text"
                    x-on:input="
                        $el.value = $el.value.replace(/[^0-9.]/g, '')
                    "
                    step="0.01" 
                    class="halpha-input"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    placeholder="Enter amount" 
                />
                @error('amount')
                    <div class="halpha-text-red-500 halpha-text-xs halpha-mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Wallet / Currency --}}
            <div>
                <label class="halpha-text-xs halpha-text-gray-400">
                    Withdrawal Currency
                </label>

                <select wire:model.live="currencyId" class="halpha-input">
                    <option value="">Select currency</option>
                    @foreach($currencies as $currency)
                        <option value="{{ $currency->id }}">
                            {{ strtoupper($currency->code) }} — {{ $currency->name }}
                        </option>
                    @endforeach
                </select>

                @error('currencyId')
                    <div class="halpha-text-red-500 halpha-text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            @if($currencyId)
                <div>
                    <label class="halpha-text-xs halpha-text-gray-400">
                        Network
                    </label>

                    <select wire:model="networkId" class="halpha-input">
                        <option value="">Select network</option>
                        @foreach($networks as $network)
                            <option value="{{ $network->id }}">
                                {{ strtoupper($network->name) }}
                                @if($network->fee > 0)
                                    — Fee: {{ $network->fee }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @error('networkId')
                        <div class="halpha-text-red-500 halpha-text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            {{-- Wallet / Currency --}}


            <div>
                <label class="halpha-text-xs halpha-text-gray-400">
                    Withdrawal Asset
                </label>

                <select wire:model="asset" class="halpha-input">
                    <option value="">Select Asset</option>
                    
                    <option value="balance">
                        Main Balance - (${{ number_format(auth()->user()->balance, 2) }})
                    </option>
                    <option value="referral_rewards">
                        Referral Bonus - (${{ number_format($totalAvailable, 2) }})
                    </option>
                    
                </select>
                @error('walletId')
                    <div class="halpha-text-red-500 halpha-text-xs halpha-mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Address --}}
            <div>
                <label class="halpha-text-xs halpha-text-gray-400">
                    Recipient Address
                </label>

                <input wire:model.defer="address" type="text" class="halpha-input"
                    placeholder="Paste destination wallet address" />
                @error('address')
                    <div class="halpha-text-red-500 halpha-text-xs halpha-mt-1">{{ $message }}</div>
                @enderror

                <p class="halpha-text-xs halpha-text-gray-500 halpha-mt-1">
                    Address must match the selected currency and network.
                </p>
            </div>

            {{-- CTA --}}
            <button 
                type="submit"
                @disabled($loading)
                class="halpha-bg-accent-2 disabled:halpha-opacity-50 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs halpha-w-full"
            >
                <span wire:loading.remove>Review Withdrawal</span>
                <div wire:loading wire:target="withdraw" class="halpha-flex halpha-items-center halpha-gap-2">
                    <span>Preparing Withdrawal...</span>    
                </div>
                <x-ri-loader-4-fill wire:loading wire:target="confirm" class="halpha-w-4 halpha-h-4 halpha-animate-spin" />
                
            </button>

        </form>

        <div x-cloak x-show="showOtpForm">
            <div class="halpha-space-y-3 halpha-flex halpha-justify-center halpha-items-center halpha-flex-col halpha-w-full">
                <div class="halpha-py-3">
                    <x-emoji-inbox-tray class="halpha-text-sky-500 halpha-w-16 halpha-h-16" />
                </div>
                <div class="halpha-text-center halpha-space-y-0.5">
                    <h2 class="halpha-text-base halpha-text-gray-100 halpha-font-medium">Enter verification code</h2>
                    <div class="halpha-text-sm halpha-text-gray-300">We've sent a code to your phone/email</div>
                </div>

                <div class="halpha-w-full halpha-px-10 md:halpha-px-40 halpha-py-5">
                    <livewire:otp-input wire:model="otp" />

                    @error('otp')
                        <div class="halpha-text-red-500 halpha-text-xs halpha-mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="halpha-flex halpha-flex-col halpha-w-full halpha-items-center halpha-gap-2">
                    <button wire:click="proceedWithdrawal" class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-bg-accent-3 halpha-text-white halpha-w-full">
                        <span wire:loading.remove wire:target="proceedWithdrawal">Verify</span>
                        <x-ri-loader-4-fill wire:loading wire:target="proceedWithdrawal" class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
                    </button>

                    <button wire:click="cancelProcess"
                        class="halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-600 halpha-text-gray-300 halpha-w-full">Cancel</button>
                </div>
            </div>

        </div>
    @endif
    <x-dashboard.disclaimer />

    {{-- Confirmation --}}
    <x-confirmation-modal event="confirm-withdrawal" wireConfirm="withdraw" title="Confirm Withdrawal"
        message="This transaction cannot be reversed. Proceed only if all details are correct." />


</div>