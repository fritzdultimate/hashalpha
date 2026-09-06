<?php

namespace App\Filament\Resources\CompoundingOffers\Pages;

use App\Filament\Resources\CompoundingOffers\CompoundingOfferResource;
use Filament\Resources\Pages\ListRecords;

class ListCompoundingOffers extends ListRecords
{
    protected static string $resource = CompoundingOfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
