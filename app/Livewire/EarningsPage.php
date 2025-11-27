<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
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
    protected $listeners = ['refreshEarnings' => 'loadData', 'stakeCreated' => 'loadData'];

    public function mount()
    {
        $this->loadData();
    }

    public function updatedFilter()
    {
        $this->resetPage();
        $this->loadData();
    }

    public function loadData()
    {
        // keep a tiny flag for skeletons
        $this->loading = true;
        $this->dispatch('aria-live', ['message' => 'Loading earnings']);
        $this->resetPage();
        // will be fetched in render for pagination correctness
        $this->loading = false;
    }

    public function getQuery()
    {
        $q = Transaction::query()
            ->where('user_id', auth()->id())
            // only earnings-related types
            ->whereIn('type', ['stake_reward','stake_reward_claim','stake_compound']);

        if ($this->filter === 'claimable') {
            // we'll prefer to show transactions representing claimable rewards:
            // we assume 'stake_reward' increases withdrawable and 'stake_reward_claim' moves to user balance
            $q->where('type', 'stake_reward');
        } elseif ($this->filter === 'claimed') {
            $q->where('type', 'stake_reward_claim');
        }

        if (!empty($this->search)) {
            $q->where(function($sub) {
                $sub->where('meta->stake_id', 'like', '%'.$this->search.'%')
                    ->orWhere('meta->plan_id', 'like', '%'.$this->search.'%')
                    ->orWhere('type', 'like', '%'.$this->search.'%');
            });
        }

        return $q->orderBy('created_at', 'desc');
    }

    /**
     * Claim all withdrawable rewards across stakes (aggregated)
     */
    public function claimAll()
    {
        $user = auth()->user();

        // sum withdrawable across user's active stakes
        $sum = $user->stakes()->where('status','active')->sum('withdrawable_decimal');

        if (bccomp((string)$sum, '0', 8) <= 0) {
            $this->dispatchBrowserEvent('toast', ['message' => 'No rewards available to claim']);
            return;
        }

        DB::transaction(function() use ($user, $sum) {
            // lock user row
            $u = $user->lockForUpdate()->first();
            $before = $u->balance_decimal;
            $after = bcadd($before, (string)$sum, 8);
            $u->balance_decimal = $after;
            $u->save();

            // zero withdrawable on all stakes and record transactions per stake
            $stakes = $u->stakes()->where('status','active')->lockForUpdate()->get();
            foreach ($stakes as $stake) {
                if (bccomp($stake->withdrawable_decimal, '0', 8) > 0) {
                    $amt = $stake->withdrawable_decimal;
                    $stake->withdrawable_decimal = '0';
                    $stake->save();

                    Transaction::create([
                        'user_id' => $u->id,
                        'type' => 'stake_reward_claim',
                        'txable_id' => $stake->id,
                        'txable_type' => get_class($stake),
                        'amount_decimal' => $amt,
                        'balance_before_decimal' => $before,
                        'balance_after_decimal' => $after,
                        'meta' => ['stake_id' => $stake->id]
                    ]);
                }
            }
        });

        $this->dispatchBrowserEvent('toast', ['message' => 'All available rewards claimed']);
        $this->emit('refreshEarnings');
        $this->emit('refreshDashboard');
    }

    public function render()
    {
        $query = $this->getQuery();

        $earnings = $query->paginate($this->perPage);

        // summary aggregates (fast)
        $totalEarned = Transaction::where('user_id', auth()->id())
            ->where('type','stake_reward')
            ->sum('amount_decimal');

        $totalClaimed = Transaction::where('user_id', auth()->id())
            ->where('type','stake_reward_claim')
            ->sum('amount_decimal');

        // compute total withdrawable for quick CTA
        $withdrawable = auth()->user()->stakes()->where('status','active')->sum('withdrawable_decimal');

        return view('livewire.earnings-page', [
            'earnings' => $earnings,
            'totalEarned' => $totalEarned,
            'totalClaimed' => $totalClaimed,
            'withdrawable' => $withdrawable,
        ]);
    }
}
