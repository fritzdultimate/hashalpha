<x-filament-panels::page>
    {{ $this->form }}

    <x-filament::button
        wire:click="send"
        color="success"
        class="mt-4"
    >
        Send Emails
    </x-filament::button>
</x-filament-panels::page>
