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
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ProofOfRewards extends Component {
    use WithPagination;

    public $distributedRewards;
    public $lastDistributedAt;
    // public $rewards = [];
    public $cumulativeRewards = '0';
    public $perPage = 10;

    public function mount() {
        $rewards = ValidatorReward::where('status', 'distributed');
        $this->distributedRewards = $rewards->sum('amount');
        $this->lastDistributedAt = $rewards->latest()->first();

        $latestReward = $rewards->latest('updated_at')->first();
        $this->lastDistributedAt = $latestReward
            ? Carbon::parse($latestReward->updated_at)->format('M d, Y • h:i A')
            : 'No rewards distributed yet';

        $allRewards = ValidatorReward::orderBy('created_at', 'desc')->get();

        $this->cumulativeRewards = number_format(
            $allRewards->sum('amount'),
            8
        );
    }

    public function render() {
        $paginatedRewards = ValidatorReward::orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $rewards = $paginatedRewards->getCollection()->map(function ($reward) {
            return [
                'id' => $reward->id,
                'amount' => number_format($reward->amount, 8),
                'status' => ucfirst($reward->status),
                'source' => $reward->source,
                'created_at' => Carbon::parse($reward->created_at)->format('M d, Y • h:i A'),
                'distributed_at' => $reward->distributed_at
                    ? Carbon::parse($reward->distributed_at)->format('M d, Y • h:i A')
                    : null,
            ];
        });

        $paginatedRewards->setCollection($rewards);
        return view('livewire.dashboard.transparency.proof-of-rewards', [
            'rewards' => $paginatedRewards,
        ]);
    }
}
