@if($category->type === 'fastest' && collect($leaderboard)->where('score', '>=', 7)->count() > 2)
    <div
        class="halpha-bg-green-500/10 halpha-border halpha-border-green-400/30 halpha-rounded-lg halpha-p-3 halpha-text-center">
        <p class="halpha-text-green-500 halpha-font-semibold halpha-text-sm">
            🏁 We have the winners! Fastest 7 completed
        </p>
    </div>
@endif