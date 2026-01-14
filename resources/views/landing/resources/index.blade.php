@extends('layouts.guest')

@section('title', 'Resources')

@section('content')
    <div class="halpha-px-6 halpha-py-12 halpha-bg-[#070707] halpha-text-white">
        <div class="halpha-max-w-5xl halpha-mx-auto">
            <header class="halpha-mb-8">
                <h1 class="halpha-text-3xl halpha-font-semibold">Resources</h1>
                <p class="halpha-mt-2 halpha-text-gray-300">Everything you need — docs, whitepaper, brand assets, roadmap
                    and latest announcements.</p>
            </header>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6">
                @foreach($resources as $r)
                    <div class="halpha-bg-[#0b0b0d] halpha-rounded-2xl halpha-p-5">
                        <div class="halpha-flex halpha-justify-between halpha-items-start"> 
                            <div>
                                <h3 class="halpha-text-lg halpha-font-medium">{{ $r['title'] }}</h3>
                                <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-2">{{ $r['description'] }}</p>
                            </div>
                            <div class="halpha-text-right">
                                @if($r['type'] === 'external')
                                    <a href="{{ $r['url'] }}" target="_blank"
                                        class="halpha-inline-block halpha-border halpha-rounded halpha-px-3 halpha-py-2 halpha-text-sm">Open</a>
                                @elseif($r['type'] === 'internal')
                                    <a href="{{ $r['url'] }}"
                                        class="halpha-inline-block halpha-border halpha-rounded halpha-px-3 halpha-py-2 halpha-text-sm">Open</a>
                                @else
                                    <a href="{{ $r['url'] }}"
                                        class="halpha-inline-block halpha-border halpha-rounded halpha-px-3 halpha-py-2 halpha-text-sm">Download</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <section class="halpha-mt-8 halpha-bg-[#050506] halpha-rounded-xl halpha-p-6">
                <h2 class="halpha-text-xl halpha-font-semibold">Latest Announcements</h2>
                <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-2">Latest posts from the blog / release notes.</p>

                
                <ul class="halpha-mt-4 halpha-space-y-3">
                    <li
                        class="halpha-flex halpha-justify-between halpha-items-start halpha-bg-[#0b0b0d] halpha-p-3 halpha-rounded">
                        <div>
                            <a href="#blog-post" class="halpha-font-medium">v1.2 Release — Affiliate Dashboard &
                                Tracking</a>
                            <div class="halpha-text-xs halpha-text-gray-400">Oct 15, 2025 — Improvements to affiliate
                                onboarding and analytics</div>
                        </div>
                        <div class="halpha-text-sm halpha-text-gray-400">Read</div>
                    </li>
                    <li
                        class="halpha-flex halpha-justify-between halpha-items-start halpha-bg-[#0b0b0d] halpha-p-3 halpha-rounded">
                        <div>
                            <a href="{{ asset('resources/halpha-whitepaper.pdf') }}" target="_blank" class="halpha-font-medium">Whitepaper v1.0 Released</a>
                            <div class="halpha-text-xs halpha-text-gray-400">Sep 12, 2025 — Architecture & tokenomics
                                explained</div>
                        </div>
                        <div class="halpha-text-sm halpha-text-gray-400">View</div>
                    </li>
                </ul>
            </section>
        </div>
    </div>
@endsection