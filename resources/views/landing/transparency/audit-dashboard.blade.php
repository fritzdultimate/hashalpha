@extends('layouts.guest')

@section('content')
<section class="halpha-py-8">
    <div class="container-default w-container">
        <h1 class="display-2 heading-color-gradient">Audit Dashboard</h1>
        <p class="!halpha-text-gray-400">Third-party security audits, scope and remediation status.</p>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-2 halpha-gap-6 halpha-mt-6">
            {{-- example --}}
            <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                <div class="halpha-flex halpha-justify-between halpha-items-start">
                    <div>
                        <div class="halpha-text-sm halpha-text-gray-300">Provider</div>
                        <h3 class="halpha-text-white">ChainSec</h3>
                        <div class="halpha-text-sm halpha-text-gray-400">2025-09-20</div>
                    </div>
                    <div>
                        <div class="halpha-text-sm halpha-text-green-300">Passed</div>
                    </div>
                </div>
                <p class="halpha-text-sm halpha-text-gray-300 halpha-mt-3">
                    Scope: staking contracts & validator operator integrations.
                </p>

                <div class="halpha-mt-3">
                    <a href="/audits/chainsec-2025.pdf" class="btn-secondary w-button" target="_blank">View report</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
