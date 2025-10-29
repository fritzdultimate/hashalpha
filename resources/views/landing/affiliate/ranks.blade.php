
@extends('layouts.guest')

@section('title', 'Rank Progress Tracker')

@section('content')
    <div class="halpha-px-6 halpha-py-12 halpha-bg-[#070707] halpha-text-white halpha-min-h-screen">
        <div class="halpha-max-w-7xl halpha-mx-auto">
            <div class="halpha-flex halpha-items-center halpha-justify-between halpha-mb-6">
                <div>
                    <h1 class="halpha-text-3xl halpha-font-semibold">Performance Ranks & Achievement Bonuses</h1>
                    <p class="halpha-text-gray-300 halpha-mt-2">Ranks are determined by team volume (TV) and personal
                        deposit (PD).
                        Bonuses are one-time cash rewards paid upon achieving each rank.</p>
                </div>
                <div>
                    <a href="{{ route('affiliate.index') }}" class="halpha-text-sm halpha-opacity-80">Back to overview</a>
                </div>
            </div>

            <div>
                @include('landing.affiliate._rank-table', ['ranks' => $ranks, 'compact' => false])
            </div>
        </div>
    </div>
@endsection