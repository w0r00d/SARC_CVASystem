<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Beneficiary; 

class BeneficiariesStats extends BaseWidget
{
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Beneficiaries', Beneficiary::count()),
            Stat::make('Total Projects', Beneficiary::distinct()->get('project_name')->count())
            ->description('')
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Total Amount of money', Beneficiary::get('transfer_value')->sum('transfer_value'))
            ->description('syrian pounds')
            ,
           
          
            
        ];
    }
}
