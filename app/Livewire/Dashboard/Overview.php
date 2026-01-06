<?php


namespace App\Livewire\Dashboard;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.app')]
class Overview extends Component
{
    public $totalDeposited = 0;
    public $totalEarnings = 0;
    public $activeStakes = 0;
    public $balance;
    public $totalEarned;
    public $totalEarnedDelta;
    public $chartData;
    public $dailyEstimatedReward;


    public function mount()
    {
        $user = Auth::user();
        $userId = auth()->id();
        $this->totalDeposited = (float) ($user->deposits()->sum('amount') ?? 0);
        $this->totalEarnings = (float) ($user->transactions()->where('type', 'credit')->sum('amount') ?? 0);
        $this->activeStakes = (int) ($user->stakes()->count() ?? 0);
        $this->balance = $user->balance;

        $this->totalEarned = Cache::remember(
            "user:{$userId}:total_earned",
            300,
            function () use ($userId) {
                return DB::table('rewards')
                    ->where('user_id', auth()->id())
                    ->where('reward_type', 'staking')
                    ->sum('amount');
            }
        );

        $dailyRewards = Cache::remember(
            "user:{$userId}:daily_rewards",
            300, // 5 minutes
            function () use ($userId) {

                return DB::table('rewards')
                    ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
                    ->where('user_id', $userId)
                    ->where('created_at', '>=', now()->subDays(12))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
            }
        );

        $this->chartData = $dailyRewards->pluck('total')->map(fn($v) => round($v, 2));

        $dailyEstimatedReward = DB::table('stakes as s')
            ->join('staking_plans as p', 's.plan_id', '=', 'p.id')
            ->where('s.user_id', $userId)
            ->where('s.status', 'active')
            ->selectRaw('SUM(s.amount * p.daily_roi / 100) as daily_reward')
            ->value('daily_reward');

        
        $this->dailyEstimatedReward = $dailyEstimatedReward ? round($dailyEstimatedReward, 2) : 0;


        $currentRewards = DB::table('rewards')
            ->where('user_id', $userId)
            // ->where('reward_type', 'staking')
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('amount');

        $previousRewards = DB::table('rewards')
            ->where('user_id', $userId)
            // ->where('reward_type', 'staking')
            ->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])
            ->sum('amount');

        $this->totalEarnedDelta = $previousRewards > 0 ? round((($currentRewards - $previousRewards) / $previousRewards) * 100, 2) : null;
    }


    public function render()
    {
        return view('livewire.dashboard.overview');
    }
}