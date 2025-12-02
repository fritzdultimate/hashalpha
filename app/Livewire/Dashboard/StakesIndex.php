<?php

namespace App\Livewire\Dashboard;

use Livewire\Attributes\Layout;
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

    protected $listeners = [
        'openMyStakes' => 'openPanel',
        'refreshStakes' => '$refresh'
    ];

    public function mount()
    {
        //
    }

    public function openPanel() {
        // toggle to list tab and expose browser event so front-end can show panel
        $this->tab = 'list';
        $this->dispatchBrowserEvent('open-stakes-panel');
    }

    public function viewStake($id)
    {
        $this->selectedStakeId = $id;
        $this->tab = 'details';
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }

    public function exportCsv()
    {
        $userId = Auth::id();
        $rows = \App\Models\Stake::with('plan')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'plan' => $s->plan->name ?? '',
                    'amount' => $s->amount,
                    'status' => $s->status,
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

    public function render()
    {
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
        $totalEarned = \App\Models\Stake::where('user_id', $userId)->sum('earned_total');

        return view('livewire.dashboard.stakes-index', compact('stakes','totalActive','totalEarned'));
    }
}
