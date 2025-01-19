<?php

namespace App\Filament\Resources;

use App\Filament\Imports\BeneficiaryImporter;
use App\Filament\Resources\BeneficiaryResource\Pages;
use App\Models\Beneficiary;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;
    protected static ?string $navigationGroup = 'Projects';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                    ->alpha(),
                TextInput::make('recipient_phone')->required()
                    ->numeric(),
                TextInput::make('recipient_nid')->required()
                    ->numeric(),
                Select::make('governate')
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
                    ])->required()
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
                Select::make('sector')->options([
                    'Health' => 'Health',
                    'Livelihood' => 'Livelihood',
                    'Protection' => 'Protection',
                    'Disaster Management' => 'Disaster Management',
                    'Wash' => 'Wash',
                    'Risk Education' => 'Risk Education',
                ])->required()
                    ->disabledOn('edit'),
                Select::make('modality')->options([
                    'cash' => 'cash',
                    'voucher' => 'voucher',
                ])
                    ->disabledOn('edit'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ImportAction::make()
                    ->importer(BeneficiaryImporter::class)
                    ->options([
                        'updateExisting' => false,
                    ]),

            ])->striped()
            ->heading('Beneficiaries')

            ->columns([
                //
                Tables\Columns\TextColumn::make('fullname')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('national_id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('governate')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sector')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('modality')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('project_name')->searchable()->sortable(),
            ])
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

                

            ])
            ->actions([
                Tables\Actions\EditAction::make()->modal(),
                Tables\Actions\ViewAction::make()->modal(),
                Action::make('Test')->icon('heroicon-o-document-duplicate')->form([
                    TextInput::make('modality')
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBeneficiaries::route('/'),
            'create' => Pages\CreateBeneficiary::route('/create'),
            'edit' => Pages\EditBeneficiary::route('/{record}/edit'),
            'view' => Pages\ViewBeneficiary::route('/{record}'),
        ];
    }
}
