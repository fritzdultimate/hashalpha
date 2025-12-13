<div class="halpha-space-y-6">
    <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
        Referral Bonus
    </h1>
    <p class="halpha-text-xs halpha-text-gray-400">
        View your downline bonuses
    </p>

    <div class="halpha-grid halpha-grid-cols-2 halpha-gap-3">
        <x-affiliate.stat label="Claimable" :value="500" prefix="$" highlight />
        <x-affiliate.stat label="Pending" :value="958" prefix="$" />
    </div>

    @if($claimable > 0)
        <div class="halpha-card halpha-p-4 halpha-border-success/30">
            <div class="halpha-flex halpha-justify-between halpha-items-center">
                <div>
                    <p class="halpha-text-sm halpha-text-white">Available Bonus</p>
                    <p class="halpha-text-xs halpha-text-gray-400">Ready to claim</p>
                </div>

                <button class="halpha-bg-accent-2 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded halpha-text-xs">
                    Claim
                </button>
            </div>
        </div>
    @endif


    <div class="halpha-space-y-2">
        <div class="halpha-card halpha-p-3 halpha-flex halpha-justify-between">
            <div>
                <div class="halpha-text-sm halpha-text-white">User #B31F</div>
                <div class="halpha-text-xs halpha-text-gray-400">Joined 4 days ago</div>
            </div>
            <div class="halpha-text-right">
                <div class="halpha-text-xs halpha-text-success">Active</div>
                <div class="halpha-text-xs halpha-text-gray-400">$1,250</div>
            </div>
        </div>

        <div class="halpha-card halpha-p-3 halpha-flex halpha-justify-between">
            <div>
                <div class="halpha-text-sm halpha-text-white">User #R432</div>
                <div class="halpha-text-xs halpha-text-gray-400">Joined 4 days ago</div>
            </div>
            <div class="halpha-text-right">
                <div class="halpha-text-xs halpha-text-success">Active</div>
                <div class="halpha-text-xs halpha-text-gray-400">$1,250</div>
            </div>
        </div>

        <div class="halpha-card halpha-p-3 halpha-flex halpha-justify-between">
            <div>
                <div class="halpha-text-sm halpha-text-white">User #H743</div>
                <div class="halpha-text-xs halpha-text-gray-400">Joined 43 days ago</div>
            </div>
            <div class="halpha-text-right">
                <div class="halpha-text-xs halpha-text-accent-3">Inactive</div>
                <div class="halpha-text-xs halpha-text-gray-400">$1,250</div>
            </div>
        </div>
    </div>


</div>