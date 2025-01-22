<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ShowDuplicates extends Component  implements HasForms, HasTable
{
    public Model $record;
    use InteractsWithForms;
    use InteractsWithTable;

    public  $cnt;

    public function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(function (Builder $query) {
            $this->cnt = $this->record->getCount();
            if ($this->record->getCount()>1) 
                //return Beneficiary::query();
               return $this->record->get_dups();
            else $this->record;
        })
        ->query(Beneficiary::where('national_id',$this->record->national_id))
        ->columns([
            Tables\Columns\TextColumn::make('national_id'),
            Tables\Columns\TextColumn::make('fullname'),
            Tables\Columns\TextColumn::make('sector'),
            Tables\Columns\TextColumn::make('governate'),
            Tables\Columns\TextColumn::make('project_name'),
            Tables\Columns\TextColumn::make('transfer_value'),
    
    ],)
        ->emptyStateHeading('No duplicates found');
    }


    public function render()
    {
        return view('livewire.show-duplicates');
    }
}
