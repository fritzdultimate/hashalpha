<?php

namespace App\Filament\Resources\PerformancePercentages\Pages;

use App\Filament\Resources\PerformancePercentages\PerformancePercentageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPerformancePercentage extends EditRecord
{
    protected static string $resource = PerformancePercentageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
