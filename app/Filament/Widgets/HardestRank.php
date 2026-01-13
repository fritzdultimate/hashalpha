<?php

namespace App\Filament\Widgets;

use App\Models\Rank;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HardestRank extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $rank = Rank::orderByDesc('required_volume')->first();

        return [
            Stat::make(
                'Hardest Rank',
                $rank?->name ?? '—'
            )
            ->description('Highest volume requirement')
            ->icon('heroicon-o-fire')
            ->color('danger'),
        ];
    }
}
