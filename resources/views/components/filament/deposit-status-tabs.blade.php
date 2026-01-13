<div class="flex justify-center my-4">
    <div class="inline-flex rounded-lg border border-gray-300 overflow-hidden shadow-sm bg-white">
        @foreach($tabs as $key => $tab)
            <button
                wire:click="setStatusTab('{{ $key }}')"
                class="px-4 py-2 text-sm font-medium flex items-center gap-2
                    {{ $statusTab === $key ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                <span>{{ $tab['label'] }}</span>
                <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-semibold text-white
                    {{ $statusTab === $key ? 'bg-white text-primary' : 'bg-primary text-white' }} rounded-full">
                    {{ $tab['count'] }}
                </span>
            </button>
        @endforeach
    </div>
</div>
