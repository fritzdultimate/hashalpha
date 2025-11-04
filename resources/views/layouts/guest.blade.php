<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- Head Element Inclusion -->
    @include('layouts.guest.head')

    <body class="halpha-font-sans halpha-text-gray-900 halpha-antialiased">
        <div class="page-wrapper">
            @include('layouts.guest.navigation')
            <div class="!halpha-py-8 md:!halpha-py-12"></div>
            @yield('content')
            @include('layouts.guest.footer')
        </div>


        <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=64d2cc2d27b51cf1b517c011" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/js/webflow.280056477.js" type="text/javascript"></script>
    </body>
</html>
