<?php

namespace App\Filament\Resources\SupportTickets\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SupportTicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Ticket #')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(['name', 'email'])
                    ->sortable(),
                TextColumn::make('subject')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->subject)
                    ->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'open',
                        'warning' => 'in_progress',
                        'success' => 'resolved',
                        'secondary' => 'closed',
                    ])
                    ->sortable(),
                BadgeColumn::make('priority')
                    ->colors([
                        'success' => 'low',
                        'primary' => 'medium',
                        'warning' => 'high',
                        'danger' => 'urgent',
                    ])
                    ->sortable(),
                BadgeColumn::make('messages_count')
                    ->label('Replies')
                    ->counts('messages')
                    ->color(fn ($record) =>
                        $record->messages()->where('is_staff', false)->exists()
                            ? 'danger'
                            : 'success'
                    ),
                TextColumn::make('closed_at')
                    ->label('Closed At')
                    ->dateTime()
                    ->placeholder('--')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'in_progress' => 'In Progress',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ]),
            ])
            ->recordActions([
                // Action::make('view')
                //     ->label('View')
                //     ->icon('heroicon-o-eye')
                //     ->url(fn ($record) => route('filament.resources.support-tickets.view', $record)),
                Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->mountUsing(fn ($form, $record) => $form->fill([
                        'ticket_id' => $record->id
                    ]))
                    ->form([
                        Textarea::make('message')
                            ->required()
                            ->label('Message'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->messages()->create([
                            'user_id' => auth()->id(),
                            'message' => $data['message'],
                            'is_staff' => true,
                        ]);
                        $record->update([
                            'status' => 'in_progress',
                            'last_activity_at' => now(),
                        ]);
                    }),

                    Action::make('close')
                    ->label('Close Ticket')
                    ->icon('heroicon-o-check-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status !== 'closed')
                    ->action(fn ($record) => $record->update([
                        'status' => 'closed',
                        'closed_at' => now(),
                    ])),

                    Action::make('reopen')
                    ->label('Reopen Ticket')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'closed')
                    ->action(fn ($record) => $record->update([
                        'status' => 'open',
                        'closed_at' => null,
                    ])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([]);
    }
}
