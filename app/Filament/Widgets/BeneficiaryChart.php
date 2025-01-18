<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Beneficiary;

class BeneficiaryChart extends ChartWidget
{
    protected static ?string $heading = 'Beneficiaries numbers based on modality';
    protected static ?string $maxHeight = '300px';
    protected static ?string $maxWidth = '300px';
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Number of Beneficiaries',
                    'data' => [Beneficiary::where('modality', 'cash')->count(),
                   
                    Beneficiary::where('modality', 'voucher')->count(),
                    Beneficiary::where('modality', 'evoucher')->count()],
                  
                ],
            ],
            'labels' => ['Cash',  'Voucher', 'eVoucher'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
