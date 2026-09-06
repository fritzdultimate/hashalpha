<?php

namespace App\Filament\Resources\EnhancedVerifications\Pages;

use App\Filament\Resources\EnhancedVerifications\EnhancedVerificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEnhancedVerifications extends ListRecords
{
    protected static string $resource = EnhancedVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
