<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use App\Models\PendingBeneficiary;
use App\Models\Beneficiary;
use App\Filament\Imports\PendingBeneficiaryImporter;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;
use App\Filament\Exports\PendingBeneficiaryExporter;
use Illuminate\Contracts\View\View;
use Filament\Tables;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
class Duplicates extends Component implements HasForms, HasTable
{

    use InteractsWithForms;
    use InteractsWithTable;

    public $changeQ = false;
    public $t = 'worood';
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function test(){
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
    public function table(Table $table): Table
    {
        return $table
      
            ->headerActions([
                ImportAction::make('import')
                    ->importer(PendingBeneficiaryImporter::class)
                    ->label('Upload Beneficiaries'),
                    Tables\Actions\Action::make('Check Duplicates')
                    ->extraAttributes([
                        'wire:click' => 'changeV',
                    
                    ]),
               
            ])->striped()
            ->heading('Beneficiaries')
          
            ->columns([        
                Tables\Columns\TextColumn::make('fullname'),
                Tables\Columns\TextColumn::make('national_id'),
                Tables\Columns\TextColumn::make('governate'),
                Tables\Columns\TextColumn::make('sector'),
                Tables\Columns\TextColumn::make('modality'),
            ])
         
            ->modifyQueryUsing(function (Builder $query) {
                if ($this->changeQ) {

                    return PendingBeneficiary::getDups();
                }
                else {
                    return PendingBeneficiary::query();
                }
             
            })
            ->query(PendingBeneficiary::query())

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
