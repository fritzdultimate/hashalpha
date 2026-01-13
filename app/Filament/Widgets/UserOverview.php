<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class UserOverview extends Widget
{
    protected string $view = 'filament.widgets.user-overview';

    public $record; // the user record

    protected function getViewData(): array
    {
        return [
            'user' => $this->record,
        ];
    }
}
