<div class="halpha-card halpha-p-4 halpha-bg-card-soft halpha-rounded-xl" x-data="{ open: false }">

    <div class="halpha-flex halpha-justify-between halpha-items-center halpha-mb-3">
        <p class="halpha-text-xs halpha-text-gray-400">My Referrals (Sprint)</p>

        <button @click="open = !open" class="halpha-text-[10px] halpha-text-accent-2"
            x-text="open ? 'Hide' : 'View'"></button>
    </div>

    <div x-show="open" x-transition class="halpha-space-y-2">

        @forelse($referrals as $ref)
            <div
                class="halpha-flex halpha-justify-between halpha-items-center halpha-bg-gray-800 halpha-p-2 halpha-rounded">

                <div>
                    <p class="halpha-text-xs halpha-text-white">
                        {{ mask($ref['name']) }}
                    </p>
                    <p class="halpha-text-[10px] halpha-text-gray-400">
                        {{ mask_email($ref['email']) }}
                    </p>
                </div>

                <p class="halpha-text-xs halpha-text-accent-2 font-semibold">
                    ${{ format_compact($ref['volume']) }}
                </p>

            </div>
        @empty
            <p class="halpha-text-[11px] halpha-text-gray-400">No referrals yet</p>
        @endforelse

    </div>

</div>