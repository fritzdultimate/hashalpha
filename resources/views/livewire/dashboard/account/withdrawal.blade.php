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