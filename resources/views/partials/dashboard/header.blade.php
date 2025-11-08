<header class="halpha-flex halpha-items-center halpha-justify-between halpha-h-16 halpha-px-4 halpha-bg-[#1e1e1e] halpha-border-b halpha-border-[#343434] halpha-text-sm halpha-z-20">


    <div class="halpha-flex halpha-items-center halpha-gap-3">
        <!-- Mobile menu button -->
        <button 
            @click.prevent="openMobileSidebar"
            class="halpha-inline-flex lg:halpha-hidden halpha-items-center halpha-p-2 halpha-rounded halpha-font-medium hover:halpha-bg-black/30">
            <x-iconpark-menufoldone class="halpha-w-6 halpha-h-6 halpha-text-[#e6f6ff]" />
        </button>

        <!-- <button @click.prevent="toggleSidebarCollapse"
            class="halpha-hidden lg:halpha-inline-flex halpha-items-center halpha-gap-2 halpha-p-2 halpha-rounded hover:halpha-bg-black/30"
            :aria-expanded="!sidebarCollapsed">
            <x-iconpark-menufoldone class="halpha-w-6 halpha-h-6" />
            <span x-show="!sidebarCollapsed" class="halpha-text-sm halpha-sr-only">Collapse</span>
        </button> -->


        <!-- Page title or breadcrumb -->
        <div>
            <h1 class="halpha-text halpha-font-semibold halpha-text-lg halpha-hidden lg:halpha-block halpha-text-[#e6f6ff]">{{ $pageTitle ?? 'Dashboard' }}</h1>
            <span class="halpha-muted halpha-text-xs">Welcome back, {{ Auth::user()->name ?? 'User' }}</span>
        </div>
    </div>


    <div class="halpha-flex halpha-items-center halpha-gap-3">
        <div
            class="halpha-hidden sm:halpha-flex halpha-items-center halpha-gap-2 halpha-px-2 halpha-py-1 halpha-rounded halpha-bg-[var(--halpha-surface)]">
            <input wire:model.debounce.500ms="search" type="text" placeholder="Search investments, validators..."
                class="halpha-bg-transparent halpha-border-0 halpha-outline-none halpha-text-sm halpha-w-64" />
            <button wire:click="$emit('search')" class="halpha-p-1 halpha-rounded">🔍</button>
        </div>


        <!-- Theme toggle -->
        <button @click="toggleTheme()" class="halpha-p-2 halpha-rounded !halpha-text-accent" title="Toggle theme">
            <template x-if="isDark">
                <x-eos-light-mode class="halpha-w-5 halpha-h-5 !halpha-text-accent" />
            </template>
            <template x-if="!isDark">
                <x-eos-mode-night class="halpha-w-5 halpha-h-5 !halpha-text-[#e6f6ff]" />
            </template>
        </button>


        <!-- Notifications -->
        <div class="halpha-relative">
            <button class="halpha-p-2 halpha-rounded" @click.prevent="openNotifications = !openNotifications"
                aria-expanded="false">
                <svg class="halpha-h-5 halpha-w-5 halpha-text-[#e6f6ff]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
            <span
                class="halpha-absolute halpha-top-0 halpha-right-0 halpha-inline-flex halpha-items-center halpha-justify-center halpha-h-4 halpha-w-4 halpha-rounded-full halpha-bg-[var(--halpha-danger)] halpha-text-white halpha-text-xs">3</span>
        </div>


        <!-- User menu -->
        <div class="halpha-relative" x-data="{open:false}">
            <button @click="open = !open"
                class="halpha-flex halpha-items-center halpha-gap-2 halpha-rounded halpha-p-1">
                <x-heroicon-o-user-circle class="halpha-w-6 halpha-h-6 halpha-text-[#e6f6ff]" />
                <span class="halpha-hidden sm:halpha-inline-block halpha-text-sm halpha-text-[#e6f6ff]">
                    {{ Auth::user()->name ?? 'User' }}
                </span>
            </button>


            <div x-show="open" x-cloak
                class="halpha-absolute halpha-right-0 halpha-mt-2 halpha-w-48 halpha-bg-[var(--halpha-surface)] halpha-rounded halpha-shadow-lg halpha-p-2">
                <a href="#" class="halpha-block halpha-py-2 halpha-px-3 halpha-text-sm">Profile</a>
                <a href="#" class="halpha-block halpha-py-2 halpha-px-3 halpha-text-sm">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="halpha-w-full halpha-text-left halpha-py-2 halpha-px-3 halpha-text-sm">Sign
                        out</button>
                </form>
            </div>
        </div>
</header>