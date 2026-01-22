<?php

namespace App\Filament\Resources\ValidatorKeys;

use App\Filament\Resources\ValidatorKeys\Pages\CreateValidatorKey;
use App\Filament\Resources\ValidatorKeys\Pages\EditValidatorKey;
use App\Filament\Resources\ValidatorKeys\Pages\ListValidatorKeys;
use App\Filament\Resources\ValidatorKeys\Schemas\ValidatorKeyForm;
use App\Filament\Resources\ValidatorKeys\Tables\ValidatorKeysTable;
use App\Models\ValidatorKey;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ValidatorKeyResource extends Resource
{
    protected static ?string $model = ValidatorKey::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    public static function form(Schema $schema): Schema
    {
        return ValidatorKeyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ValidatorKeysTable::configure($table);
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
            'index' => ListValidatorKeys::route('/'),
            'create' => CreateValidatorKey::route('/create'),
            'edit' => EditValidatorKey::route('/{record}/edit'),
        ];
    }
}
