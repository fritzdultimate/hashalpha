<div class="halpha-space-y-5">
    <div class="halpha-space-y-5">
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Referral Center
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            Invite friends and earn from their activity
        </p>

        <div class="halpha-card halpha-p-4 halpha-rounded-xl halpha-bg-gray-900 halpha-border halpha-border-gray-800">
            <div class="halpha-text-xs halpha-text-gray-400">Your referral link</div>

            <div class="halpha-flex halpha-items-center halpha-gap-2 halpha-mt-2">
                <input 
                    readonly 
                    value="https://"
                    class="halpha-flex-1 halpha-bg-gray-800 halpha-text-xs halpha-text-white halpha-rounded halpha-px-3 halpha-py-2" 
                />

                <button class="halpha-px-3 halpha-py-2 halpha-bg-accent-2 halpha-text-white halpha-rounded halpha-text-xs hover:halpha-bg-accent-3">
                    Copy
                </button>
            </div>
        </div>
    </div>

    <div class="halpha-grid halpha-grid-cols-2 md:halpha-grid-cols-4 halpha-gap-3">
        <x-affiliate.stat label="Total Referrals" :value="100" />
        <x-affiliate.stat label="Active Referrals" :value="800" />
        <x-affiliate.stat label="Total Earnings" :value="900" prefix="$" />
        <x-affiliate.stat label="This Month" :value="857" prefix="$" />
    </div>

    <div class="halpha-card halpha-p-4 halpha-rounded-xl">
        <h3 class="halpha-text-sm halpha-font-semibold halpha-text-white mb-3">
            Recent referrals
        </h3>

        <div class="halpha-space-y-3">
            <!-- each row -->
            <div class="halpha-flex halpha-justify-between halpha-text-xs">
                <span class="halpha-text-gray-300">User #A92K</span>
                <span class="halpha-text-accent-2 hover:halpha-text-accent-3">Active</span>
            </div>
        </div>
    </div>



    <!-- Main content -->
</div>