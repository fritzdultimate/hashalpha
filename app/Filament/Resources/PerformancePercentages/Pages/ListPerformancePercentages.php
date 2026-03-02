<?php

namespace App\Filament\Resources\PerformancePercentages\Pages;

use App\Filament\Resources\PerformancePercentages\PerformancePercentageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPerformancePercentages extends ListRecords
{
    protected static string $resource = PerformancePercentageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
