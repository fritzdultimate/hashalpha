<?php


namespace App\Livewire\Dashboard;


use App\Models\Deposit;
use App\Models\Rank;
use App\Models\ReferralReward;
use App\Models\User;
use App\Models\ValidatorBlock;
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
    public $earningchartData;
    public $totalReferralBonus;
    public $totalReferralDelta;
    public $referralRewardschartData;
    public $rank;
    public $validatedBlocks = 129392;

    public function loadValidatorBlocks() {
        $this->validatedBlocks = $this->validatedBlocks + ValidatorBlock::count();
    }

    public function mount() {
        $user = Auth::user();
        $userId = auth()->id();
        $this->totalDeposited = (float) ($user->deposits()->sum('amount') ?? 0);
        $this->totalEarnings = (float) ($user->transactions()->where('type', 'credit')->sum('amount') ?? 0);
        $this->activeStakes = (int) ($user->stakes()->count() ?? 0);

        $rank = Rank::orderBy('level')->first();

        $this->rank = $user->rank?->name ?? $rank->name;
        $this->loadValidatorBlocks();


        $dailyRewards = Cache::remember(
            "user:{$userId}:daily_rewards",
            300,
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

        $dailyEstimatedReward = $user->stakes()
            ->where('status', 'active')
            ->with('plan')
            ->get()
            ->sum(function ($stake) {
                return bcmul(
                    $stake->amount,
                    bcdiv($stake->plan->daily_roi, '100', 8),
                    8
                );
            });


        $this->dailyEstimatedReward = $dailyEstimatedReward ? round($dailyEstimatedReward, 2) : 0;

        // Second card on overview
        $this->totalEarned = Cache::remember(
            "user:{$userId}:total_earned",
            300,
            function () use ($userId) {
                return DB::table('rewards')
                    ->where('user_id', auth()->id())
                    ->where('reward_type', 'staking')
                    ->where('status', 'claimed')
                    ->sum('amount');
            }
        );

        $currentRewards = DB::table('rewards')
            ->where('user_id', $userId)
            ->where('reward_type', 'staking')
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('amount');

        $previousRewards = DB::table('rewards')
            ->where('user_id', $userId)
            ->where('reward_type', 'staking')
            ->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])
            ->sum('amount');

        $this->totalEarnedDelta = $previousRewards > 0 ? round((($currentRewards - $previousRewards) / $previousRewards) * 100, 2) : null;

        $earnings = Cache::remember(
            "user:{$userId}:last_12_rewards",
            300,
            function () use ($userId) {
                return DB::table('rewards')
                    ->where('user_id', $userId)
                    ->orderByDesc('created_at')
                    ->limit(12)
                    ->get(['amount', 'created_at', 'level', 'reward_type', 'stake_id', 'source_user_id']);
            }
        );

        $this->earningchartData = $earnings->pluck('amount')->map(fn($v) => round($v, 2));

        // Referral Bonus Section
        $this->totalReferralBonus = Cache::remember(
            "user:{$userId}:total_referral_bonus",
            300,
            function () use ($userId) {

                return ReferralReward::where('user_id', $userId)->where('status', 'pending')->sum('amount');
            }
        );

        $currentReferrals = DB::table('referral_rewards')
            ->where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('amount');

        $previousReferrals = DB::table('referral_rewards')
            ->where('user_id', $userId)
            ->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])
            ->sum('amount');

        $this->totalReferralDelta = $previousReferrals > 0 ? round((($currentReferrals - $previousReferrals) / $previousReferrals) * 100, 2) : null;

        $referral_rewards = Cache::remember(
            "user:{$userId}:last_12_referrals_reward",
            300,
            function () use ($userId) {
                return DB::table('referral_rewards')
                    ->where('user_id', $userId)
                    ->where('status', '!=', 'fail')
                    ->orderByDesc('created_at')
                    ->limit(12)
                    ->get(['amount']);
            }
        );

        $bonusAvailable = Deposit::where('user_id', $user->id)
            ->where('status', 'finished')
            ->sum('bonus');
        $mainBalance = $user->balance + $this->totalReferralBonus + $bonusAvailable;
        $this->balance = $mainBalance;

        $this->referralRewardschartData = $referral_rewards->pluck('amount')->map(fn($v) => round($v, 2));
    }


    public function render()
    {
        return view('livewire.dashboard.overview');
    }
}