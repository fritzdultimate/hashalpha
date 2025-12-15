<div class="halpha-card halpha-p-4 halpha-max-w-md">
    <h2 class="halpha-text-sm halpha-text-white">Security</h2>


    <label class="halpha-flex halpha-gap-2 halpha-mt-4">
        <input type="checkbox" wire:model="twoFactor" />
        <span class="halpha-text-xs halpha-text-gray-400">Enable 2FA</span>
    </label>


    <button wire:click="save" class="halpha-btn-primary halpha-mt-4">Save</button>
</div>