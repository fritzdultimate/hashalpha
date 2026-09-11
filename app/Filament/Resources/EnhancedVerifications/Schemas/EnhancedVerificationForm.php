<?php

namespace App\Filament\Resources\EnhancedVerifications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;

class EnhancedVerificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('proof_of_funds_document')
                    ->label('Trading Document')
                    ->disabled()
                    ->disk('local')
                    ->downloadable(),
                FileUpload::make('additional_document')
                    ->label('Statement of Account')
                    ->disabled()
                    ->disk('local')
                    ->downloadable(),
                Textarea::make('notes')->disabled(),
                BadgeColumn::make('status')->disabled(),
                Textarea::make('admin_note'),
                TextInput::make('certificate_number')->disabled(),
                DateTimePicker::make('reviewed_at')->disabled(),
            ]);
    }
}
