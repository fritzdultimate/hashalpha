<?php

namespace App\Filament\Resources\ValidatorKeys\Schemas;

use App\Models\ValidatorKey;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ValidatorKeyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('public_key')
                    ->label('Public Key')
                    ->required()
                    ->unique(ValidatorKey::class, 'public_key', ignoreRecord: true)
                    ->disabled(fn($livewire, $record) => $record !== null),

                TextInput::make('validator_index')
                    ->label('Validator Index')
                    ->numeric(),

                TextInput::make('label')
                    ->label('Label')
                    ->maxLength(255),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'pending' => 'Pending',
                        'offline' => 'Offline',
                        'slashed' => 'Slashed',
                    ])
                    ->required(),

                DateTimePicker::make('last_reported_at')
                    ->label('Last Reported At'),
            ]);
    }
}
