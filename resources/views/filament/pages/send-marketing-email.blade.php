<x-filament-panels::page>
    <div class="halpha-space-y-6 halpha-max-w-2xl !halpha-flex" style="max-width: 42rem">
        {{ $this->form }}

        <x-filament::button
            wire:click="send"
            color="success"
            class="!halpha-mt-4"
            style="margin-top: 1rem"
        >
            Send Emails
        </x-filament::button>
    </div>
</x-filament-panels::page>
