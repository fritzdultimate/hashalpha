<?php

namespace App\Filament\Resources\Users\Tables;

use App\Services\BalanceService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 👤 USER IDENTITY
                TextColumn::make('name')
                    ->label('User')
                    ->description(fn ($record) => $record->email)
                    ->searchable(['name', 'email'])
                    ->weight('medium')
                    ->color('info')
                    ->icon('heroicon-o-user'),
                TextColumn::make('balance')
                    ->money('usd')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                IconColumn::make('email_verified_at')
                    ->label('Email')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('userRank.rank.name')
                    ->label('Rank')
                    ->badge()
                    ->color(fn ($state) => match (strtolower($state ?? '')) {
                        'bronze' => 'warning',
                        'silver' => 'gray',
                        'gold' => 'amber',
                        'platinum' => 'info',
                        'diamond' => 'success',
                        default => 'secondary',
                    })
                    ->sortable()
                    ->placeholder('Unranked'),

                IconColumn::make('is_suspended')
                    ->label('Suspended')
                    ->boolean()
                    ->trueColor('danger')
                    ->falseColor('success'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->badge(),
                ActionGroup::make([
                    Action::make('topup')
                    ->label('Top Up')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form([
                        TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->minValue(0.0001),

                        Textarea::make('reason')
                            ->label('Reason (optional)'),
                    ])
                    ->requiresConfirmation()
                    ->action(function ($record, array $data) {
                        BalanceService::credit(
                            $record,
                            $data['amount'],
                            $data['reason'] ?? null,
                            auth()->user()
                        );

                        Notification::make()
                            ->title('Balance Updated')
                            ->success()
                            ->send();
                    }),
                    // ->visible(fn () => auth()->user()->hasRole(['super-admin'])),

                Action::make('debit')
                    ->label('Debit')
                    ->icon('heroicon-o-minus-circle')
                    ->color('danger')
                    ->form([
                        TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->minValue(0.0001),

                        Textarea::make('reason')
                            ->required(),
                    ])
                    ->requiresConfirmation()
                    ->action(function ($record, array $data) {
                        BalanceService::debit(
                            $record,
                            $data['amount'],
                            $data['reason'],
                            auth()->user()
                        );

                        Notification::make()
                            ->title('Balance Updated')
                            ->success()
                            ->send();
                    })
                    // ->visible(fn () => auth()->user()->hasRole(['super-admin'])),
                ]),
                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
