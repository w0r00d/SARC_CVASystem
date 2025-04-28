<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Beneficiary;
class BeneficiaryGovChart extends ChartWidget
{
    protected static ?string $heading = 'Beneficiaries per Governate';

    protected function getData(): array
    {
        return [
           'datasets' => [
                [
                    'label' => 'Number of Beneficiaries',
                    'data' => [
                    Beneficiary::where('governate', 'damascus')->count(),
                    Beneficiary::where('governate', 'aleppo')->count(),
                    Beneficiary::where('governate', 'homs')->count(),
                    Beneficiary::where('governate', 'hama')->count(), 
                    Beneficiary::where('governate', 'tartous')->count(),
                    Beneficiary::where('governate', 'latakia')->count(),
                    Beneficiary::where('governate', 'tartous')->count(),
                    Beneficiary::where('governate', 'rural damascus')->count(),
                    Beneficiary::where('governate', 'deir-ez-zor')->count(),
                    Beneficiary::where('governate', 'Quneitra')->count(),
                    Beneficiary::where('governate', 'Dar\'a')->count(),
                    Beneficiary::where('governate', 'Ar-raqqa')->count(),
                    Beneficiary::where('governate', 'sweida')
                    ->orWhere('governate', 'as-sweida')->count(),
                ],
                 
                ],
            ],
            'labels' => [ 'Damascus', 'Aleppo', 'Homs', 'Hama','Tartous', 'Latakia', 'Daraa', 'Rural Damascus','deir-ez-zor','Quneitra','Dar\'a' , 'Ar-raqqa', 'sweida'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
