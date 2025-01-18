<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Statistics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.statistics';
    protected static ?string $navigationGroup = 'Projects';
    protected static bool $shouldRegisterNavigation = false;
}
