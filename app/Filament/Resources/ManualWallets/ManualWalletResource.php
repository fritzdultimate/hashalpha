<?php

namespace App\Filament\Resources\ManualWallets;

use App\Filament\Resources\ManualWallets\Pages\CreateManualWallet;
use App\Filament\Resources\ManualWallets\Pages\EditManualWallet;
use App\Filament\Resources\ManualWallets\Pages\ListManualWallets;
use App\Filament\Resources\ManualWallets\Schemas\ManualWalletForm;
use App\Filament\Resources\ManualWallets\Tables\ManualWalletsTable;
use App\Models\ManualWallet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ManualWalletResource extends Resource
{
    protected static ?string $model = ManualWallet::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ManualWalletForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ManualWalletsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListManualWallets::route('/'),
            'create' => CreateManualWallet::route('/create'),
            'edit' => EditManualWallet::route('/{record}/edit'),
        ];
    }
}
