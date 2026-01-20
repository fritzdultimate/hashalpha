<?php

namespace App\Livewire\Dashboard;

use App\Models\Reward;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('layouts.app')]
class StakesIndex extends Component {
    use WithPagination;

    public $tab = 'list'; // list | earnings | details
    public $search = '';
    public $filterStatus = '';
    public $perPage = 12;
    public $selectedStakeId = null;
    public $earningsPoints;

    protected $listeners = [
        'openMyStakes' => 'openPanel',
        'refreshStakes' => '$refresh'
    ];

    public function mount($id = null){
        if($id) {
            $this->selectedStakeId = $id;
            $this->tab = 'details';
        }
    }

    public function openPanel() {
        $this->tab = 'list';
        $this->dispatchBrowserEvent('open-stakes-panel');
    }

    #[On('openStakeDetails')]
    public function viewStake($id) {
        $this->selectedStakeId = $id;
        $this->tab = 'details';
    }

    #[On('goBack')]
    public function back($tab) {
        $this->tab = $tab;
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }

    public function exportCsv() {
        $userId = Auth::id();
        $rows = \App\Models\Stake::with('plan')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'plan' => $s->plan->name ?? '',
                    'amount' => $s->amount,
                    'status' => $s->status->value,
                    'started_at' => optional($s->started_at)->toDateTimeString(),
                    'ended_at' => optional($s->ended_at)->toDateTimeString(),
                    'earned' => $s->earned_total ?? 0,
                ];
            });

        $filename = 'stakes_export_'.now()->format('Ymd_His').'.csv';

        return new StreamedResponse(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            if ($rows->count()) {
                fputcsv($handle, array_keys((array) $rows->first()));
                foreach ($rows as $row) fputcsv($handle, (array) $row);
            } else {
                fputcsv($handle, ['id','plan','amount','status','started_at','ended_at','earned']);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function render() {
        $userId = Auth::id();
        $query = \App\Models\Stake::with('plan')->where('user_id', $userId);

        if ($this->filterStatus) $query->where('status', $this->filterStatus);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id', 'like', "%{$this->search}%")
                  ->orWhere('meta->note', 'like', "%{$this->search}%")
                  ->orWhereHas('plan', fn($p)=> $p->where('name','like',"%{$this->search}%"));
            });
        }

        $stakes = $query->latest()->paginate($this->perPage);

        $totalActive = \App\Models\Stake::where('user_id', $userId)->where('status', 'active')->sum('amount');
        $totalClaimable = Reward::where([
            'user_id' => $userId,
            'status' => 'pending',
            'rewards_locked_at' => null,
            'compounded_at' => null
        ])->sum('amount');

        $rewards = Reward::where('user_id', $userId)
            ->where('status', '!=', 'failed')
            ->whereNull('rewards_locked_at')
            ->whereNull('compounded_at')
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at')
            ->get();

        $daily = $rewards
            ->groupBy(fn ($r) => $r->created_at->format('Y-m-d'))
            ->map(fn ($day) => $day->sum('amount'));

        $max = $daily->max() ?: 1;

        $points = collect(range(0, 29))->map(function ($i) use ($daily, $max) {
            $date = now()->subDays(29 - $i)->format('Y-m-d');
            $value = $daily[$date] ?? 0;

            $x = ($i / 29) * 100;
            $y = 30 - (($value / $max) * 30);

            return round($x, 2) . ',' . round($y, 2);
        })->implode(' ');

        $this->earningsPoints = $points;
        // dd($points);

        return view('livewire.dashboard.stakes-index', compact('stakes','totalActive','totalClaimable'));
    }
}
