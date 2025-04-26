<?php
namespace App\Filament\Resources;

use Filament\Notifications\Notification;
use App\Enums\Governates;
use App\Enums\Sectors;
use App\Filament\Exports\BeneficiaryExporter;
use App\Filament\Imports\BeneficiaryImporter;
//use App\Filament\Imports\BeneficiaryOldImporter;
use App\Filament\Resources\BeneficiaryResource\Pages;
use App\Models\Beneficiary;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions;
use App\Jobs\ImportBenFromCsv;
use Illuminate\Support\Facades\Storage;


class BeneficiaryResource extends Resource
{
    protected static ?string $model           = Beneficiary::class;
    protected static ?string $navigationGroup = 'Projects';
    protected static ?string $navigationIcon  = 'heroicon-o-user-group';

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('national_id')->required()
                    ->length(11)
                    ->numeric(),
                TextInput::make('fullname')->required(),
                TextInput::make('phonenumber')->required()
                    ->length(10)
                    ->numeric(),
                TextInput::make('recipient_name')->required()
                   ,
                TextInput::make('recipient_phone')->required()
                    ->numeric(),
                TextInput::make('recipient_nid')->required()
                    ->numeric(),
                Select::make('governate')
                    ->options(
                        Governates::all()
                    )->when(! auth()->user()->isAdmin(), function (Select $select) {
                    return
                    Select::make('governate2')
                        ->label('Governate')
                        ->options([
                            auth()->user()->governate() => auth()->user()->governate(),
                        ]);
                })->required()
                    ->disabledOn('edit'),
                TextInput::make('project_name')->required()
                    ->disabledOn('edit'),
                TextInput::make('partner')->required()
                    ->disabledOn('edit'),
                TextInput::make('transfer_value')->required()
                    ->numeric(),
                TextInput::make('transfer_count')->required()
                    ->numeric(),
                DatePicker::make('project_start_date')->required()
                    ->disabledOn('edit'),
                DatePicker::make('project_end_date')->required()
                    ->disabledOn('edit'),
                DatePicker::make('recieve_date')->required()
                    ->disabledOn('edit'),
                Select::make('sector')->options(Sectors::all())->required()
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
                                auth()->user()->sector() => auth()->user()->sector(),                                
                            ]);
                    })
                    ->disabledOn('edit'),
                Select::make('modality')->options([
                    'Cash'     => 'Cash',
                    'Voucher'  => 'Voucher',
                    'eVoucher' => 'eVoucher',
                ])
                    ->disabledOn('edit'),
                Hidden::make('created_by')
                    ->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Actions\Action::make('Import CSV')
                ->label('Import CSV')
                ->form([
                   FileUpload::make('csv_file')
                   ->disk('local') // optional: but you can specify to use 'local' here
                   ->directory('temp')
                   ->preserveFilenames()
                   ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])
                   ->required(), // Store on the local disk, or change as needed
                ])
                ->action(function (array $data) {

                    // First, check if temp file exists
                $tempPath = $data['csv_file']; // 'temp/filename.csv'

                 if (!Storage::disk('local')->exists($tempPath)) {
                  throw new \Exception('Uploaded file does not exist.');
                    }

             // Now move it to the "imports" folder
                $newPath = str_replace('temp/', 'imports/', $tempPath);
                Storage::disk('local')->move($tempPath, $newPath);
                    ImportBenFromCsv::dispatch($newPath);

                  Notification::make()
                        ->title('Import started!')
                        ->success()
                        ->send();
                }),
              
                 /* 
                   ImportAction::make()
                    ->importer(BeneficiaryImporter::class)
                    ->options([
                        'updateExisting' => false,
                    ]),  ImportAction::make()
                    ->importer(BeneficiaryOldImporter::class)
                   ->label('Legacy upload'),*/

            ])->striped()
            ->heading('Beneficiaries')
            ->columns([
                //
                Tables\Columns\TextColumn::make('fullname')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('national_id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('governate')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sector')->searchable()->sortable(),
                //   Tables\Columns\TextColumn::make('modality')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('project_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->date()->searchable()->sortable(),
            ])->striped()
            ->groups(['national_id', 'governate', 'sector', 'modality'])
            // ->query(Beneficiary::query())
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->governate != 'all' && auth()->user()->sector != 'all') {
                    return $query->where('governate', auth()->user()->governate)
                        ->where('sector', auth()->user()->sector);
                } elseif (auth()->user()->governate != 'all') {
                    return $query->where('governate', auth()->user()->governate);

                } elseif (auth()->user()->sector != 'all') {
                    return $query->where('sector', auth()->user()->sector);
                } else {
                    return $query;
                }
            })
            ->filters([
                //
                SelectFilter::make('sector')->options(Sectors::all()),
                SelectFilter::make('governate')
                    ->options(fn() => Governates::all()),
                SelectFilter::make('modality')->options([
                    'cash'    => 'cash',
                    'voucher' => 'voucher',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['updated_by'] = auth()->user()->id;

                        return $data;
                    })->modal(),
                Tables\Actions\ViewAction::make()->modal(),

            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->exporter(BeneficiaryExporter::class),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBeneficiaries::route('/'),
            'create' => Pages\CreateBeneficiary::route('/create'),
            'edit'   => Pages\EditBeneficiary::route('/{record}/edit'),
            'view'   => Pages\ViewBeneficiary::route('/{record}'),
        ];
    }
}
