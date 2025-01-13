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
                    ])
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
                //  Tables\Columns\TextColumn::make('ben'),
                Tables\Columns\IconColumn::make('ben')
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-no-symbol' => 'ben',
                        'heroicon-o-exclamation-circle' => 'pending',

                    ]),
                Tables\Columns\TextColumn::make('ben'),

            ])

            ->modifyQueryUsing(function (Builder $query) {
                if ($this->changeQ) {

                    return BeneficiaryView::getDups();
                } else {
                    return BeneficiaryView::query();
                }

            })
            ->query(BeneficiaryView::query())

            ->bulkActions([
                ExportBulkAction::make()
                    ->exporter(PendingBeneficiaryExporter::class),
            ]);

    }

    public function render()
    {
        return view('livewire.duplicates');
    }
}
