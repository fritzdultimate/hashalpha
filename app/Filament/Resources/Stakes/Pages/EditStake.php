<?php

namespace App\Filament\Resources\Stakes\Pages;

use App\Filament\Resources\Stakes\StakeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStake extends EditRecord
{
    protected static string $resource = StakeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
