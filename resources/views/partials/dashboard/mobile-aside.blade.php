<div x-show="mobileSidebarOpen" x-cloak class="halpha-fixed halpha-inset-0 halpha-z-40 lg:halpha-hidden"
    aria-hidden="false">
    <div @click="closeMobileSidebar" x-transition:enter="halpha-transition halpha-ease-out halpha-duration-200"
        x-transition:enter-start="halpha-opacity-0" x-transition:enter-end="halpha-opacity-60"
        x-transition:leave="halpha-transition halpha-ease-in halpha-duration-150"
        x-transition:leave-start="halpha-opacity-60" x-transition:leave-end="halpha-opacity-0"
        class="halpha-absolute halpha-inset-0 halpha-bg-[var(--halpha-backdrop)]">
    </div>
    <aside 
        x-transition:enter="halpha-transition halpha-ease-out halpha-duration-300 halpha-transform"
        x-transition:enter-start="halpha--translate-x-full" 
        x-transition:enter-end="halpha-translate-x-0"
        x-transition:leave="halpha-transition halpha-ease-in halpha-duration-250 halpha-transform"
        x-transition:leave-start="halpha-translate-x-0"
        x-transition:leave-end="halpha--translate-x-full"
        class="halpha-relative halpha-w-72 halpha-h-screen halpha-overflow-y-auto halpha-bg-[#1e1e1e] halpha-text-[var(--halpha-sidebar-text)] halpha-border-r halpha-border-r-[#343434]"
        style="-webkit-overflow-scrolling: touch;">
        <div class="halpha-p-4">

            <div class="halpha-flex halpha-items-center halpha-justify-between">
                <div class="halpha-flex halpha-items-center halpha-gap-3">
                    <img src="{{ asset('img/logo/logo-white.png') }}"
                        alt="HashAlpha" class="halpha-w-[50px] halpha-h-auto" />
                    <span class="halpha-text halpha-font-semibold halpha-sr-only">HashAlpha</span>
                </div>
            </div>
        </div>
        @include('partials.dashboard.navigation', $navs)
    </aside>
</div>