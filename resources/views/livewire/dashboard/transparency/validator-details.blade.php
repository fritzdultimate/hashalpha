<div class="halpha-space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="halpha-text-xl md:halpha-text-3xl halpha-font-semibold halpha-text-white">
            Validator Overview
        </h1>
        <p class="halpha-text-xs md:halpha-text-sm halpha-text-gray-400">
            Validator configuration, participation, and operational health
        </p>
    </div>

    {{-- VALIDATOR IDENTITY --}}
    <div class="halpha-card halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-gray-400 halpha-bg-card-soft halpha-p-4 halpha-uppercase">
            Validator Identity
        </h3>

        <div class="halpha-p-4 halpha-space-y-2 halpha-text-xs">
            <div class="halpha-flex halpha-justify-between">
                <span class="halpha-text-gray-400">Validator Public Key</span>
                <span class="halpha-text-white">0xA91F…82D3</span>
            </div>

            <div class="halpha-flex halpha-justify-between">
                <span class="halpha-text-gray-400">Client</span>
                <span class="halpha-text-white">Prysm / Geth</span>
            </div>

            <div class="halpha-flex halpha-justify-between">
                <span class="halpha-text-gray-400">Region</span>
                <span class="halpha-text-white">EU / FR</span>
            </div>
        </div>
    </div>

    {{-- PARTICIPATION --}}
    <div class="halpha-card halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-gray-400 halpha-bg-card-soft halpha-p-4 halpha-uppercase">
            Validator Participation
        </h3>

        <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-4 halpha-p-4 halpha-text-xs">
            <div>
                <div class="halpha-text-gray-400">Status</div>
                <div class="halpha-text-green-400 halpha-font-semibold">Active</div>
            </div>

            <div>
                <div class="halpha-text-gray-400">Uptime (90d)</div>
                <div class="halpha-text-white">99.8%</div>
            </div>

            <div>
                <div class="halpha-text-gray-400">Missed Attestations</div>
                <div class="halpha-text-white">Within tolerance</div>
            </div>
        </div>
    </div>

    {{-- SLASHING --}}
    <div class="halpha-card halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-gray-400 halpha-bg-card-soft halpha-p-4 halpha-uppercase">
            Slashing & Risk
        </h3>

        <div class="halpha-p-4 halpha-text-xs halpha-text-gray-400">
            No slashing events recorded. Validator operating within protocol rules.
        </div>
    </div>

</div>
