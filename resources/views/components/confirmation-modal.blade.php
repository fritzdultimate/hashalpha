<div x-data="{show:false}" x-on:{{ $event }}.window="show=true">
    <div x-show="show"
        class="halpha-fixed halpha-inset-0 halpha-bg-black/60 halpha-flex halpha-items-center halpha-justify-center">
        <div class="halpha-card halpha-p-4 halpha-max-w-sm">
            <p class="halpha-text-sm halpha-text-white">Are you sure?</p>
            <div class="halpha-flex halpha-gap-2 halpha-mt-4">
                <button @click="show=false" class="halpha-btn-secondary">Cancel</button>
                <button wire:click="confirm" class="halpha-btn-danger">Confirm</button>
            </div>
        </div>
    </div>
</div>