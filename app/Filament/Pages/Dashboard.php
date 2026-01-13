<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TotalDeposits;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Dashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;
    protected string $view = 'filament.pages.dashboard';

    // Optional: add widgets if you want them automatically
    protected function getHeaderWidgets(): array
    {
        return [
            TotalDeposits::class,
        ];
    }
}
