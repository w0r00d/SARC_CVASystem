<?php

namespace App\Filament\Pages;

use Filament\Infolists;
use Filament\Pages\Page;

class BeneficiaryViewPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.beneficiary-view-page';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                Section::make('Beneficiary Personal Data')
                    ->icon('heroicon-s-user')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('fullname'),
                        Infolists\Components\TextEntry::make('national_id'),
                        Infolists\Components\TextEntry::make('phonenumber')
                            ->label('Phone number')
                            ->icon('heroicon-s-phone'),

                        Section::make('Recipient Personal Data')
                            ->icon('heroicon-s-user')

                            ->columns(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('recipient_name'),
                                Infolists\Components\TextEntry::make('recipient_nid'),
                                Infolists\Components\TextEntry::make('recipient_phone')
                                    ->icon('heroicon-s-phone'),

                            ]),
                        Section::make('Project Detail')
                            ->icon('heroicon-s-information-circle')
                            ->columns(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('project_name'),
                                Infolists\Components\TextEntry::make('partner'),
                                Infolists\Components\TextEntry::make('sector'),
                                Infolists\Components\TextEntry::make('modality'),
                                Infolists\Components\TextEntry::make('project_start_date')
                                    ->icon('heroicon-s-calendar-days'),
                                Infolists\Components\TextEntry::make('project_end_date')
                                    ->icon('heroicon-s-calendar-days'),

                            ]),
                        Section::make('Transfer Details')
                            ->icon('heroicon-s-banknotes')
                            ->columns(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('transfer_value')
                                    ->icon('heroicon-s-banknotes'),
                                Infolists\Components\TextEntry::make('transfer_count'),
                                Infolists\Components\TextEntry::make('recieve_date')
                                    ->icon('heroicon-s-calendar-days'),

                            ]),
                        Section::make('Update Details')
                            ->icon('heroicon-s-pencil-square')
                            ->columns(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('updated_at')->icon('heroicon-s-calendar-days'),
                                Infolists\Components\TextEntry::make('created_at')->icon('heroicon-s-calendar-days'),

                            ]),
                        Section::make('Duplicates')
                            ->icon('heroicon-s-square-3-stack-3d')
                            ->columns(3),

                    ])
                    ->columns(2),
            ]);
    }
    public static function shouldRegisterNavigation(): bool
{
    return false;
}
}
