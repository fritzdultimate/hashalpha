<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EarningsChart extends Component {
    public string $range = '30d';
    public array $labels = [];
    public array $usdData = [];

    public function mount(string $range = '30d') {
        $this->range = $range;
        $this->loadData();
    }

    public function updatedRange($val) {
        $this->range = $val;
        $this->loadData();
    }

    public function loadData() {
        $userId = auth()->id();

        $start = match($this->range) {
            '7d' => Carbon::now()->subDays(6),
            '30d' => Carbon::now()->subDays(29),
            '90d' => Carbon::now()->subDays(89),
            '365d' => Carbon::now()->subDays(364),
            default => Carbon::now()->subDays(29),
        };

        // Aggregate by day (if long ranges you may want weekly/monthly)
        $rows = DB::table('rewards')
            ->selectRaw('DATE(created_at) as day, SUM(amount) as usd')
            ->where('user_id', $userId)
            ->where('created_at', '>=', $start->startOfDay())
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get()
            ->keyBy('day');

        // Build continuous labels between start and today
        $labels = [];
        $usdData = [];

        $period = \Carbon\CarbonPeriod::create($start->startOfDay(), Carbon::now()->startOfDay());

        foreach ($period as $dt) {
            $d = $dt->format('Y-m-d');
            $labels[] = $dt->format('d M');
            $usdData[] = isset($rows[$d]) ? (float) $rows[$d]->usd : 0.0;
        }

        $this->labels = $labels;
        $this->usdData = $usdData;

        // push to frontend
        $this->dispatch('earningsUpdated', [
            'labels' => $this->labels,
            'usd' => $this->usdData,
            'range' => $this->range,
        ]);
    }

    public function render() {
        return view('livewire.dashboard.earnings-chart');
    }
}
