@extends('layouts.guest')

@section('title', 'Affiliate Tools & Banners')

@section('content')
    <div class="halpha-px-6 halpha-py-12 halpha-bg-[#070707] halpha-text-white">
        <div class="halpha-max-w-6xl halpha-mx-auto">
            <div class="halpha-flex halpha-justify-between halpha-items-center halpha-mb-6">
                <h1 class="halpha-text-3xl halpha-font-semibold">Affiliate Tools & Banners</h1>
                <a href="{{ route('affiliate.index') }}" class="halpha-text-sm halpha-opacity-80">Back</a>
            </div>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6">
                {{-- Sample Banner card --}}
                <div
                    class="halpha-bg-[#0b0b0d] halpha-rounded-xl halpha-p-4 halpha-flex halpha-flex-col halpha-items-start">
                    <div
                        class="halpha-h-40 halpha-w-full halpha-flex halpha-items-center halpha-justify-center halpha-rounded halpha-border halpha-border-gray-700 halpha-mb-4">
                        <span class="halpha-text-xs halpha-text-gray-400">Banner preview (300×250)</span>
                    </div>
                    <div class="halpha-w-full halpha-flex halpha-justify-between halpha-items-center">
                        <div>
                            <h4 class="halpha-font-medium">300×250 Banner</h4>
                            <p class="halpha-text-xs halpha-text-gray-400">PNG / JPG / HTML</p>
                        </div>
                        <div class="halpha-space-x-2">
                            <a href="#"
                                class="halpha-text-sm halpha-border halpha-px-3 halpha-py-2 halpha-rounded">Download</a>
                            <a href="#" class="halpha-text-sm halpha-border halpha-px-3 halpha-py-2 halpha-rounded">Get
                                Code</a>
                        </div>
                    </div>
                </div>

                {{-- Other assets --}}
                <div class="halpha-bg-[#0b0b0d] halpha-rounded-xl halpha-p-4">
                    <h4 class="halpha-font-medium">Assets</h4>
                    <ul class="halpha-mt-3 halpha-space-y-2 halpha-text-sm halpha-text-gray-300">
                        <li>• Social templates</li>
                        <li>• Email swipe copy</li>
                        <li>• Landing page snippets</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection