<?php

namespace App\Filament\Imports;

use App\Models\PendingBeneficiary;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\DB;
use App\Enums\Governates;
use App\Enums\Sectors;
class PendingBeneficiaryImporter extends Importer
{
    protected static ?string $model = PendingBeneficiary::class;


    public static function getColumns(): array
    {
        return [ 
        ImportColumn::make('national_id')
        ->requiredMapping()
        ->rules(['required']),
        ImportColumn::make('fullname')
        ->requiredMapping()
        ->rules(['required', 'max:255']),
     
   

    ];
    }
    /*
    public static function getOptionsFormComponents(): array
    {
        return [
            Select::make('sector2')
                ->label('Sector')
                ->options(Sectors::all())
                ->when(auth()->user()->isAdmin(), function (Select $select) {
                    return
                        Select::make('sector2')
                            ->label('Sector')
                            ->options(Sectors::all());
                })
                ->when(! auth()->user()->isAdmin(), function (Select $select) {
                    return
                        Select::make('sector2')
                            ->label('Sector')
                            ->options([
                                auth()->user()->sector => auth()->user()->sector,
                              
                            ]);
                }),
            Select::make('modality2')
                ->label('Modality')
                ->options([
                    'Cash' => 'Cash',
                    'eVoucher' => 'eVoucher',
                    'Voucher' => 'Voucher',
                ]),

            Select::make('governate2')
                ->options([

                ])
                ->when(auth()->user()->isAdmin(), function (Select $select) {
                    return
                        Select::make('governate2')
                            ->label('Governate')
                            ->options(  Governates::all());
                })->when(! auth()->user()->isAdmin(), function (Select $select) {
                    return
                        Select::make('governate2')
                            ->label('Governate')
                            ->options([
                                auth()->user()->governate => auth()->user()->governate,
                            ]);
                })->required(),
            TextInput::make('project_name2')
                ->label('Project Name'),
            TextInput::make('partner2')
                ->label('Partner'),
            DatePicker::make('project_start_date2')
                ->label('Project Start Date'),
            DatePicker::make('project_end_date2')
                ->label('Project End Date'),
            //  Checkbox::make('updateExisting')
            //   ->label('Update existing records'),

        ];
    }
*/
    public function resolveRecord(): ?PendingBeneficiary
    {
        /*
        return PendingBeneficiary::firstOrNew([
            //     // Update existing records, matching them by `$this->data['column_name']`
            'national_id' => $this->data['national_id'],
            'sector' => $this->options['sector2'],
            'governate' => $this->options['governate2'],
            'modality' => $this->options['modality2'],
            'project_name' => $this->options['project_name2'],
            'partner' => $this->options['partner2'],
            'project_start_date' => $this->options['project_start_date2'],
            'project_end_date' => $this->options['project_end_date2'],

        ]);
*/
        return new PendingBeneficiary();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your pending beneficiary import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
