<?php

namespace App\Livewire\Dashboard\Affiliate;
use App\Models\Challenge;
use App\Models\ChallengeCategory;
use App\Models\ChallengeEntry;
use App\Models\Stake;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Leaderboard extends Component {
    public $activeTab = 'volume';
    public $leaderboard = [];
    public $challenge;
    public $myRank = null;


    public function mount() {
        $this->challenge = Challenge::where('is_active', true)->first();
        $this->loadLeaderboard();
    }

    public function setTab($tab) {
        // dd($tab);
        $this->activeTab = $tab;
        $this->loadLeaderboard();
    }

    public function loadLeaderboard() {
        if (!$this->challenge) return;

        $category = ChallengeCategory::where('challenge_id', $this->challenge->id)
            ->where('type', $this->activeTab)
            ->first();

        if (!$category) return;

        $this->generateScores($category);

        $this->leaderboard = ChallengeEntry::with('user')
            ->where('challenge_category_id', $category->id)
            ->orderBy('rank')
            ->limit(50)
            ->get();

        $this->detectMyRank($category);
    }

    private function generateScores($category){
        $users = User::where('is_suspended', false)->get();

        foreach ($users as $user) {
            $score = 0;
            $completedAt = null;

            // 🥇 VOLUME
            if ($category->type === 'volume') {
                $downline = getDownlineUserIds($user->id);

                $score = Stake::whereIn('user_id', $downline)
                    ->whereBetween('created_at', [$this->challenge->start_at, $this->challenge->end_at])
                    ->sum('amount');
            }

            // 🚀 REFERRALS
            if ($category->type === 'referrals') {
                $score = User::where('referred_by', $user->id)
                    ->whereHas('stakes')
                    ->count();
            }

            if ($category->type === 'fastest') {
                $refs = User::where('referred_by', $user->id)
                    ->whereHas('stakes', fn($q) =>
                        $q->where('amount', '>=', $category->min_amount ?? 500)
                    )
                    ->with(['stakes' => fn($q) => $q->orderBy('created_at')])
                    ->get();

                if ($refs->count() >= 7) {
                    $first7 = $refs->take(7);
                    $completedAt = $first7->max(fn($u) => optional($u->stakes->first())->created_at);
                    $score = 7;
                }
            }

            $entry = ChallengeEntry::updateOrCreate(
                [
                    'challenge_id' => $this->challenge->id,
                    'challenge_category_id' => $category->id,
                    'user_id' => $user->id
                ],
                [
                    'score' => $score,
                    'completed_at' => $completedAt
                ]
            );
        }

        $entries = ChallengeEntry::where('challenge_category_id', $category->id)
            ->orderByDesc('score')
            ->orderBy('completed_at')
            ->get();

        foreach ($entries as $index => $entry) {
            $entry->update(['rank' => $index + 1]);
        }
    }

    private function detectMyRank($category) {
        $entry = ChallengeEntry::where('challenge_category_id', $category->id)
            ->where('user_id', auth()->id())
            ->first();

        $this->myRank = $entry?->rank;
    }

    public function render() {
        return view('livewire.dashboard.affiliate.leaderboard');
    }
}
