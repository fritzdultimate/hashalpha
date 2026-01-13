<?php

namespace App\Filament\Widgets;

use App\Models\Rank;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RecentlyUpdatedRank extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $rank = Rank::latest('updated_at')->first();

        return [
            Stat::make(
                'Last Updated Rank',
                $rank?->name ?? '—'
            )
            ->description($rank?->updated_at?->diffForHumans())
            ->icon('heroicon-o-clock')
            ->color('gray'),
        ];
    }
}
