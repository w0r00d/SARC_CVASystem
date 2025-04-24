<?php

namespace App\Filament\Imports;

use App\Models\Beneficiary;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class BeneficiaryOldImporter extends Importer
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

            ImportColumn::make('sector')
            ->requiredMapping()
            ->rules(['required']),

            ImportColumn::make('modality')
            ->requiredMapping()
            ->rules(['required']),

            ImportColumn::make('governate')
            ->requiredMapping()
            ->rules(['required']),

            ImportColumn::make('project_name')
            ->requiredMapping()
            ->rules(['required']),

            ImportColumn::make('partner')
            ,
           /* ImportColumn::make('donor')
            ->requiredMapping()
            ->rules(['required']),
*/
            ImportColumn::make('project_start_date')
            ->requiredMapping()
            ->rules(['required']),

            ImportColumn::make('project_end_date')
            ->requiredMapping()
            ->rules(['required']),
        ];
    }

    public function resolveRecord(): ?Beneficiary
    {
        // return BeneficiaryOld::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Beneficiary();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your beneficiary old import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
