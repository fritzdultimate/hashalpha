@extends('layouts.guest')

@section('title', 'Terms & Conditions')

@section('content')
    <section class="halpha-pb-24 section small">
        <div class="container-default w-container">

            {{-- Header --}}
            <div class="halpha-max-w-3xl halpha-mx-auto halpha-text-center halpha-mb-12">
                <h1 class="display-2 halpha-mb-4">Terms & Conditions</h1>
                <p class="halpha-text-gray-400 halpha-text-sm">
                    Last updated: {{ $lastUpdated }}
                </p>
            </div>

            {{-- Document Card --}}
            <div class="halpha-max-w-4xl halpha-mx-auto">
                <div class="card halpha-p-6 md:halpha-p-12 halpha-leading-relaxed">

                    {{-- Intro --}}
                    <p class="halpha-text-gray-300 halpha-mb-8">
                        {!! nl2br(e($intro)) !!}
                    </p>

                    {{-- Sections --}}
                    @foreach ($sections as $section)
                        <div class="halpha-mb-10">

                            <h2 class="display-4 halpha-mb-4">
                                {{ $section['title'] }}
                            </h2>

                            @foreach ($section['paragraphs'] as $paragraph)
                                <p class="halpha-text-gray-300 halpha-mb-4">
                                    {!! nl2br(e($paragraph)) !!}
                                </p>
                            @endforeach

                            @if (!empty($section['list']))
                                <ul class="halpha-list-disc halpha-pl-6 halpha-text-gray-300 halpha-mt-4">
                                    @foreach ($section['list'] as $item)
                                        <li class="halpha-mb-2">
                                            {!! e($item) !!}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>

                        <div class="divider _48px"></div>
                    @endforeach

                </div>
            </div>

        </div>
    </section>
@endsection
