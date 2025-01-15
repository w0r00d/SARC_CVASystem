<?php

namespace App\Livewire;

use App\Filament\Exports\PendingBeneficiaryExporter;
use App\Filament\Imports\PendingBeneficiaryImporter;
use App\Models\BeneficiaryView;
use App\Models\PendingBeneficiary;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Duplicates extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $changeQ = false;

    public $t = 'worood';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function test()
    {
        $this->t = 'worooooood';
    }

    public function changeV()
    {
        if ($this->changeQ) {
            $this->changeQ = false;
        } else {
            $this->changeQ = true;
        }
        $this->dispatch('refreshComponent');
    }

    public function clearing()
    {
        PendingBeneficiary::destroy(PendingBeneficiary::all());
    }

    public function table(Table $table): Table
    {
        return $table

            ->headerActions([
                ImportAction::make('import')

                    ->importer(PendingBeneficiaryImporter::class)
                    ->label('Upload Pending Beneficiaries'),
                Tables\Actions\Action::make('Check Duplicates')
                    ->extraAttributes([
                        'wire:click' => 'changeV',

                    ])
                    ->color('blue'),
                Tables\Actions\Action::make('Clear Pending Data')
                    ->extraAttributes([
                        'wire:click' => 'clearing',
                        'wire:confirm' => 'Are you sure you want to delete pending? This cannot be undone.',
                    ])->requiresConfirmation()
                    ->color('primary'),

            ])->striped()
            ->heading('Beneficiaries')

            ->columns([
                Tables\Columns\TextColumn::make('fullname')
                /*->extraAttributes([
                        'style' => ' background-color: #0f0; color:#fff;',
                    ])*/,
                Tables\Columns\TextColumn::make('national_id')
                    ->extraAttributes(function (BeneficiaryView $beneficiaryView) {
                        // dump($beneficiaryView->ben);
                        if ($beneficiaryView->ben == 'pending') {
                            return ['style' => ' background-color: #c93232;'];
                        }

                        return [];
                    }),

                Tables\Columns\TextColumn::make('governate'),
                Tables\Columns\TextColumn::make('sector'),
                Tables\Columns\TextColumn::make('modality'),
                Tables\Columns\TextColumn::make('ben')
                    ->label('Beneficiary Type'),
                Tables\Columns\IconColumn::make('ben')
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-no-symbol' => 'ben',
                        'heroicon-o-exclamation-circle' => 'pending',
                    ]),
                Tables\Columns\TextColumn::make('ben'),
            ])
            ->emptyStateHeading('No pending Beneficiaries to be checked.
             ')
             ->emptyStateDescription('Use the upload button to upload CSV file.')
            ->actions([
                Tables\Actions\ViewAction::make()->modal(),
            ])

            ->modifyQueryUsing(function (Builder $query) {
                if ($this->changeQ) {
                    return BeneficiaryView::getDups();
                } else {
                    return BeneficiaryView::where('ben', 'pending');
                }
            })
            ->query(BeneficiaryView::where('ben', 'pending'))
            ->bulkActions([
                ExportBulkAction::make()
                    ->exporter(PendingBeneficiaryExporter::class),
            ])
            ->filters([
                //
                SelectFilter::make('sector')->options([
                    'Health' => 'Health',
                    'Livelihood' => 'Livelihood',
                    'Protection' => 'Protection',
                    'Disaster Management' => 'Disaster Management',
                    'Wash' => 'Wash',
                    'Risk Education' => 'Risk Education',
                ]),
                SelectFilter::make('governate')
                    ->options([
                        'Damascus' => 'Damascus',
                        'Aleppo' => 'Aleppo',
                        'Homs' => 'Homs',
                        'Hama' => 'Hama',
                        'Latakia' => 'Latakia',
                        'Tartous' => 'Tartous',
                        'As-Sweida' => 'As-Sweida',
                        'Ar-Raqqa' => 'Ar-Raqqa',
                        'Daraa' => 'Daraa',
                        'Idleb' => 'Idleb',
                        'Quneitra' => 'Quneitra',
                        'Rural Damascus' => 'Rural Damascus',
                        'Der-ezzor' => 'Der-ezzor',
                        'Alhasaka' => 'Alhasaka',
                    ]),
                SelectFilter::make('modality')->options([
                    'cash' => 'cash',
                    'voucher' => 'voucher',
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'view' => Pages\ViewBeneficiary::route('/{record}'),
        ];
    }

    public function render()
    {
        return view('livewire.duplicates');
    }
}
