<div class="halpha-flex halpha-flex-col halpha-gap-5">
    <div class="halpha-relative">
        <button type="button" aria-hidden="true" onclick="document.getElementById('search').focus()"
            class="halpha-absolute halpha-left-3 halpha-top-1/2 halpha--translate-y-1/2 halpha-flex halpha-items-center halpha-justify-center halpha-pointer-events-auto">
            <x-heroicon-s-magnifying-glass class="halpha-w-4 halpha-h-4 halpha-text-gray-400" />
        </button>

        <input
            id="search" 
            type="text" 
            placeholder="Search"
            class="halpha-w-full halpha-pl-10 halpha-pr-3 halpha-py-2 halpha-text-sm halpha-rounded-md halpha-bg-gray-700 halpha-text-white halpha-placeholder-gray-400 halpha-border halpha-border-transparent halpha-shadow-sm focus:!halpha-outline-none halpha-transition focus:!halpha-ring-0 focus:halpha-border-transparent"
            aria-label="Search"
            wire:model.live="search"
        />
    </div>

    <div class="halpha-flex halpha-flex-col halpha-gap-3" x-show="false">
        <div class="halpha-flex halpha-justify-between halpha-items-center halpha-w-full">
            <span class="halpha-text-base halpha-font-semibold halpha-text-gray-300">Search history</span>

            <x-heroicon-o-trash class="halpha-h-4 halpha-w-4 halpha-text-gray-400 hover:halpha-text-red-500 halpha-transition-all halpha-duration-300 halpha-cursor-pointer" />
        </div>

        <ul class="halpha-flex halpha-gap-3 halpha-flex-wrap">
            <li class="halpha-border halpha-border-gray-600 halpha-px-3 halpha-py-0.5 halpha-rounded-md halpha-text-gray-300 halpha-font-semibold halpha-text-sm halpha-uppercase">Pi</li>
            <li class="halpha-border halpha-border-gray-600 halpha-px-3 halpha-py-0.5 halpha-rounded-md halpha-text-gray-300 halpha-font-semibold halpha-text-sm halpha-uppercase">usdt</li>
        </ul>
    </div>
</div>