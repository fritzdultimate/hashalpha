<div x-show="mobileSidebarOpen" x-cloak class="halpha-fixed halpha-inset-0 halpha-z-40 lg:halpha-hidden"
    aria-hidden="false">
    <div @click="closeMobileSidebar" class="halpha-absolute halpha-inset-0 halpha-bg-[var(--halpha-backdrop)]">
    </div>
    <aside
        class="halpha-relative halpha-w-72 halpha-h-full halpha-bg-[#1e1e1e] halpha-text-[var(--halpha-sidebar-text)] halpha-border-r halpha-border-r-[#343434]">
        <div class="halpha-p-4">
            <!-- same content as above but simplified -->
            <div class="halpha-flex halpha-items-center halpha-justify-between">
                <div class="halpha-flex halpha-items-center halpha-gap-3">
                    <img src="/images/halpha-logo-white.svg" alt="HashAlpha" class="halpha-h-8 halpha-w-8" />
                    <span class="halpha-text halpha-font-semibold">HashAlpha</span>
                </div>
                <button @click="closeMobileSidebar" class="halpha-p-1 halpha-rounded">✕</button>
            </div>
        </div>
        <nav class="halpha-p-2 halpha-space-y-1">
            <!-- nav items -->
        </nav>
    </aside>
</div>