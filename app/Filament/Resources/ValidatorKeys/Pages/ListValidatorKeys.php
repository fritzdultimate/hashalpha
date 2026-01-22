<?php

namespace App\Filament\Resources\ValidatorKeys\Pages;

use App\Filament\Resources\ValidatorKeys\ValidatorKeyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListValidatorKeys extends ListRecords
{
    protected static string $resource = ValidatorKeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
