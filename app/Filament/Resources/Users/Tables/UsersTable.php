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
use Illuminate\Support\Facades\Auth;

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
                    ->money('usd', 0, null, 4)
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
                IconColumn::make('lock_roi')
                    ->label('ROI Lock')
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-lock-open')
                    ->trueColor('danger')
                    ->falseColor('success'),
                TextColumn::make('rank.rank.name')
                    ->label('Rank')
                    ->badge()
                    ->color(fn ($state) => match (strtolower($state ?? '')) {
                        'bronze' => 'warning',
                        'silver' => 'gray',
                        'gold' => 'amber',
                        'platinum' => 'info',
                        'diamond' => 'success',
                        default => 'gray',
                    })
                    ->sortable()
                    ->placeholder('Unranked'),

                IconColumn::make('is_suspended')
                    ->label('Suspended')
                    ->boolean()
                    ->trueColor('danger')
                    ->falseColor('success'),
                IconColumn::make('is_leader')
                    ->label('Leader')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->badge(),
                ActionGroup::make([
                    Action::make('impersonate')
                        ->label('Login as user')
                        ->icon('heroicon-o-arrow-right-on-rectangle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn () => auth()->user()?->isAdmin())
                        ->action(function ($record) {

                            abort_unless(auth()->user()->isAdmin(), 403);

                            // Prevent impersonating other admins
                            if ($record->isAdmin()) {
                                throw new \Exception('You cannot impersonate another admin.');
                            }

                            session([
                                'impersonator_id' => auth()->id(),
                            ]);

                            Auth::login($record);
                            session()->regenerate();

                            return redirect('/dashboard');
                        }),

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

                    Action::make('leaderboard_payment')
                        ->label('Leaderbd Bonus')
                        ->icon('heroicon-o-plus-circle')
                        ->color('success')
                        ->form([
                            TextInput::make('amount')
                                ->numeric()
                                ->required()
                                ->minValue(0.0001),

                            // Textarea::make('reason')->label('Reason (optional)'),
                        ])
                        ->requiresConfirmation()
                        ->action(function ($record, array $data) {
                            BalanceService::leaderboard(
                                $record,
                                $data['amount']
                            );

                            Notification::make()
                                ->title('Balance Updated, Leaderboard bonus credited')
                                ->success()
                                ->send();
                        }),

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
                    }),
                    // ->visible(fn () => auth()->user()->hasRole(['super-admin'])),

                Action::make('lockRewards')
                    ->label('Lock Rewards')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->form([
                        Textarea::make('reason')
                            ->label('Reason for locking rewards')
                            ->required()
                            ->maxLength(500),
                    ])
                    ->requiresConfirmation()
                    ->modalHeading('Lock Stake Rewards')
                    ->modalDescription('This will prevent the user from claiming rewards generated from all their stakes.')
                    ->action(function ($record, array $data) {
                        $record->update([
                            'lock_roi' => true
                        ]);
                        $record->stakes()
                            ->whereHas('rewards')
                            ->each(function ($stake) use ($data) {
                                $stake->rewards()
                                ->where('status', 'pending')
                                ->update([
                                    'rewards_locked_at' => now(),
                                    'rewards_locked_by' => auth()->id(),
                                    'lock_reason' => $data['reason'],
                                    'status' => 'locked'
                                ]);
                            });

                        Notification::make()
                            ->title('Rewards Locked')
                            ->body('The user can no longer claim rewards from any of their stakes.')
                            ->danger()
                            ->send();
                    })
                    ->visible(fn ($record) =>
                        $record->stakes()
                            ->where('status', 'active')
                            ->whereHas('rewards', function ($q) {
                                $q->whereNull('rewards_locked_at')
                                ->where('status', 'pending');
                            })
                            ->exists() || !$record->lock_roi
                    ),

                    Action::make('unlockRewards')
                        ->label('Unlock Rewards')
                        ->icon('heroicon-o-lock-open')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'lock_roi' => false
                            ]);
                            $record->stakes()
                                ->whereHas('rewards')
                                ->each(function ($stake) {
                                    $stake->rewards()
                                    ->where('status', 'locked')
                                    ->update([
                                        'rewards_locked_at' => null,
                                        'rewards_locked_by' => null,
                                        'lock_reason' => null,
                                        'status' => 'pending'
                                    ]);
                                });

                            Notification::make()
                                ->title('Rewards Unlocked')
                                ->success()
                                ->send();
                        })
                        ->visible(fn ($record) => 
                            $record->stakes()
                            ->where('status', 'active')
                            ->whereHas('rewards', fn ($q) =>
                                $q->whereNotNull('rewards_locked_at')->where('status', 'locked')
                            )->exists() || $record->lock_roi
                        ),

                        // Make Leader
                        Action::make('makeLeader')
                            ->label('Make Leader')
                            ->icon('heroicon-o-shield-check')
                            ->color('success')
                            ->requiresConfirmation()
                            ->visible(fn ($record) => !$record->is_leader)
                            ->action(function ($record) {

                                abort_unless(!$record->is_leader, 403);
                                $record->update(['is_leader' => true]);
                                Notification::make()
                                    ->title('Leader role assigned')
                                    ->body('This user’s new stakes will no longer trigger downline bonuses.')
                                    ->success()
                                    ->send();
                            })
                            ->modalHeading('Confirm role change')
                            ->modalDescription('Are you sure you want to change this user’s leadership status?'),
                        // end make leaader

                        // Remove Leader
                        Action::make('removeLeader')
                            ->label('Remove Leader Role')
                            ->icon('heroicon-o-shield-exclamation')
                            ->color('warning')
                            ->requiresConfirmation()
                            ->visible(fn ($record) => $record->is_leader)
                            ->action(function ($record) {

                                abort_unless($record->is_leader, 403);
                                $record->update(['is_leader' => false]);
                                Notification::make()
                                    ->title('Leader role removed')
                                    ->body('This user’s new stakes will now trigger downline bonuses.')
                                    ->success()
                                    ->send();
                            })
                            ->modalHeading('Confirm role change')
                            ->modalDescription('Are you sure you want to change this user’s leadership status?'),
                        // end remove leaader

                        // Suspending action
                        Action::make('suspendUser')
                            ->label('Suspend User')
                            ->icon('heroicon-o-no-symbol')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->visible(fn ($record) => ! $record->is_suspended)
                            ->action(function ($record) {

                                abort_unless(! $record->is_suspended, 403);

                                $record->update([
                                    'is_suspended' => true,
                                ]);

                                Notification::make()
                                    ->title('User Suspended')
                                    ->body('This user has been suspended and can no longer perform restricted actions.')
                                    ->danger()
                                    ->send();
                            })
                            ->modalHeading('Suspend User')
                            ->modalDescription('Are you sure you want to suspend this user? This action can be reversed.'),

                        // Unsuspending user action
                        Action::make('unsuspendUser')
                            ->label('Unsuspend User')
                            ->icon('heroicon-o-check-circle')
                            ->color('success')
                            ->requiresConfirmation()
                            ->visible(fn ($record) => $record->is_suspended)
                            ->action(function ($record) {

                                abort_unless($record->is_suspended, 403);

                                $record->update([
                                    'is_suspended' => false,
                                ]);

                                Notification::make()
                                    ->title('User Unsuspended')
                                    ->body('This user now has full access to the platform again.')
                                    ->success()
                                    ->send();
                            })
                            ->modalHeading('Unsuspend User')
                            ->modalDescription('Are you sure you want to restore this user’s access?')



                ]),
                
                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
