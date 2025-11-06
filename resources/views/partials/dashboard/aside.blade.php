<aside 
    x-show="isSidebarOpen" 
    x-transition:enter="halpha-transition halpha-ease-out halpha-duration-150"
    x-transition:enter-start="halpha-opacity-0 halpha-translate-x-[-10px]"
    x-transition:enter-end="halpha-opacity-100 halpha-translate-x-0" 
    :class="[ 
        { 'halpha-w-sidebar-collapsed': sidebarCollapsed, 'halpha-w-sidebar-expanded halpha-min-w-sidebar-expanded': !sidebarCollapsed }, 
        'halpha-flex halpha-flex-col halpha-overflow-hidden halpha-h-screen halpha-bg-[#1e1e1e] halpha-text-[var(--halpha-sidebar-text)] halpha-fixed halpha-z-30 halpha-left-0 halpha-top-0 halpha-bottom-0 halpha-border-r halpha-border-r-[#343434] halpha-min-w-sidebar-expanded'
    ]"
    @keydown.window.escape="closeMobileSidebar" 
    class="halpha-hidden lg:halpha-flex"
    aria-label="Main navigation"
>
    <div
        class="halpha-flex halpha-items-center halpha-justify-between halpha-px-4 halpha-py-3 halpha-border-b halpha-border-black/10">
        <div class="halpha-flex halpha-items-center halpha-gap-3">
            <img src="/images/halpha-logo-white.svg" alt="HashAlpha" class="halpha-h-8 halpha-w-8" />
            <span class="halpha-text halpha-font-semibold halpha-text-sm" x-show="!sidebarCollapsed">HashAlpha</span>
        </div>
    </div>

    @php
        $activeDashboard = isRoute('dashboard');
    @endphp

    <nav class="halpha-flex-1 halpha-overflow-auto halpha-py-4 halpha-space-y-1 halpha-px-2">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="halpha-flex halpha-items-center halpha-gap-3 halpha-px-3 halpha-py-2 halpha-rounded halpha-text-sm hover:halpha-bg-black/10"
            :class="{'halpha-bg-black/15': {{ $activeDashboard ? 'true' : 'false' }}}">
            <svg class="halpha-h-5 halpha-w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h4V3H3v7zM3 21h4v-7H3v7zM10 3v18h7V3h-7zM21 10h-4v11h4V10z" />
            </svg>
            <span x-show="!sidebarCollapsed">Overview</span>
        </a>


        <!-- Investments -->
        <a href="#"
            class="halpha-flex halpha-items-center halpha-gap-3 halpha-px-3 halpha-py-2 halpha-rounded halpha-text-sm hover:halpha-bg-black/10">
            <svg class="halpha-h-5 halpha-w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"></path>
            </svg>
            <span x-show="!sidebarCollapsed">Investments</span>
        </a>


        <!-- Validators (niche) -->
        <a href="#"
            class="halpha-flex halpha-items-center halpha-gap-3 halpha-px-3 halpha-py-2 halpha-rounded halpha-text-sm hover:halpha-bg-black/10">
            <svg class="halpha-h-5 halpha-w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
            </svg>
            <span x-show="!sidebarCollapsed">Validators</span>
        </a>


        <!-- Wallets, Transactions, Reports -->
        <a href="#"
            class="halpha-flex halpha-items-center halpha-gap-3 halpha-px-3 halpha-py-2 halpha-rounded halpha-text-sm hover:halpha-bg-black/10">
            <svg class="halpha-h-5 halpha-w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18"></path>
            </svg>
            <span x-show="!sidebarCollapsed">Wallets</span>
        </a>


    </nav>


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