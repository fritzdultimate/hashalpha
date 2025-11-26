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
        <button wire:click="createInvoice(true)" class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-bg-accent-3 halpha-text-white halpha-w-full">
            <span wire:loading.remove wire:target="createInvoice">Verify</span>
            <x-ri-loader-4-fill wire:loading wire:target="createInvoice" class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
        </button>

        <button @click="closePanel()"
            class="halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-600 halpha-text-gray-300 halpha-w-full">Cancel</button>
    </div>
</div>
