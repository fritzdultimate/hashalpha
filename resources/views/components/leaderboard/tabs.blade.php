{{-- Tabs --}}
<div class="halpha-flex halpha-gap-2">
    @foreach($categories as $ch)
        <button wire:click="setTab('{{ $ch->id }}')"
            class="halpha-px-3 halpha-py-1 halpha-rounded halpha-text-xs
                    {{ $activeTab == $ch->id ? 'halpha-bg-accent-2 halpha-text-black' : 'halpha-bg-gray-800 halpha-text-gray-400' }}">
            {{ $ch->challenge->name }}
        </button>
    @endforeach
</div>