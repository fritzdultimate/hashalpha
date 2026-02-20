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


    public function mount() {
        $this->selectedCategory = ChallengeCategory::first();
        LeaderBoardService::scoreLeaderBoard();
        $this->challenges = Challenge::where('is_active', true)->get();
        $this->loadLeaderboard();

        $this->categories = ChallengeCategory::get();
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
            ->limit(50)
            ->get();

        $this->detectMyRank($category);
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
