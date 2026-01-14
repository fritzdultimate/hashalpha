<div class="grid halpha-grid-cols-1 md:halpha-grid-cols-2 xl:halpha-grid-cols-4 halpha-gap-4">

    {{-- Balance --}}
    <x-filament::card>
        <div class="text-sm text-gray-500">Balance</div>
        <div class="text-2xl font-bold text-success">
            {{ number_format($user->balance, 2) }}
        </div>
    </x-filament::card>

    {{-- Rank --}}
    <x-filament::card>
        <div class="text-sm text-gray-500">Rank</div>
        <div class="text-lg font-semibold">
            {{ $user->userRank?->rank?->name ?? 'Unranked' }}
        </div>

        @if($user->userRank)
            <div class="text-xs text-gray-400">
                Since {{ $user->userRank->achieved_at?->diffForHumans() }}
            </div>
        @endif
    </x-filament::card>

    {{-- KYC --}}
    <x-filament::card>
        <div class="text-sm text-gray-500">KYC Status</div>

        <x-filament::badge
            :color="match ($user->kyc_status) {
                'approved' => 'success',
                'pending' => 'warning',
                'rejected' => 'danger',
                default => 'gray',
            }"
        >
            {{ strtoupper($user->kyc_status ?? 'N/A') }}
        </x-filament::badge>
    </x-filament::card>

    {{-- Account --}}
    <x-filament::card>
        <div class="text-sm text-gray-500">Account</div>

        <x-filament::badge :color="$user->is_suspended ? 'danger' : 'success'">
            {{ $user->is_suspended ? 'Suspended' : 'Active' }}
        </x-filament::badge>

        <div class="mt-2 flex flex-wrap gap-2">
            @if($user->two_factor_enabled)
                <x-filament::badge color="info">2FA</x-filament::badge>
            @endif

            @if($user->email_verified_at)
                <x-filament::badge color="success">Email Verified</x-filament::badge>
            @endif
        </div>
    </x-filament::card>

</div>
