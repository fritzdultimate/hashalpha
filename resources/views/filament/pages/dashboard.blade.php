<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        @foreach ($this->getHeaderWidgets() as $widget)
            {{ $widget }}
        @endforeach
    </div>

    <div class="mt-8">
    </div>
</x-filament::page>