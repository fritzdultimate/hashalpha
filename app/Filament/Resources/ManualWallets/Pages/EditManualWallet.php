<?php

namespace App\Filament\Resources\ManualWallets\Pages;

use App\Filament\Resources\ManualWallets\ManualWalletResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditManualWallet extends EditRecord
{
    protected static string $resource = ManualWalletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
