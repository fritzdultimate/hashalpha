<div class="halpha-space-y-6">
    <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
        Rank Progress
    </h1>
    <p class="halpha-text-xs halpha-text-gray-400">
        View your downline bonuses
    </p>

    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
        <x-affiliate.stat label="Claimable" :value="number_format($claimable)" prefix="$" highlight />
        <x-affiliate.stat label="Pending" :value="number_format($pending)" prefix="$" />
    </div>


    <div class="halpha-card halpha-p-5 halpha-text-center">
        <p class="halpha-text-xs halpha-text-gray-400">Your rank</p>
        <h2 class="halpha-text-2xl halpha-font-bold halpha-text-accent-2">
            {{ $currentRank->name }}
        </h2>
    </div>

    <div class="halpha-card halpha-p-4">
        <div class="halpha-flex halpha-justify-between halpha-text-xs halpha-text-gray-400 mb-1">
            <span>Progress to Gold</span>
            <span>{{ $progressPercent }}%</span>
        </div>

        <div class="halpha-h-2 halpha-bg-gray-800 halpha-rounded">
            <div class="halpha-h-2 halpha-bg-accent-2 halpha-rounded" style="width:{{ $progressPercent }}%"></div>
        </div>
    </div>

    <div class="halpha-space-y-2">
        @foreach($ranks as $rank)
            <x-affiliate.step
                :name="$rank->name"
                :active="$rank->level <= $currentRank->level"
            />
        @endforeach
    </div>

    {{-- Ranking Information --}}
    <div class="halpha-card halpha-rounded-lg halpha-bg-card-soft halpha-p-3 halpha-text-[11px] halpha-text-gray-400 halpha-leading-relaxed">
        <p class="halpha-font-medium halpha-text-gray-300 halpha-mb-1">
            Rank Qualification Rules
        </p>

        <ul class="halpha-list-disc halpha-pl-4 halpha-space-y-1">
            <li>Ranks are determined by total team volume, active referrals, and earned rewards.</li>
            <li>Rank upgrades occur automatically once all requirements are met.</li>
            <li>Higher ranks unlock increased bonus eligibility and platform privileges.</li>
            <li>Rank status is permanent and will not downgrade once achieved.</li>
            <li>All calculations are performed system-wide and cannot be manually altered.</li>
        </ul>
    </div>




</div>