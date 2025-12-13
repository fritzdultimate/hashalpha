<div class="halpha-space-y-6">
    <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
        Rank Progress
    </h1>
    <p class="halpha-text-xs halpha-text-gray-400">
        View your downline bonuses
    </p>

    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
        <x-affiliate.stat label="Claimable" :value="500" prefix="$" highlight />
        <x-affiliate.stat label="Pending" :value="958" prefix="$" />
    </div>


    <div class="halpha-card halpha-p-5 halpha-text-center">
        <p class="halpha-text-xs halpha-text-gray-400">Your rank</p>
        <h2 class="halpha-text-2xl halpha-font-bold halpha-text-accent-2">
            Silver
        </h2>
    </div>

    <div class="halpha-card halpha-p-4">
        <div class="halpha-flex halpha-justify-between halpha-text-xs halpha-text-gray-400 mb-1">
            <span>Progress to Gold</span>
            <span>65%</span>
        </div>

        <div class="halpha-h-2 halpha-bg-gray-800 halpha-rounded">
            <div class="halpha-h-2 halpha-bg-accent-2 halpha-rounded" style="width:65%"></div>
        </div>
    </div>

    <div class="halpha-space-y-2">
        <x-affiliate.step name="Bronze" :active="true" />
        <x-affiliate.step name="Silver" :active="true" />
        <x-affiliate.step name="Gold" />
        <x-affiliate.step name="Platinum" />
    </div>




</div>