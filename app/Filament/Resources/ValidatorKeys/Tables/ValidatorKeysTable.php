<?php

namespace App\Filament\Resources\ValidatorKeys\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ValidatorKeysTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('public_key')->searchable()->limit(40),
                TextColumn::make('validator_index')->sortable(),
                TextColumn::make('label')->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending',
                        'danger' => 'offline',
                        'danger' => 'slashed',
                    ]),
                TextColumn::make('last_reported_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
