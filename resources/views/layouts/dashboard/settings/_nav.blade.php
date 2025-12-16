{{-- Settings Navigation --}}

@php
    $navs = [
        [
            'label' => 'Settings',
            'route' => 'account.settings'
        ],
        [
            'label' => 'Account',
            'route' => 'account.details'
        ],
        [
            'label' => 'Support',
            'route' => 'account.support'
        ]
    ]
@endphp
<div class="halpha-flex halpha-gap-2 halpha-overflow-x-auto halpha-pb-2">

    @foreach ($navs as $nav)
        <a href="{{ route($nav['route']) }}" class="halpha-px-3 halpha-py-1 halpha-rounded-full halpha-text-xs
                {{ request()->routeIs($nav['route'])
            ? 'halpha-bg-accent-2 halpha-text-white halpha-cursor-not-allowed'
            : 'halpha-bg-gray-800 halpha-text-gray-400' }}">
                {{ $nav['label'] }}
        </a>
    @endforeach

</div>