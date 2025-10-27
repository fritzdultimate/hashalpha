<head>
    <style>
        .wf-force-outline-none[tabindex="-1"]:focus{outline:none;}
    </style>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home - {{ env('APP_NAME') }}</title>

    <meta content="Cryptoverse X is our crypto Webflow Template created for crypto startups looking to have a minimal, clean and dark mode style for their website." name="description">

    <meta content="Home V1 - Cryptoverse X - Webflow Ecommerce website template" property="og:title">

    <meta content="Cryptoverse X is our crypto Webflow Template created for crypto startups looking to have a minimal, clean and dark mode style for their website." property="og:description">

    <meta content="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/6616d86526b24644a2085752_featured-image-cryptoverse-x-webflow-template.png" property="og:image">

    <meta content="Home V1 - Cryptoverse X - Webflow Ecommerce website template" property="twitter:title">

    <meta content="Cryptoverse X is our crypto Webflow Template created for crypto startups looking to have a minimal, clean and dark mode style for their website." property="twitter:description">

    <meta content="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/6616d86526b24644a2085752_featured-image-cryptoverse-x-webflow-template.png" property="twitter:image">

    <meta property="og:type" content="website">
    <meta content="summary_large_image" name="twitter:card">
    
    <!-- <link href="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/css/cryptoversetemplate.webflow.50f571824.css" rel="stylesheet" type="text/css"> -->

    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net"> -->
    <!-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:regular,500,700" media="all">

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
    <link href="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64ee44f9a8a7d2975c808651_favicon-cryptomatic-webflow-ecommerce-template.png" rel="shortcut icon" type="image/x-icon">
    <link href="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d2ce1474942ac2c2d74ff5_webclip-cryptomatic-webflow-ecommerce-template.svg" rel="apple-touch-icon">
    <style>
        .w-webflow-badge{
            display:none !important;
        }
    </style>
</head>