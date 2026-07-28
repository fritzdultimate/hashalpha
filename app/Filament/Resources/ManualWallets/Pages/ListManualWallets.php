<?php

namespace App\Filament\Resources\ManualWallets\Pages;

use App\Filament\Resources\ManualWallets\ManualWalletResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListManualWallets extends ListRecords
{
    protected static string $resource = ManualWalletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
