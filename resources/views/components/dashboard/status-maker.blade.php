@props([
    'label' => null,
    'flat' => false,
    'className' => 'success'
])
@php
    switch($className) {
        case 'fee': 
            $color = 'halpha-bg-yellow-500';
            break;

        case 'credit':
        case 'active': 
            $color = 'halpha-bg-green-500';
            break;
            
        case 'debit': 
            $color = 'halpha-bg-red-500';
            break;
            
        case 'hold': 
            $color = 'halpha-bg-orange-500';
            break;
            
        case 'release': 
            $color = 'halpha-bg-blue-500';
            break;

        case 'pending': 
            $color = 'halpha-bg-yellow-500';
            break;

        case 'confirmed': 
            $color = 'halpha-bg-green-500';
            break;

        case 'failed': 
            $color = 'halpha-bg-red-500';
            break; 

        case 'cancelled': 
            $color = 'halpha-bg-gray-500';
            break; 

        case 'partially_paid': 
            $color = 'halpha-bg-blue-500';
            break;

        default:
            $color = 'bg-gray-500';
            break;

    }
@endphp

<span class="halpha-flex halpha-items-center halpha-justify-start halpha-gap-2">
    @if ($flat)
        <span class="halpha-h-1 halpha-w-4 {{ $color }}"></span>
    @else
        <span class="{{ $color }} halpha-h-2 halpha-w-2 halpha-rounded-full"></span>
    @endif
    {{ $label }}
</span>