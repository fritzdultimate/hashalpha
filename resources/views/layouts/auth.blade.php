<!doctype html>
<html lang="en">
@include('layouts.guest.head')

<body class="halpha-font-sans halpha-text-gray-900 halpha-antialiased">
    <div class="page-wrapper">
        {{-- Phone-like shell --}}
        <!-- <div class="halpha-w-full halpha-max-w-sm halpha-rounded-3xl halpha-overflow-hidden halpha-shadow-2xl halpha-relative" -->
        <!-- style="background: linear-gradient(180deg, rgba(10,10,12,0.6), rgba(2,2,3,0.85)); border: 1px solid rgba(255,255,255,0.03);"> -->
        {{-- top notch / status bar --}}
        <div class="halpha-p-4 halpha-flex sm:halpha-hidden halpha-items-center halpha-justify-center">
            <div class="halpha-w-10 halpha-h-1 halpha-rounded-full halpha-bg-white halpha-opacity-10"></div>
        </div>

        {{-- content --}}
        <div class="halpha-px-6 halpha-pb-8">
            @yield('content')

            {{ $slot ?? '' }}
        </div>
        <!-- </div> -->

        <footer
            class="halpha-w-full halpha-text-center halpha-py-6 halpha-text-sm halpha-text-gray-400 halpha-border-t halpha-border-gray-800 halpha-bg-[#050505]">
            <div class="halpha-max-w-md halpha-mx-auto halpha-space-y-1">
                <p class="halpha-text-gray-400/80">© {{ date('Y') }} <span
                        class="halpha-text-white halpha-font-semibold">
                        {{ env('APP_NAME') }}</span>. All rights reserved.
                </p>
                <div
                    class="halpha-flex halpha-items-center halpha-justify-center halpha-gap-4 halpha-text-xs halpha-opacity-70">
                    <a href="#" class="hover:halpha-text-white halpha-transition">Privacy Policy</a>
                    <span class="halpha-text-gray-700">•</span>
                    <a href="#" class="hover:halpha-text-white halpha-transition">Terms</a>
                    <span class="halpha-text-gray-700">•</span>
                    <a href="#" class="hover:halpha-text-white halpha-transition">Support</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- TOAST -->
<div x-data="toastApp()" x-init="init()" class="halpha-fixed halpha-top-4 halpha-right-4 halpha-z-50" aria-live="polite" aria-atomic="true">
    <template x-for="t in toasts" :key="t.id">
        <div x-show="t.show" x-cloak x-transition.duration.200ms
            class="halpha-max-w-sm halpha-mb-3 halpha-rounded halpha-shadow-lg halpha-overflow-hidden halpha-flex halpha-items-center halpha-gap-3 halpha-px-4 halpha-py-1 halpha-relative"
            :class="toastClasses(t.type)" @mouseenter="t.pause = true" @mouseleave="t.pause = false">

            <div class="halpha-flex-1">
                <div x-show="t.title" class="halpha-font-semibold halpha-mb-0.5" x-text="t.title"></div>
                <div class="halpha-text-sm" x-html="t.message"></div>
            </div>

            <button 
                x-show="t.dismissable"
                x-cloak
                @click="remove(t.id)"
                class="halpha-flex halpha-items-center halpha-justify-center halpha-w-8 halpha-h-8 halpha-rounded hover:halpha-opacity-80">
                <svg class="halpha-w-4 halpha-h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- progress bar (bottom) -->
            <div class="halpha-w-full halpha-absolute halpha-left-0 halpha-bottom-0 halpha-h-1 halpha-overflow-hidden halpha-rounded-b" style="left:0; right:0;">
                <div 
                    :style="`width: ${t.progress}%`" 
                    :class="progressBarClass(t.type)"
                    class="halpha-h-1 halpha-transition-all"
                ></div>
            </div>
        </div>
    </template>
</div>

<script>
    function toastApp() {
        return {
            toasts: [],
            nextId: 1,
            defaultDuration: 4000, // milliseconds
            init() {
                window.addEventListener('toast', event => {
                    const payload = event.detail || {};
                    this.push(payload);
                });

                // apply remembered theme on init
                this.applyTheme(this.getTheme());
            },
            push({ message = '', type = 'info', title = '', dismissable = false, duration = null } = {}) {
                const id = this.nextId++;
                const dur = (typeof duration === 'number' && duration > 0) ? duration : this.defaultDuration;

                const toast = {
                    id,
                    message,
                    type,
                    title,
                    show: true,
                    pause: false,
                    dismissable,
                    duration: dur,
                    remaining: dur,
                    lastTick: Date.now(),
                    progress: 100
                };
                console.log(this.toasts)
                this.toasts.push(toast);
                console.log(this.toasts)

                
                const tick = () => {
                    const t = this.toasts.find(x => x.id === id);
                    if (!t || !t.show) return;

                    const now = Date.now();

                    if (!t.pause) {
                        const delta = now - t.lastTick;
                        t.remaining = Math.max(0, t.remaining - delta);
                        t.lastTick = now;
                        t.progress = Math.max(0, (t.remaining / t.duration) * 100);

                        if (t.remaining <= 0) {
                            this.remove(id);
                            return;
                        }
                    } else {
                        t.lastTick = now;
                    }

                    requestAnimationFrame(tick);
                };

                // start ticking
                requestAnimationFrame(tick);
            },
            remove(id) {
                const t = this.toasts.find(x => x.id === id);
                if (t) t.show = false;
                setTimeout(() => this.toasts = this.toasts.filter(x => x.id !== id), 220);
            },
            toastClasses(type) {
                const dark = document.documentElement.classList.contains('dark') || localStorage.getItem('theme') === 'dark';
                if (type === 'success') {
                    return 'halpha-bg-green-800 halpha-text-white';
                }
                if (type === 'error') {
                    return 'halpha-bg-red-700 halpha-text-white';
                }
                // info / default
                return 'halpha-bg-gray-700 halpha-text-white';
            },
            progressBarClass(type) {
                if (type === 'success') return 'halpha-bg-white';
                if (type === 'error') return 'halpha-bg-white';
                return 'halpha-bg-white';
            },

            // THEME HELPERS
            getTheme() {
                return localStorage.getItem('theme') || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            },
            setTheme(theme) {
                localStorage.setItem('theme', theme);
                this.applyTheme(theme);
            },
            applyTheme(theme) {
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        };
    }
</script>


</body>

</html>