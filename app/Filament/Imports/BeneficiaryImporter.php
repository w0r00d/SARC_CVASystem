<?php

namespace App\Filament\Imports;

use App\Models\Beneficiary;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\DB;
use App\Enums\Governates;
use App\Enums\Sectors;
class BeneficiaryImporter extends Importer
{
    protected static ?string $model = Beneficiary::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('national_id')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('fullname')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('phonenumber')
                ->requiredMapping()
                ->rules(['required', 'max:10']),
            ImportColumn::make('recipient_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('recipient_phone')
                ->requiredMapping()
                ->rules(['required', 'max:10']),
            ImportColumn::make('recipient_nid')
                ->requiredMapping()
                ->rules(['required', 'max:11']),
         
            ImportColumn::make('transfer_value')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('transfer_count')
                ->requiredMapping()
                ->rules(['required']),
      
            ImportColumn::make('recieve_date')
                ->requiredMapping()
                ->rules(['required']),
          
        ];
    }

    public static function getOptionsFormComponents(): array
    {
        return [
                 Select::make('sector2')
                ->label('Sector')
                ->options( Sectors::all())
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
                            ->options(
                                 Governates::all() 
                            );
                })
                ->when(! auth()->user()->isAdmin(), function (Select $select) {
                    return
                        Select::make('governate2')
                            ->label('Governate')
                            ->options([
                                auth()->user()->governate => auth()->user()->governate,

                            ]);
                }),
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

    public function resolveRecord(): ?Beneficiary
    {
        return Beneficiary::firstOrNew([
            //     // Update existing records, matching them by `$this->data['column_name']`
            'national_id' => $this->data['national_id'],
            'sector' => $this->options['sector2'],
            'governate' => $this->options['governate2'],
            'modality' => $this->options['modality2'],
            'project_name' => $this->options['project_name2'],
            'partner' => $this->options['partner2'],
            'project_start_date' => $this->options['project_start_date2'],
            'project_end_date' => $this->options['project_end_date2'],
            'created_by' => auth()->id()

        ]);

        return new Beneficiary;
    }

    public function beforeCreate(): void
    {
        //     $data = $this->data;
        $nid = $this->data['national_id'];
        $d = DB::table('beneficiaries')->where('national_id', 'like', $nid)->count();
        //   $options = $this->options;

        if ($d) {
            dump($d);
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your beneficiary import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
