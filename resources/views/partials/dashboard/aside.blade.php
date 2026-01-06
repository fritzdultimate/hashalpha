<aside x-show="isSidebarOpen" x-transition:enter="halpha-transition halpha-ease-out halpha-duration-150"
    x-transition:enter-start="halpha-opacity-0 halpha-translate-x-[-10px]"
    x-transition:enter-end="halpha-opacity-100 halpha-translate-x-0" 
    :class="[ 
        { 'halpha-w-sidebar-collapsed': sidebarCollapsed, 'halpha-w-sidebar-expanded halpha-min-w-sidebar-expanded': !sidebarCollapsed }, 
        'halpha-flex halpha-flex-col halpha-overflow-hidden halpha-h-screen halpha-bg-[#1e1e1e] halpha-text-[var(--halpha-sidebar-text)] halpha-fixed halpha-z-30 halpha-left-0 halpha-top-0 halpha-bottom-0 halpha-border-r halpha-border-r-[#343434] halpha-min-w-sidebar-expanded'
    ]" @keydown.window.escape="closeMobileSidebar" class="halpha-hidden lg:halpha-flex halpha-overflow-hiddenr"
    aria-label="Main navigation">
    <div
        class="halpha-flex halpha-items-center halpha-justify-between halpha-px-6 halpha-py-3 halpha-border-b halpha-border-black/10">
        <div class="halpha-flex halpha-items-center halpha-gap-3">
            <img src="{{ asset('img/logo/logo-white.png') }}" alt="HashAlpha" class="halpha-w-[70px] halpha-h-auto" />
            <span class="halpha-text halpha-font-semibold halpha-text-sm halpha-sr-only"
                x-show="!sidebarCollapsed">HashAlpha</span>
        </div>
    </div>

    @include('partials.dashboard.navigation', $navs)


    <div class="halpha-p-3 halpha-border-t halpha-border-black/10">
        <button @click="logout()"
            class="halpha-w-full halpha-flex halpha-items-center halpha-justify-center halpha-gap-2 halpha-py-2 halpha-rounded halpha-text-sm hover:halpha-bg-black/10">
            <svg class="halpha-h-4 halpha-w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
            </svg>
            <span x-show="!sidebarCollapsed">Sign Out</span>
        </button>
    </div>
</aside>