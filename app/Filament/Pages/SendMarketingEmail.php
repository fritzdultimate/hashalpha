<?php

namespace App\Filament\Pages;

use App\Jobs\SendSendGridEmail;
use App\Services\AudienceResolver;
use App\Services\SendGridService;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;
use UnitEnum;

class SendMarketingEmail extends Page implements HasForms {
    use InteractsWithForms;

    protected static string|UnitEnum|null $navigationGroup = 'Mail System';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-paper-airplane';
    protected string $view = 'filament.pages.send-marketing-email';

    public array $data = [];

    public function mount(): void {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema {
        return $schema
            ->statePath('data')
            ->schema([
                Select::make('template_id')
                    ->label('SendGrid Template')
                    ->options(fn () => SendGridService::templates())
                    ->searchable()
                    ->required(),

                Select::make('audience')
                    ->multiple()
                    ->reactive()
                    ->options([
                        'active' => 'Active Users',
                        'suspended' => 'Suspended Users',
                        'leaders' => 'Leaders',
                        'recent' => 'Recent Users',
                        'custom' => 'Custom Emails',
                    ])
                    ->required(),

                TagsInput::make('custom_emails')
                    ->label('Custom Emails')
                    ->placeholder('Type email and hit space...')
                    ->visible(fn (Get $get) =>
                        in_array('custom', $get('audience') ?? [])
                    )
                    ->required(fn (Get $get) =>
                        in_array('custom', $get('audience') ?? [])
                    ),
            ]);
    }

    public function send(): void {
        $data = $this->form->getState();

        $emails = [];

        // if (!empty($data['audience']) && !in_array('custom', $data['audience'])) {
        //     $emails = AudienceResolver::resolve($data['audience']);
        // }

        if (!in_array('custom', $data['audience'])) {
            $emails = AudienceResolver::resolve($data['audience']);
        }

        if (in_array('custom', $data['audience'])) {
            $emails = array_merge(
                $emails,
                $data['custom_emails'] ?? []
            );
        }

        if (empty($emails)) {
            Notification::make()
                ->title('No Emails Found')
                ->body('No recipients matched the selected audience or custom emails.')
                ->danger()
                ->send();
            return;
        }


        foreach (array_unique($emails) as $email) {
            SendSendGridEmail::dispatch(
                $data['template_id'],
                $email
            );
        }

        Notification::make()
            ->title('Emails Sent')
            ->body(count($emails) . ' emails have been sent to recipients.')
            ->success()
            ->send();

        $this->form->fill();

    }

}
