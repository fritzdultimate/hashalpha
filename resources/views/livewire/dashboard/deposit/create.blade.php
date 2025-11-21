<div class="halpha-w-full halpha-min-h-screen halpha-flex halpha-justify-center">
    @php

        $groupedWallets = collect($wallets)
            ->sortBy('label')
            ->groupBy(function ($item) {
        return strtoupper(substr($item['label'], 0, 1));
    });
    @endphp

    <div
        class="halpha-w-full halpha-max-w-[480px] halpha-shadow-lg halpha-min-h-screen halpha-py-5 halpha-flex halpha-flex-col halpha-gap-5">
        <x-dashboard.partials.micro-header />
        <x-dashboard.search-data />

        <x-dashboard.currency-listing :wallets="$wallets" :groupedWallets="$groupedWallets" />

    </div>
</div>