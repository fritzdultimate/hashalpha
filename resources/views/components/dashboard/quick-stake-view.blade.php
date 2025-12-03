<div x-data="{ open: @entangle('quickView') }" x-on:keydown.escape.window="open = false" x-cloak>
    <!-- Backdrop -->
    <div x-show="open" x-transition.opacity
        class="halpha-fixed halpha-inset-0 halpha-bg-black halpha-bg-opacity-50 halpha-backdrop-blur-sm"
        @click="open = false" aria-hidden="true"></div>

    <!-- Modal panel -->
    <div 
        x-show="open" 
        x-transition.origin.top.duration.300ms
        class="halpha-fixed halpha-inset-0 halpha-left-1/2 halpha-transform halpha--translate-x-1/2 halpha-w-full halpha-max-w-md md:halpha-max-w-2xl halpha-rounded-xl halpha-bg-gray-900 halpha-border halpha-border-gray-800 halpha-shadow-lg halpha-z-50"
        style="display: none;" 
        role="dialog" 
        aria-modal="true" 
        aria-label="Quick view - latest stakes"
    >
        <div
            class="halpha-flex halpha-items-center halpha-justify-between halpha-p-4 halpha-border-b halpha-border-gray-800">
            <div>
                <div class="halpha-text-sm halpha-text-gray-400">Quick view</div>
                <div class="halpha-text-lg halpha-font-semibold halpha-text-white">Your latest stakes</div>
            </div>

            <div class="halpha-flex halpha-items-center halpha-gap-2">

                <button @click="open = false"
                    class="halpha-text-sm halpha-px-2 halpha-py-1 halpha-rounded halpha-text-gray-300"
                    aria-label="Close">✕</button>
            </div>
        </div>
        <div class="halpha-p-4 halpha-mt-4">
            <livewire:dashboard.stakes-list :fixed-page="true" :per-page="5" quickView="{{ $quickView }}"  />
        </div>
        <div class="halpha-p-4 halpha-border-t halpha-border-gray-800 halpha-text-right">
            <button @click="open = false"
                class="halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-800 halpha-text-xs halpha-text-gray-300">Close</button>
            <a href="{{ route('stakes.index') ?? '#' }}"
                class="halpha-ml-2 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-accent-2 halpha-text-xs halpha-text-white">View
                all</a>
        </div>
    </div>
</div>