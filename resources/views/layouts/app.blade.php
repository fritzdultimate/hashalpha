<!doctype html>
<html lang="en">
@include('layouts.guest.head')

<body class="halpha-font-sans halpha-text-gray-900 halpha-antialiased">
    <div class="page-wrapper">
        <div class="halpha-p-4 halpha-flex sm:halpha-hidden halpha-items-center halpha-justify-center">
            <div class="halpha-w-10 halpha-h-1 halpha-rounded-full halpha-bg-white halpha-opacity-10"></div>
        </div>

        {{-- content --}}
        <div class="halpha-px-6 halpha-pb-8">
            @yield('content')

            {{ $slot ?? '' }}
        </div>
    </div>

</body>

</html>