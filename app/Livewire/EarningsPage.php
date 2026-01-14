<?php

namespace App\Livewire;

use App\Enums\RewardStatus;
use App\Enums\StakeStatus;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reward;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class EarningsPage extends Component
{
    use WithPagination;

    public $perPage = 12;
    public $filter = ''; // 'all' | 'claimable' | 'claimed'
    public $search = '';
    public $loading = true;

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refreshEarnings' => '$refresh'];

    public function mount() {
        $this->loadData();
    }

    public function isCompoundable(Reward $reward): bool {
        if ($reward->status !== RewardStatus::PENDING) {
            return false;
        }

        $stake = $reward->stake;
        if (! $stake) {
            return false;
        }


        // if ($stake->status !== StakeStatus::ACTIVE) {
        //     return false;
        // }

        if ($stake->ended_at && now()->greaterThanOrEqualTo($stake->ended_at)) {
            return false;
        }

        // Optional: lock / claimable date
        if ($reward->claimable_at && now()->lessThan($reward->claimable_at)) {
            return false;
        }

        return true;
    }


    public function updatedFilter() {
        $this->resetPage();
    }

    public function loadData() {
        $this->loading = true;
        $this->loading = false;
    }

    public function getQuery() {
        $q = Reward::query()->with(['fromUser'])
            ->where('user_id', auth()->id());

        if ($this->filter === 'claimable') {
            $q->where('status', 'pending'); // assume pending = claimable
        } elseif ($this->filter === 'claimed') {
            $q->where('status', 'claimed');
        }

        if (!empty($this->search)) {
            $q->where(function ($sub) {
                $sub->where('stake_id', 'like', '%' . $this->search . '%')
                    ->orWhere('reward_type', 'like', '%' . $this->search . '%')
                    ->orWhere('amount', 'like', '%' . $this->search . '%')
                    ->orWhere('level', 'like', '%' . $this->search . '%');
            });
        }

        return $q->orderBy('credited_at', 'desc');
    }

    public function claimAll() {
        $user = auth()->user();

        $pendingRewards = $user->rewards()->where('status', 'pending')->get();

        if ($pendingRewards->isEmpty()) {
            $this->dispatch('toast', payload: [
                'message' => 'No claimable rewards.',
                'timeout' => 5000,
                'variant' => 'subtle'
            ]);
            return;
        }

        DB::transaction(function () use ($user, $pendingRewards) {
            $totalClaim = $pendingRewards->sum('amount');

            foreach ($pendingRewards as $reward) {
                $reward->status = 'claimed';
                $reward->save();
            }

            $user->balance = bcadd($user->balance, (string) $totalClaim, 8);
            $user->save();

            // Optionally create a Transaction record if you track them
        });

        $this->dispatch('toast', payload: [
            'message' => 'Claimed all rewards.',
            'timeout' => 5000,
        ]);

        // $this->emit('refreshEarnings');
    }

    public function render() {
        $query = $this->getQuery();
        $earnings = $query->paginate($this->perPage);

        // summary totals
        $totalEarned = Reward::where('user_id', auth()->id())
            ->sum('amount');

        $totalClaimed = Reward::where('user_id', auth()->id())
            ->where('status', 'claimed')
            ->sum('amount');

        $withdrawable = Reward::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->sum('amount');

        return view('livewire.earnings-page', [
            'earnings' => $earnings,
            'totalEarned' => $totalEarned,
            'totalClaimed' => $totalClaimed,
            'withdrawable' => $withdrawable,
        ]);
    }

    public function compoundProfit($id) {
        $earning = Reward::find($id);
        if(! $earning) {
            return ;
        }

        if($earning->status !== RewardStatus::PENDING) {
            $this->dispatch('toast', payload: [
                'message' => "This reward has already been {$earning->status->value}",
                'timeout' => 5000,
                'type' => 'error'
            ]);
            return ;
        }

        $stake = $earning->stake;

        if (! $stake) {
            return;
        }

        DB::transaction(function () use ($earning, $stake) {

            $stake->update([
                'amount' => bcadd(
                    (string) $stake->amount,
                    (string) $earning->amount,
                    8
                ),
                'compounding' => true,
            ]);

            $earning->update([
                'status' => RewardStatus::COMPOUNDED,
                'compounded_at' => now(),
            ]);

            $this->dispatch('toast', payload: [
                'message' => 'Reward successfully compounded',
                'timeout' => 5000,
                'type' => 'success'
            ]);
            $this->dispatch('$refresh');
        });

        // send email

        


    }
}
