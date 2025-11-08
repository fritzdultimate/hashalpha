@props([
    'title' => 'Metric',
    'value' => '',
    'chartId' => null,
    'delta' => '70.5%'
])

@php
    $chartId = $chartId ?? 'chart-' . substr(md5((string) now() . rand()), 0, 6);
@endphp

<div {{ $attributes->merge(['class' => 'halpha-flex halpha-flex-col halpha-gap-2 halpha-bg-card-bg halpha-rounded halpha-border halpha-border-white/5']) }}>
    <div class="halpha-flex halpha-flex-col halpha-gap-2 halpha-p-4">
        <h6 class="halpha-text-muted">{{ $title }}</h6>

        <div class="halpha-flex halpha-items-center halpha-gap-3">
            <h4 class="halpha-text-xl halpha-font-semibold halpha-text-accent halpha-font-sans">
                {{ $value }}
            </h4>

            <div
                class="halpha-flex halpha-gap-2 halpha-items-center halpha-border halpha-rounded halpha-px-2 halpha-text-ellipsis halpha-text-sm halpha-text-accent-2 halpha-border-accent-3 halpha-py-0.5 halpha-bg-accent-2-darker">
                <x-heroicon-c-arrow-trending-up class="halpha-w-4 halpha-h-4" />
                <span>{{ $delta }}</span>
            </div>
        </div>
    </div>

    <div class="halpha-pb-4">
        @if (trim($slot) !== '')
            {{ $slot }}
        @elseif (isset($chart))
            {{ $chart }}
        @else
            <div id="{{ $chartId }}"></div>
        @endif
    </div>
</div>
