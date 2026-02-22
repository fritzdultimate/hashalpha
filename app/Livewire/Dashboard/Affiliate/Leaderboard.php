<?php

namespace App\Livewire\Dashboard\Affiliate;
use App\Models\Challenge;
use App\Models\ChallengeCategory;
use App\Models\ChallengeEntry;
use App\Models\Referral;
use App\Models\Stake;
use App\Models\User;
use App\Services\LeaderBoardService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Leaderboard extends Component {
    public $activeTab = 1;
    public $leaderboard = [];
    public $challenge;
    public $myRank = null;
    public $challenges = [];
    public $categories = [];
    public $selectedCategory = null;

    public $myStats = [];
    public $myReferrals = [];


    public function mount() {
        $this->selectedCategory = ChallengeCategory::first();
        // LeaderBoardService::scoreLeaderBoard();
        $this->challenges = Challenge::where('is_active', true)->get();
        $this->loadLeaderboard();

        $this->categories = ChallengeCategory::get();
    }

    private function loadMyStats($category) {
        $user = auth()->user();

        if (!$user) return;

        $referrals = Referral::where('level_1_id', $user->id)
            ->whereHas('user', function ($q) use ($category) {
                $q->whereBetween('created_at', [
                    $category->challenge->start_at,
                    $category->challenge->end_at
                ]);
            })
            ->with(['user.stakes' => function ($q) use ($category) {
                $q->whereBetween('created_at', [
                    $category->challenge->start_at,
                    $category->challenge->end_at
                ]);
            }])
            ->get();

        // 2. Count referrals
        $refCount = $referrals->count();

        // 3. Sum volume
        $volume = $referrals->sum(function ($ref) {
            return $ref->user
                ? $ref->user->stakes->sum('amount')
                : 0;
        });

        $this->myStats = [
            'referrals' => $refCount,
            'volume' => $volume
        ];
    }

    private function loadMyReferrals($category) {
        $user = auth()->user();

        if (!$user) return;

        $refs = Referral::where('level_1_id', $user->id)
            ->with(['user.stakes' => function ($q) use ($category) {
                $q->whereBetween('created_at', [
                    $category->challenge->start_at,
                    $category->challenge->end_at
                ]);
            }])
            ->whereHas('user', function ($q) use ($category) {
                $q->whereBetween('created_at', [
                    $category->challenge->start_at,
                    $category->challenge->end_at
                ]);
            })
            ->get();

        $this->myReferrals = $refs->map(function ($ref) {
            $volume = $ref->user
                ? $ref->user->stakes->sum('amount')
                : 0;

            return [
                'name' => $ref->user->name ?? 'User',
                'email' => $ref->user->email ?? '',
                'volume' => $volume,
            ];
        })
        ->sortByDesc('volume')
        ->values()
        ->toArray();
    }

    public function setTab($id) {
        $this->activeTab = $id;
        $this->selectedCategory = ChallengeCategory::where('id', $id)->first();
        $this->loadLeaderboard();
    }

    public function loadLeaderboard() {
        if (!$this->selectedCategory) return;

        $category = ChallengeCategory::where('id', $this->selectedCategory->id)
            ->first();

        if (!$category) return;

        $this->leaderboard = ChallengeEntry::with('user')
            ->where('challenge_category_id', $category->id)
            ->orderBy('rank')
            ->limit(10)
            ->get();

        $this->detectMyRank($category);
        $this->loadMyStats($category);
        $this->loadMyReferrals($category);

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
