<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Beneficiary; 

class BeneficiariesStats extends BaseWidget
{
    
    protected function getStats(): array
    {   if(auth()->user()->isAdmin()){
        return [
            Stat::make('Total Beneficiaries', Beneficiary::count()),
            Stat::make('Total Projects', Beneficiary::distinct()->count('project_name'))
            ->description('')
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Total Amount of money', Beneficiary::sum('transfer_value'))
            ->description('syrian pounds'),        
        ];
    } 
    
    else 
        return [
            Stat::make('Total Beneficiaries in '.auth()->user()->governate, Beneficiary::where('governate',auth()->user()->governate)->count()),
            Stat::make('Total Projects in '.auth()->user()->governate, Beneficiary::distinct()->where('governate',auth()->user()->governate)->count('project_name'))
            ->description('')
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Total Amount of money in '.auth()->user()->governate, Beneficiary::where('governate',auth()->user()->governate)->sum('transfer_value'))
            ->description('syrian pounds')
            ,        
        ];
    }
}
