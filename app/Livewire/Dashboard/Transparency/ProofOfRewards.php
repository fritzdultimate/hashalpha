<?php

namespace App\Livewire\Dashboard\Transparency;

use App\Models\Stake;
use App\Models\StakingPlan;
use App\Models\ValidatorReward;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class ProofOfRewards extends Component {

    public $distributedRewards;
    public $lastDistributedAt;

    public function mount() {
        $rewards = ValidatorReward::where('status', 'distributed');
        $this->distributedRewards = $rewards->sum('amount');
        $this->lastDistributedAt = $rewards->latest()->first();

        $latestReward = $rewards->latest('updated_at')->first();
        $this->lastDistributedAt = $latestReward
            ? Carbon::parse($latestReward->updated_at)->format('M d, Y • h:i A')
            : 'No rewards distributed yet';
    }

    public function render() {
        return view('livewire.dashboard.transparency.proof-of-rewards');
    }
}
