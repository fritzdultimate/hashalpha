@extends('layouts.guest')

@section('content')
<section class="halpha-py-8">
    <div class="container-default w-container">
        <h1 class="display-2 heading-color-gradient">Operations Reports</h1>
        <p class="!halpha-text-gray-400">Monthly operations reports covering uptime, incidents, capacity and more.</p>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-6 halpha-mt-6">
            
            <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                <h3 class="halpha-text-white">October 2025</h3>
                <p class="halpha-text-sm halpha-text-gray-300">Uptime 99.9% — No major incidents</p>
                <div class="halpha-mt-4">
                    <a href="/reports/oct-2025.pdf" class="btn-primary w-button" target="_blank">Download</a>
                </div>
            </div>
        </div>

        {{-- PDF viewer (latest) --}}
        <div class="halpha-mt-8 halpha-rounded-[12px] halpha-overflow-hidden halpha-bg-[#07121a] halpha-p-4">
            <iframe src="/reports/oct-2025.pdf" class="halpha-w-full halpha-h-[600px]" title="Operations Report October 2025"></iframe>
        </div>
    </div>
</section>
@endsection
