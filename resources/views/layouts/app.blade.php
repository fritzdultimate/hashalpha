<!doctype html>
<html lang="en" x-data="hashAlphaLayout()" :class="themeClass">

<head>
    <style>
        .wf-force-outline-none[tabindex="-1"]:focus {
            outline: none;
        }
    </style>
    <style>
        /* Minimal critical styles to avoid flash of unstyled content */
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            background: #0b1220;
            color: #e6eef8;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }


        .initial-backdrop {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #071024, #0b1220);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }


        [x-cloak] {
            display: none !important;
        }
    </style>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>

    <meta property="og:type" content="website">
    <meta content="summary_large_image" name="twitter:card">

    <!-- Fonts -->

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:regular,500,700" media="all">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">


    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/crypto-icons/styles.css',
        'resources/css/crypto-icons/font.css'
    ])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.6.2/dist/countUp.umd.js"></script>
</head>

<body
    class="halpha-font-sans halpha-text-gray-900 halpha-antialiased halpha-bg halpha-text halpha-min-h-screen halpha-flex halpha-flex-col">

    <div x-data="globalLoader()" x-init="start(); init()" x-cloak>
        <!-- Top loader -->
        <div id="top-loader"
            class="halpha-fixed halpha-top-0 halpha-left-0 halpha-right-0 halpha-z-[9999] halpha-pointer-events-none"
            aria-hidden>
            <div x-ref="bar"
                style="height:3px; width:0; transition:width 220ms linear, opacity 180ms linear; transform-origin:left; opacity:0;"
                :style="`height:3px; background: linear-gradient(90deg,#3b82f6,#60a5fa);`"></div>
        </div>


        <div id="initial-backdrop" class="initial-backdrop" x-show="showBackdrop" x-transition.opacity>
            <div class="halpha-text-white halpha-text-2xl halpha-font-bold">My Dashboard</div>
        </div>


        <div id="app" x-bind:style="appStyle" class="halpha-flex halpha-flex-1">

            @php
                $navs = [
                    [
                        "url" => route('dashboard'),
                        "label" => "Dashboard",
                        'icon' => 'radix-dashboard',
                        'route' => 'dashboard',
                        "children" => [
                            [
                                "url" => route('dashboard'),
                                "label" => "Overview"
                            ],
                        ],

                    ],
                    [
                        "url" => "",
                        "label" => "Staking",
                        'icon' => 'fas-coins',
                        "children" => [
                            [
                                "url" => route('deposit.create'),
                                "label" => "Deposit"
                            ],
                            [
                                "url" => route('staking.stake'),
                                "label" => "My Stakes"
                            ],
                            [
                                "url" => route('staking.earnings'),
                                "label" => "Earnings"
                            ],
                        ],
                        'route' => 'staking'

                    ],
                    [
                        "url" => '',
                        "label" => "V-NFT & Token",
                        'icon' => 'ri-secure-payment-line',
                        "children" => [
                            [
                                "url" => "#",
                                "label" => "My V-NFTs (Coming Soon)"
                            ],
                            [
                                "url" => "#",
                                "label" => '$HASH (Coming Soon)'
                            ]
                        ],
                        'route' => 'vnft'

                    ],
                    [
                        "url" => '',
                        "label" => "My Team",
                        'icon' => 'iconsax-bul-driver-refresh',
                        "children" => [
                            [
                                "url" => route('referral.center'),
                                "label" => "Referral Center"
                            ],
                            [
                                "url" => route('referral.team'),
                                "label" => 'Team Dashboard'
                            ],
                            [
                                "url" => route('referral.bonus'),
                                "label" => 'Bonuses'
                            ],
                            [
                                "url" => route('referral.progress'),
                                "label" => 'Rank Progress'
                            ]
                        ],
                        'route' => 'referral'

                    ],
                    [
                        "url" => '',
                        "label" => "Transparency",
                        'icon' => 'hugeicons-blockchain-04',
                        "children" => [
                            [
                                "url" => route('transparency.validator'),
                                "label" => "Validators"
                            ],
                            [
                                "url" => route('transparency.rewards'),
                                "label" => 'Proof of Rewards'
                            ],
                            [
                                "url" => route('transparency.reports'),
                                "label" => 'Reports'
                            ],
                            [
                                "url" => route('transparency.status'),
                                "label" => 'System Status'
                            ]
                        ],
                        'route' => 'transparency'

                    ],
                    [
                        "url" => '',
                        "label" => "Account",
                        'icon' => 'ri-settings-3-fill',
                        "children" => [
                            [
                                "url" => route('account.wallets'),
                                "label" => "Wallets"
                            ],
                            [
                                "url" => route('account.withdrawal'),
                                "label" => 'Withdrawal'
                            ],
                            [
                                "url" => route('account.settings'),
                                "label" => 'Settings'
                            ],
                            [
                                "url" => route('account.support'),
                                "label" => 'Support'
                            ],
                            [
                                "url" => "",
                                "label" => 'Logout'
                            ],
                        ],
                        'route' => 'account'

                    ],
                    // [
                    //     "url" => route('withdrawal'),
                    //     "label" => "Ranking",
                    //     'icon' => 'iconsax-bul-ranking-1',
                    //     "children" => [
                    //         [
                    //             "url" => "",
                    //             "label" => "Pending"
                    //         ]
                    //     ],
                    //     'route' => 'withdrawal'

                    // ],
                ]
            @endphp
            <!-- SIDEBAR -->
            @include('partials.dashboard.aside', $navs)

            <!-- Mobile sidebar (overlay) -->
            @include('partials.dashboard.mobile-aside')

            <!-- MAIN CONTENT -->
            <div
                class="halpha-flex-1 halpha-ml-0 lg:halpha-ml-sidebar-expanded halpha-min-h-screen halpha-flex halpha-flex-col halpha-w-full">


                <!-- HEADER -->
                @include('partials.dashboard.header')

                <!-- PAGE CONTENT -->
                <main class="halpha-flex-1 halpha-p-4 lg:halpha-p-6 halpha-overflow-auto">
                    {{-- Replace with content of child pages --}}
                    {{ $slot ?? '' }}
                </main>


                <!-- FOOTER (optional) -->
                <footer class="halpha-py-4 halpha-text-center halpha-text-xs halpha-muted">
                    &copy; {{ date('Y') }} HashAlpha • All rights reserved
                </footer>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/count-up.js') }}"></script>
    <script>
        function hashAlphaLayout() {
            return {
                sidebarCollapsed: false,
                mobileSidebarOpen: false,
                isSidebarOpen: true,
                openNotifications: false,
                theme: localStorage.getItem('halpha_theme') ?? 'dark',
                init() {
                    this.applyTheme();
                    const collapsed = localStorage.getItem('halpha_sidebar_collapsed');
                    if (collapsed === '1') this.sidebarCollapsed = true;
                },
                get isDark() {
                    return this.theme === 'dark';
                },
                get themeClass() {
                    return this.isDark ? 'halpha-theme-dark' : '';
                },
                toggleTheme() {
                    this.theme = this.isDark ? 'light' : 'dark';
                    localStorage.setItem('halpha_theme', this.theme);
                    this.applyTheme();
                },
                applyTheme() {
                    if (this.isDark) document.documentElement.classList.add('halpha-theme-dark');
                    else document.documentElement.classList.remove('halpha-theme-dark');
                },
                toggleSidebarCollapse() {
                    this.sidebarCollapsed = !this.sidebarCollapsed;
                    localStorage.setItem('halpha_sidebar_collapsed', this.sidebarCollapsed ? '1' : '0');
                },
                openMobileSidebar() {
                    this.mobileSidebarOpen = true;
                    this.isSidebarOpen = true;
                },
                closeMobileSidebar() {
                    this.mobileSidebarOpen = false;
                    // if (!this.sidebarCollapsed) this.isSidebarOpen = true; 
                },
                logout() {
                    document.querySelector('form[action="{{ route('logout') }}"]').submit();
                }
            }
        }
    </script>

    <script>
        function globalLoader() {
            return {
                progress: 0,
                intervalId: null,
                showBackdrop: true,
                appStyle: { 'opacity': '0' },

                init() {
                    const done = () => {
                        this.showBackdrop = false;

                        this.appStyle = { transition: 'opacity 160ms ease', opacity: '1' };
                    };

                    requestAnimationFrame(() => setTimeout(done, 50));


                    if (window.Livewire) {
                        Livewire.hook('message.sent', () => this.start());
                        Livewire.hook('message.failed', () => this.finish());
                        Livewire.hook('message.processed', () => this.finish());
                    }


                    window.addEventListener('global-loader:start', () => this.start());
                    window.addEventListener('global-loader:done', () => this.finish());
                },

                start() {
                    if (this.intervalId) return;
                    this.progress = 0.02;
                    this.intervalId = setInterval(() => {
                        this.progress += (0.7 - this.progress) * 0.12 + 0.005;
                        if (this.progress >= 0.695) this.progress = 0.695;
                        this.updateBar();
                    }, 80);
                    this.$nextTick(() => {
                        this.setBarOpacity(1);
                    });
                },

                finish() {
                    if (!this.intervalId) {
                        this.progress = 0.95;
                        this.updateBar();
                        setTimeout(() => this.completeAndHide(), 220);
                        return;
                    }
                    clearInterval(this.intervalId);
                    this.intervalId = null;
                    const stepFinish = () => {
                        this.progress += (1 - this.progress) * 0.22 + 0.01;
                        this.updateBar();
                        if (this.progress < 0.999) {
                            requestAnimationFrame(stepFinish);
                        } else {
                            this.completeAndHide();
                        }
                    };
                    requestAnimationFrame(stepFinish);
                },

                completeAndHide() {
                    this.progress = 1;
                    this.updateBar();
                    setTimeout(() => {
                        this.setBarOpacity(0);
                        setTimeout(() => {
                            this.progress = 0;
                            this.updateBar();
                        }, 220);
                    }, 160);
                },

                updateBar() {
                    if (!this.$refs.bar) return;
                    this.$refs.bar.style.width = Math.min(100, Math.round(this.progress * 100)) + '%';
                },

                setBarOpacity(value) {
                    if (!this.$refs.bar) return;
                    this.$refs.bar.style.opacity = value;
                }
            }
        }

        window.addEventListener('DOMContentLoaded', () => window.dispatchEvent(new Event('global-loader:done')))
        window.startGlobalLoader = () => window.dispatchEvent(new Event('global-loader:start'));
        window.finishGlobalLoader = () => window.dispatchEvent(new Event('global-loader:done'));
    </script>

    @livewireScripts

    @stack('scripts')

    <script>
        (function () {
            if (!document.querySelector('.halpha-toast-container')) {
                const c = document.createElement('div');
                c.className = 'halpha-toast-container';
                document.body.appendChild(c);
            }
            const container = document.querySelector('.halpha-toast-container');

            function createToastElement(message, { variant = 'primary', timeout = 3500 } = {}) {
                const t = document.createElement('div');
                t.className = 'halpha-toast' + (variant === 'subtle' ? ' halpha-toast--subtle' : '');
                t.setAttribute('role', 'status');
                t.innerHTML = `<div class="halpha-toast__message">${escapeHtml(message)}</div>`;

                // close button
                const btn = document.createElement('button');
                btn.className = 'halpha-toast__close';
                btn.setAttribute('aria-label', 'Dismiss toast');
                btn.innerHTML = '✕';
                btn.addEventListener('click', () => removeToast(t));
                t.appendChild(btn);

                // auto remove after timeout
                const timer = setTimeout(() => removeToast(t), timeout);

                // store timer so we can clear if user dismisses early
                t._halpha_timer = timer;
                return t;
            }

            function showToast(message, options = {}) {
                const toastEl = createToastElement(message, options);
                if (container.firstChild) container.insertBefore(toastEl, container.firstChild);
                else container.appendChild(toastEl);

                requestAnimationFrame(() => {
                    toastEl.classList.add('halpha-toast--show');
                });

                return toastEl;
            }

            function removeToast(el) {
                if (!el) return;
                if (el._halpha_timer) clearTimeout(el._halpha_timer);
                el.style.transition = 'transform 260ms ease, opacity 260ms ease';
                el.style.transform = 'translateY(-18px)';
                el.style.opacity = '0';
                // remove after transition
                setTimeout(() => {
                    if (el && el.remove) el.remove();
                }, 300);
            }

            function escapeHtml(str) {
                if (typeof str !== 'string') return String(str);
                return str
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#39;');
            }

            if (window.Livewire) {
                Livewire.on('toast', ({ payload }) => {
                    let message = '';
                    let opts = {};
                    if (typeof payload === 'string') {
                        message = payload;
                    } else if (payload && typeof payload === 'object') {
                        message = payload.message;
                        if (payload.variant) opts.variant = payload.variant;
                        if (payload.timeout) opts.timeout = Number(payload.timeout) || 3500;
                    }
                    if (!message) return;
                    showToast(message, opts);
                });
            }
        })();
    </script>
    @include('layouts.live-chat')
</body>

</html>