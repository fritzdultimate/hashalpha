<form wire:submit.prevent="confirm" class="halpha-space-y-4 halpha-max-w-md">
    <input wire:model="amount" type="number" class="halpha-input" placeholder="Amount" />


    <select wire:model="walletId" class="halpha-input">
        @foreach($wallets as $wallet)
            <option value="{{ $wallet->id }}">{{ $wallet->currency }}</option>
        @endforeach
    </select>


    <button class="halpha-btn-primary">Withdraw</button>


    <x-confirmation-modal event="confirm-withdrawal" wire:confirm="withdraw" />
</form>