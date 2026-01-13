<?php

namespace App\Filament\Resources\Wallets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WalletForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required(),
                TextInput::make('address'),
                TextInput::make('xpub'),
                TextInput::make('derivation_index')
                    ->numeric(),
                TextInput::make('balance')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('pending_balance')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
