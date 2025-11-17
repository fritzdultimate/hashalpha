<head>
    <style>
        .wf-force-outline-none[tabindex="-1"]:focus{outline:none;}
    </style>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:regular,500,700" media="all">
    <!-- <script>
        window.alert = function(msg) {
            console.trace('Alert called with:', msg);
        };
    </script> -->

    <script type="text/javascript">WebFont.load({  google: {    families: ["Inter:regular,500,700"]  }});</script>
    <script type="text/javascript">
        !function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);
    </script>

    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/css/landing-styles.css',
        'resources/js/app.js',
    ])

    <!-- SHortcut Icon -->
    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon" type="image/x-icon">
    <link href="{{ asset('favicon.ico') }}" rel="apple-touch-icon">
    <style>
        .glass-card{ background: rgba(255,255,255,0.65); backdrop-filter: blur(6px); }
    </style>
</head>