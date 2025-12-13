@props([
    'label' => '',
    'value' => '0',
    'suffix' => '',
    'prefix' => '',
    'highlight' => false,
])

               
    
<div class="halpha-card halpha-p-4 halpha-rounded-xl halpha-bg-gray-900 halpha-border halpha-border-accent-3">
    <div class="halpha-text-xs halpha-text-gray-400">
        {{ $label }}
    </div>
    <div class="halpha-mt-1 halpha-text-lg halpha-font-bold {{ $highlight ? 'halpha-text-accent-2' : 'halpha-text-white' }}">
        {{ $prefix }}{{ $value }}{{ $suffix }}
    </div>
</div>