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
    <title>{{ $title ?? 'Something went wrong' }} — {{ config('app.name') }}</title>

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
</head>

<body class="halpha-bg-[#0f0f11] halpha-min-h-screen halpha-flex halpha-items-center halpha-justify-center">

    <div class="halpha-w-full halpha-max-w-xl halpha-px-4">
        <div class="halpha-card halpha-border halpha-border-gray-600 halpha-rounded-xl halpha-p-6 halpha-space-y-5">

            <div class="halpha-space-y-2">
                <h1 class="halpha-text-2xl md:halpha-text-3xl halpha-font-semibold halpha-text-white">
                    {{ $heading ?? 'Unexpected Error' }}
                </h1>

                <p class="halpha-text-sm md:halpha-text-base halpha-text-gray-400 halpha-leading-relaxed">
                    {{ $message ?? 'An unexpected error occurred while processing your request.' }}
                </p>
            </div>

            <div class="halpha-flex halpha-flex-col md:halpha-flex-row halpha-gap-3">
                <a href="{{ url('/') }}"
                    class="halpha-bg-card-bg halpha-border halpha-border-gray-600 halpha-rounded halpha-px-5 halpha-py-2 halpha-text-sm halpha-text-white hover:halpha-opacity-80">
                    Go to homepage
                </a>

                <button onclick="window.location.reload()"
                    class="halpha-bg-transparent halpha-border halpha-border-gray-600 halpha-rounded halpha-px-5 halpha-py-2 halpha-text-sm halpha-text-gray-300 hover:halpha-opacity-80">
                    Try again
                </button>
            </div>

            @isset($reference)
                <div class="halpha-text-xs halpha-text-gray-500 halpha-border-t halpha-border-gray-700 halpha-pt-3">
                    Reference ID: <span class="halpha-text-gray-300">{{ $reference }}</span>
                </div>
            @endisset

        </div>
    </div>

    @include('layouts.live-chat')
</body>

</html>