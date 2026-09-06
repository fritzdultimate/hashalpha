<?php

namespace App\Filament\Resources\EnhancedVerifications\Pages;

use App\Filament\Resources\EnhancedVerifications\EnhancedVerificationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEnhancedVerification extends EditRecord
{
    protected static string $resource = EnhancedVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
