<!doctype html>
<html lang="en" x-data="hashAlphaLayout()" :class="themeClass">
<head>
    <style>
        .wf-force-outline-none[tabindex="-1"]:focus{outline:none;}
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

    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>

<body
    class="halpha-font-sans halpha-text-gray-900 halpha-antialiased halpha-bg halpha-text halpha-min-h-screen halpha-flex halpha-flex-col">
    <div class="halpha-flex halpha-flex-1">

        <!-- SIDEBAR -->
        @include('partials.dashboard.aside')

        <!-- Mobile sidebar (overlay) -->
        @include('partials.dashboard.mobile-aside')

        <!-- MAIN CONTENT -->
        <div
            class="halpha-flex-1 halpha-ml-0 lg:halpha-ml-sidebar-expanded halpha-min-h-screen halpha-flex halpha-flex-col halpha-w-full">


            <!-- HEADER -->
            @include('partials.dashboard.header')

            <!-- PAGE CONTENT -->
            <main class="halpha-flex-1 halpha-p-6 halpha-overflow-auto">
                {{-- Replace with content of child pages --}}
                @yield('content')
            </main>


            <!-- FOOTER (optional) -->
            <footer class="halpha-py-4 halpha-text-center halpha-text-xs halpha-muted">
                &copy; {{ date('Y') }} HashAlpha • All rights reserved
            </footer>
        </div>
    </div>

    <script>
        function hashAlphaLayout() {
            return {
                sidebarCollapsed: false,
                mobileSidebarOpen: false,
                isSidebarOpen: true,
                openNotifications: false,
                theme: localStorage.getItem('halpha_theme') ?? 'dark',
                init() {
                    // apply theme class to html
                    this.applyTheme();
                    // restore sidebarCollapsed state
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
                openMobileSidebar() { this.mobileSidebarOpen = true; this.isSidebarOpen = true; },
                closeMobileSidebar() { this.mobileSidebarOpen = false; if (!this.sidebarCollapsed) this.isSidebarOpen = true; },
                logout() {
                    document.querySelector('form[action="{{ route('logout') }}"]').submit();
                }
            }
        }
    </script>
</body>

</html>