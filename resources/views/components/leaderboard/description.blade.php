<div class="halpha-space-y-4">

        {{-- 📘 DESCRIPTION --}}
        <div class="halpha-card halpha-bg-card-soft halpha-p-4 halpha-rounded-xl halpha-space-y-4 halpha-text-[12px] halpha-text-gray-400">

            @if (strtolower($category->type) === 'volume')
                {{-- 🥇 VOLUME --}}
                <div class="halpha-flex halpha-gap-3">
                    <div class="halpha-text-accent-2">💰</div>
                    <div>
                        <p class="halpha-text-white halpha-font-semibold text-sm">
                            Top Personal Volume — $5,000 Pool
                        </p>
                        <p>
                            Leaderboard rankings are determined by <span class="halpha-text-gray-200">total personal (Volume 1)</span> participation accumulated during the Sprint 1 period.
                        </p> 
                            
                        <p>
                            Only <span class="halpha-text-gray-200">directly enrolled users</span> and personally generated volume are considered
                        </p>

                        <p class="halpha-mt-1">
                            Downline activity and team spillover are not included in the calculation.
                        </p>
                    </div>
                </div>
            @endif

            @if (strtolower($category->type) === 'new_members')
                {{-- 🚀 NEW MEMBERS --}}
                <div class="halpha-flex halpha-gap-3">
                    <div class="halpha-text-accent-2">🚀</div>
                    <div>
                        <p class="halpha-text-white halpha-font-semibold text-sm">
                            Most New Team Members — $2,500 Pool
                        </p>
                        <p>
                            Earn rewards by onboarding new users who activate with at least 
                            <span class="halpha-text-gray-200">$200</span>.
                            Only <span class="halpha-text-gray-200">direct referrals</span> count toward ranking.
                        </p>
                    </div>
                </div>
            @endif

            @if (strtolower($category->type) === 'fastest')
                {{-- ⚡ FASTEST --}}
                <div class="halpha-flex halpha-gap-3">
                    <div class="halpha-text-accent-2">⚡</div>
                    <div>
                        <p class="halpha-text-white halpha-font-semibold text-sm">
                            Fastest 7 Activations — $2,500 Pool
                        </p>
                        <p>
                            Be among the fastest to activate 
                            <span class="halpha-text-gray-200">7 direct members</span> with 
                            <span class="halpha-text-gray-200">$500+</span> each.
                            Speed matters — early completion ranks higher.
                        </p>
                    </div>
                </div>
            @endif

        </div>

        <p class="halpha-text-[11px] halpha-text-gray-400 halpha-hidden">
            Compete, climb the ranks, and earn from the pool before the sprint ends.
        </p>

    </div>