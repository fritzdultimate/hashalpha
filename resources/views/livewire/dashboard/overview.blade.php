<div>
    <h1 class="text-2xl font-bold mb-4">Dashboard Overview</h1>
    <div class="grid grid-cols-3 gap-4">
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-semibold">Total Deposited</h2>
            <p class="text-lg">${{ number_format($totalDeposited, 2) }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-semibold">Total Earnings</h2>
            <p class="text-lg">${{ number_format($totalEarnings, 2) }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-semibold">Active Stakes</h2>
            <p class="text-lg">{{ $activeStakes }}</p>
        </div>
    </div>
</div>
