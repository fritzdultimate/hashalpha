<!-- Sprint Activity -->
<div class="halpha-card halpha-p-4 halpha-bg-card-soft halpha-rounded-xl halpha-space-y-3">

    <p class="halpha-text-xs halpha-text-gray-400">My Sprint Activity</p>

    <div class="halpha-flex halpha-justify-between">
        <span class="halpha-text-gray-400 text-xs">Direct Referrals</span>
        <span class="halpha-text-white font-semibold">
            {{ $myStats['referrals'] ?? 0 }}
        </span>
    </div>

    <div class="halpha-flex halpha-justify-between">
        <span class="halpha-text-gray-400 text-xs">Total Volume</span>
        <span class="halpha-text-accent-2 font-bold">
            ${{ format_compact($myStats['volume'] ?? 0) }}
        </span>
    </div>

</div>