<?php

namespace App\Filament\Resources\CompoundingOffers;

use App\Filament\Resources\CompoundingOffers\Pages\ListCompoundingOffers;
use App\Filament\Resources\CompoundingOffers\Tables\CompoundingOffersTable;
use App\Models\CompoundingOffer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

// Read-only admin visibility into compounding offers. Offers are created
// automatically when a stake matures and are accepted/declined by the user
// themselves -- there is deliberately no admin action here to force one
// onto a user or to override their decision.
class CompoundingOfferResource extends Resource
{
    protected static ?string $model = CompoundingOffer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowPath;

    protected static ?string $navigationLabel = 'Compounding Offers';

    public static function table(Table $table): Table
    {
        return CompoundingOffersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompoundingOffers::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
