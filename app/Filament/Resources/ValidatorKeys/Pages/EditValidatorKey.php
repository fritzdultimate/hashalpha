<?php

namespace App\Filament\Resources\ValidatorKeys\Pages;

use App\Filament\Resources\ValidatorKeys\ValidatorKeyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditValidatorKey extends EditRecord
{
    protected static string $resource = ValidatorKeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
