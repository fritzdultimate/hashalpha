@props([
    'name' => '',
    'active' => false,
])

<button {{ $attributes->merge([
    'class' => 'halpha-w-full'
]) }}>
    <div
        class="halpha-card halpha-p-3 halpha-flex halpha-items-center halpha-justify-between halpha-rounded-xl halpha-border
    {{ $active ? 'halpha-border-accent-2 halpha-bg-accent-2/10' : 'halpha-border-gray-800 halpha-bg-gray-900' }}"
    >
        <div class="halpha-flex halpha-items-center halpha-gap-3">

            <div class="halpha-w-2.5 halpha-h-2.5 halpha-rounded-full {{ $active ? 'halpha-bg-accent-2' : 'halpha-bg-gray-700' }}"></div>

            <span class="halpha-text-sm halpha-font-medium {{ $active ? 'halpha-text-white' : 'halpha-text-gray-400' }}">
                {{ $name }}
            </span>
            
        </div>


        @if($active)
            <span class="halpha-text-xs halpha-text-accent-2 halpha-font-semibold">Achieved</span>
        @else
            <span class="halpha-text-xs halpha-text-gray-500">Locked</span>
        @endif
    </div>
</button>