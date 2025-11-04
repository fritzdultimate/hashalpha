@props(['title', 'value', 'subtitle' => null, 'icon' => null])
<div class="halpha-p-4 halpha-glass-card halpha-rounded-2xl halpha-shadow-sm halpha-border halpha-border-gray-100">
    <div class="halpha-flex halpha-items-start halpha-gap-3">
        @if($icon)
            <div class="halpha-flex-shrink-0 halpha-h-10 halpha-w-10 halpha-flex halpha-items-center halpha-justify-center halpha-rounded-lg halpha-bg-white/60">
                {!! $icon !!}
            </div>
        @endif
        <div class="halpha-flex-1">
            <div class="halpha-text-xs halpha-text-gray-500">{{ $title }}</div>
            <div class="halpha-text-xl halpha-font-semibold halpha-leading-tight">{{ $value }}</div>
            @if($subtitle)
                <div class="halpha-text-sm halpha-text-gray-500 halpha-mt-1">{{ $subtitle }}</div>
            @endif
        </div>
    </div>
</div>
