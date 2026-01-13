<?php

namespace App\Filament\Resources\Stakes\Pages;

use App\Filament\Resources\Stakes\StakeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStakes extends ListRecords
{
    protected static string $resource = StakeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
