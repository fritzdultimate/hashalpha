<?php

namespace App\Filament\Resources\ManualWallets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ManualWalletForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('currency')
                        ->required()
                        // ->disabled()
                        ->dehydrated(),
                    TextInput::make('label')
                        ->required(),
                    TextInput::make('network'),
                        // ->required(),
                    TextInput::make('address')
                        ->required()
                        ->dehydrated(),
                    Toggle::make('is_active')
                        ->label('Enable'),
                ]),
            ]);
    }
}
