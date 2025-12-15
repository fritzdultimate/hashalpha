<div class="halpha-space-y-6 halpha-max-w-xl">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Withdraw Funds
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            Send funds from your account to an external wallet
        </p>
    </div>

    {{-- Warning --}}
    <div class="halpha-card halpha-p-4 halpha-border halpha-border-amber-600/30">
        <p class="halpha-text-xs halpha-text-amber-500">
            Make sure the withdrawal address matches the selected currency and network.
            Sending to a wrong address may result in permanent loss.
        </p>
    </div>

    {{-- Form --}}
    <form wire:submit.prevent="confirm" class="halpha-card halpha-p-4 halpha-space-y-5">

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
                placeholder="Enter amount" />
        </div>

        {{-- Wallet / Currency --}}
        <div>
            <label class="halpha-text-xs halpha-text-gray-400">
                Withdrawal Currency
            </label>

            <select wire:model="walletId" class="halpha-input">
                <option value="">Select currency</option>
                @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}">
                        {{ strtoupper($wallet->currency) }} — {{ $wallet->network ?? 'Mainnet' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Address --}}
        <div>
            <label class="halpha-text-xs halpha-text-gray-400">
                Recipient Address
            </label>

            <input wire:model.defer="address" type="text" class="halpha-input"
                placeholder="Paste destination wallet address" />

            <p class="halpha-text-xs halpha-text-gray-500 halpha-mt-1">
                Address must match the selected currency and network.
            </p>
        </div>

        {{-- CTA --}}
        <button type="submit"
            class="halpha-bg-accent-2 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs halpha-w-full">
            Review Withdrawal
        </button>

    </form>

    {{-- Confirmation --}}
    <x-confirmation-modal event="confirm-withdrawal" wireConfirm="withdraw" title="Confirm Withdrawal"
        message="This transaction cannot be reversed. Proceed only if all details are correct." />


</div>