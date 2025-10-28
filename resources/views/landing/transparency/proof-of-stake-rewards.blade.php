@extends('layouts.guest')

@section('content')
    <section class="halpha-py-8">
        <div class="container-default w-container">
            <h1 class="display-2 heading-color-gradient">Proof of Stake Rewards</h1>
            <p class="!halpha-text-gray-400">
                All reward distributions are recorded on-chain. Below is an aggregated dashboard and a searchable list of
                payout transactions.
            </p>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-4 halpha-mt-6">
                <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                    <div class="halpha-text-sm halpha-text-gray-300">This month - total rewards</div>
                    <div class="halpha-text-2xl halpha-text-white">45,123 USDT</div>
                </div>
                <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                    <div class="halpha-text-sm halpha-text-gray-300">Daily average</div>
                    <div class="halpha-text-2xl halpha-text-white">1,456 USDT</div>
                </div>
                <div class="halpha-rounded-[12px] halpha-p-4 halpha-bg-[#07121a]">
                    <div class="halpha-text-sm halpha-text-gray-300">On-chain txs</div>
                    <div class="halpha-text-2xl halpha-text-white">2,345</div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="halpha-mt-6 halpha-overflow-x-auto">
                <table class="halpha-w-full halpha-text-sm halpha-text-gray-300">
                    <thead>
                        <tr>
                            <th class="halpha-p-3">Date</th>
                            <th class="halpha-p-3">Tx Hash</th>
                            <th class="halpha-p-3">Amount</th>
                            <th class="halpha-p-3">Plan</th>
                            <th class="halpha-p-3">Proof</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['Pro','Pro','Pro','Pro','Pro','Pro','Starter', 'Executive Pro'] as $p)
                            <tr class="halpha-border-t halpha-border-[#2b2b2b] halpha-text-center">
                                <td class="halpha-p-3">2025-10-20</td>
                                <td class="halpha-p-3"><code>0x9f...c4</code></td>
                                <td class="halpha-p-3">0.18 ETH</td>
                                <td class="halpha-p-3">{{ $p }}</td>
                                <td class="halpha-p-3">
                                    <a href="https://etherscan.io/tx/0x9f..." target="_blank" class="halpha-text-[#00E7B0]">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="halpha-mt-6">
                <a href="/transparency/rewards/export.csv" class="btn-secondary w-button">Download CSV</a>
            </div>
        </div>
    </section>
@endsection