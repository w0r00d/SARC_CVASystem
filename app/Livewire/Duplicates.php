<?php
namespace App\Livewire;

use App\Filament\Exports\PendingBeneficiaryExporter;
use App\Filament\Imports\PendingBeneficiaryImporter;
use App\Models\Beneficiary;
use App\Models\BeneficiaryView;
use App\Models\PendingBeneficiary;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Illuminate\Validation\Rules\File;

class Duplicates extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    protected static ?string $model = Beneficiary::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public $changeQ = false;

    public $t            = 'worood';
    public $cnt          = 0;
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
                      ->fileRules([
    
        File::types(['text/csv',
'text/x-csv',
'application/csv',
'application/x-csv',
 'text/comma-separated-values',
'text/x-comma-separated-values', 
'text/plain',
'application/vnd.ms-excel]'])->max(1024),
    ])
                    ->label('Upload Pending Beneficiaries'),
                Tables\Actions\Action::make('Show Duplicates')
                    ->extraAttributes([
                        'wire:click' => 'changeV',

                    ])
                    ->color('blue'),
                Tables\Actions\Action::make('Clear Pending Data')
                    ->extraAttributes([
                        'wire:click'   => 'clearing',
                        'wire:confirm' => 'Are you sure you want to clear pending data? This cannot be undone.',
                    ])
                    ->color('primary'),
            ])
            ->heading('Beneficiaries Data')
            ->columns([
                Tables\Columns\TextColumn::make('fullname')
                /*->extraAttributes([
                        'style' => ' background-color: #0f0; color:#fff;',
                    ])*/    ,
                Tables\Columns\TextColumn::make('national_id')
                    ->extraAttributes(function (BeneficiaryView $beneficiaryView) {
                        // dump($beneficiaryView->ben);
                        if ($beneficiaryView->checkRecord() && $beneficiaryView->ben == 'pending') {
                            return ['style' => ' background-color: #c93232;'];
                        }
                        return [];
                    }),
                   
                Tables\Columns\TextColumn::make('governate'),
                Tables\Columns\TextColumn::make('sector'),
                Tables\Columns\TextColumn::make('modality'),
                Tables\Columns\TextColumn::make('ben')
                    ->label('Beneficiary Type'),
                     /*
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ct')->date(),
                Tables\Columns\IconColumn::make('ben')
                    ->label('Pending/Old')
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-no-symbol'          => 'ben',
                        'heroicon-o-exclamation-circle' => 'pending',
                    ]),
                Tables\Columns\IconColumn::make('Is Duplicate')
                    ->getStateUsing(function (BeneficiaryView $record) {
                        // return whatever you need to show
                        return $record->checkRecord();
                    })
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-check'  => true,
                        'heroicon-o-x-mark' => false,

                    ]),
                    */
            ])
            ->striped()
            ->paginated(50)
            ->modifyQueryUsing(function (Builder $query) {
                if ($this->changeQ) {
                  //return Beneficiary::query();
                 //   $this->cnt = BeneficiaryView::getDups()->count();
                    return BeneficiaryView::getDups();
                } else {
                   // return BeneficiaryView::query()->where('ben', 'pending');
                   return PendingBeneficiary::query();
                }
            })
            ->query(BeneficiaryView::where('ben', 'pending'))

            ->bulkActions([
                ExportBulkAction::make()
                    ->exporter(PendingBeneficiaryExporter::class),
            ])
            ->emptyStateHeading('No pending Beneficiaries to check.')
            ->actions([
                Tables\Actions\ViewAction::make()->infolist([
                    Section::make('Beneficiary Data')
                        ->columns(3)
                        ->schema([
                            TextEntry::make('fullname'),
                            Infolists\Components\TextEntry::make('national_id'),
                            Infolists\Components\TextEntry::make('phonenumber')
                                ->label('Phone number')
                                ->icon('heroicon-s-phone'),
                               
                            Infolists\Components\TextEntry::make('recipient_name'),
                            Infolists\Components\TextEntry::make('recipient_nid'),
                            Infolists\Components\TextEntry::make('recipient_phone')
                                ->icon('heroicon-s-phone'),
                            Infolists\Components\TextEntry::make('project_name'),
                            Infolists\Components\TextEntry::make('partner'),
                            Infolists\Components\TextEntry::make('sector'),
                            Infolists\Components\TextEntry::make('modality'),
                             /*
                            Infolists\Components\TextEntry::make('project_start_date')
                                ->icon('heroicon-s-calendar-days'),
                            Infolists\Components\TextEntry::make('project_end_date')
                                ->icon('heroicon-s-calendar-days'),
                            Infolists\Components\TextEntry::make('transfer_value')
                                ->icon('heroicon-s-banknotes'),
                            Infolists\Components\TextEntry::make('transfer_count'),
                            Infolists\Components\TextEntry::make('recieve_date')
                                ->icon('heroicon-s-calendar-days'),
                            Infolists\Components\TextEntry::make('updated_at')->icon('heroicon-s-calendar-days'),
                            Infolists\Components\TextEntry::make('created_at')->icon('heroicon-s-calendar-days'),
                            */
                        ])]),
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
