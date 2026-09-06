<?php

namespace App\Filament\Resources\CompoundingOffers\Tables;

use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CompoundingOffersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->searchable(),
                TextColumn::make('stake_id')->label('Source Stake')->formatStateUsing(fn ($state) => "#stk{$state}"),
                TextColumn::make('min_roi')->label('Min ROI')->suffix('%'),
                TextColumn::make('max_roi')->label('Max ROI')->suffix('%'),
                TextColumn::make('duration_days')->label('Term')->suffix(' days'),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'offered',
                        'success' => 'accepted',
                        'gray' => 'declined',
                        'danger' => 'expired',
                    ])
                    ->formatStateUsing(fn ($state) => $state instanceof \App\Enums\CompoundingOfferStatus ? $state->label() : ucfirst((string) $state)),
                TextColumn::make('offered_at')->dateTime()->sortable(),
                TextColumn::make('expires_at')->dateTime()->sortable(),
                TextColumn::make('responded_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'offered' => 'Offered',
                        'accepted' => 'Accepted',
                        'declined' => 'Declined',
                        'expired' => 'Expired',
                    ]),
            ])
            ->defaultSort('offered_at', 'desc');
    }
}
