<div class="halpha-space-y-6">

    <x-leaderboard.phase-header
        :prizePool="$prizePool"
    />

    <x-leaderboard.sprint-two-preparation />

    <x-leaderboard.tabs 
        :categories="$categories"
        :activeTab="$activeTab"
    />

    <x-leaderboard.description
        :category="$selectedCategory"
    />

    <div class="halpha-mt-4 halpha-text-center">
        <p class="halpha-text-xs halpha-text-yellow-400 halpha-bg-yellow-400/10 halpha-border halpha-border-yellow-400/20 halpha-rounded-lg halpha-p-3">
            ⚠️ Travel rewards are not cumulative. Participants qualifying through multiple pathways will receive only the highest applicable travel reward.
        </p>
    </div>

    <x-leaderboard.leaderboard-winners 
        :category="$selectedCategory"
        :leaderboard="$leaderboard"
    />

    <x-leaderboard.my-rank
        :myRank="$myRank"
    />

    <x-leaderboard.my-stats
        :stats="$myStats"
    />

    <x-leaderboard.my-referrals
        :referrals="$myReferrals"
    />

    <x-leaderboard.timer
        :end="$selectedCategory->challenge->end_at"
    />

    <x-leaderboard.milestones 
        :currentVolume="$currentVolume" 
        :milestones="$milestones" 
    />

    <x-leaderboard.qualifications 
        :qualifications="$qualifications"
        :currentTeamVolume="$currentVolume"
        :currentPersonalVolume="$personalVolume"
    />

    <x-leaderboard.podium
        :leaderboard="$leaderboard"
        :category="$selectedCategory"
    />

    <x-leaderboard.leaderboard-table
        :leaderboard="$leaderboard"
        :category="$selectedCategory"
    />

</div>