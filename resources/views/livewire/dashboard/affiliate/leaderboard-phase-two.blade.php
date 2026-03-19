<div class="halpha-space-y-6">

    <x-leaderboard.phase-header
        :prizePool="$prizePool"
    />

    <x-leaderboard.tabs 
        :categories="$categories"
        :activeTab="$activeTab"
    />

    <x-leaderboard.description
        :category="$selectedCategory"
    />

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