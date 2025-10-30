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
            </div>
        <!-- </div> -->
    </div>
</body>

</html>