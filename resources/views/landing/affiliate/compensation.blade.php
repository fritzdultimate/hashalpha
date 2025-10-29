@extends('layouts.guest')

@section('title', 'Compensation Plan Summary')

@section('content')
    <div class="halpha-px-6 halpha-py-12 halpha-bg-[#070707] halpha-text-white">
        <div class="halpha-max-w-4xl halpha-mx-auto">
            <h1 class="halpha-text-3xl halpha-font-semibold">Compensation Plan Summary</h1>
            <p class="halpha-text-gray-300 halpha-mt-2">Full details on rank requirements, bonus payout timing, and referral
                commission mechanics.</p>

            <div class="halpha-mt-6 halpha-grid halpha-gap-4">
                <div class="halpha-bg-[#0b0b0d] halpha-rounded-xl halpha-p-4 halpha-text-sm halpha-text-gray-300">
                    <h3 class="halpha-font-medium">Rank Requirements</h3>
                    <p class="halpha-mt-2">Each rank is unlocked when both team volume (TV) and personal deposit (PD)
                        requirements are met and the minimum number of direct referrals is reached.</p>
                </div>

                <div class="halpha-bg-[#0b0b0d] halpha-rounded-xl halpha-p-4 halpha-text-sm halpha-text-gray-300">
                    <h3 class="halpha-font-medium">Payouts & Timing</h3>
                    <p class="halpha-mt-2">Cash bonuses are one-time and paid within 7 business days after verification.
                        Ongoing commissions are processed monthly.</p>
                </div>

                <div class="halpha-bg-[#0b0b0d] halpha-rounded-xl halpha-p-4 halpha-text-sm halpha-text-gray-300">
                    <h3 class="halpha-font-medium">Team Volume Rules</h3>
                    <p class="halpha-mt-2">Team volume accumulates over time and does not reset monthly to encourage
                        long-term growth.</p>
                </div>
            </div>
        </div>
    </div>
@endsection