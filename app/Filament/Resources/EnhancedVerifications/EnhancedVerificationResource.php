<?php

namespace App\Filament\Resources\EnhancedVerifications;

use App\Filament\Resources\EnhancedVerifications\Pages\CreateEnhancedVerification;
use App\Filament\Resources\EnhancedVerifications\Pages\EditEnhancedVerification;
use App\Filament\Resources\EnhancedVerifications\Pages\ListEnhancedVerifications;
use App\Filament\Resources\EnhancedVerifications\Schemas\EnhancedVerificationForm;
use App\Filament\Resources\EnhancedVerifications\Tables\EnhancedVerificationsTable;
use App\Models\EnhancedVerification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EnhancedVerificationResource extends Resource
{
    protected static ?string $model = EnhancedVerification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $navigationLabel = 'Enhanced Verification';

    public static function form(Schema $schema): Schema
    {
        return EnhancedVerificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EnhancedVerificationsTable::configure($table);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) EnhancedVerification::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
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
            'index' => ListEnhancedVerifications::route('/'),
            'create' => CreateEnhancedVerification::route('/create'),
            'edit' => EditEnhancedVerification::route('/{record}/edit'),
        ];
    }
}
