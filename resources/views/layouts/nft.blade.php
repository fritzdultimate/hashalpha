<!DOCTYPE html>
<html lang="en" class="h-full bg-black">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HashAlpha Dashboard | Validator V-NFTs</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN for standalone portability) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#0a0a0a',
                            card: '#111111',
                            accent: '#00d4ff'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="h-full antialiased text-gray-100 bg-dark-bg">
    @yield('contents')
    <!-- Application Logic -->
    <script src="{{ asset('assets/js/wallet.js') }}"></script>

</body>

</html>