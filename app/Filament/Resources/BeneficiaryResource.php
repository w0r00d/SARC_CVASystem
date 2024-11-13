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
use Filament\Tables\Table;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('national_id')->required()
                    ->length(11),
                TextInput::make('fullname')->required()
                    ->alpha(),
                TextInput::make('phonenumber')->required()
                    ->length(10),
                TextInput::make('recipient_name')->required()
                    ->alpha(),
                TextInput::make('recipient_phone')->required(),
                TextInput::make('recipient_nid')->required(),
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
                TextInput::make('transfer_value')->required(),
                TextInput::make('transfer_count')->required(),
                DatePicker::make('project_start_date')->required()
                    ->disabledOn('edit'),
                DatePicker::make('project_end_date')->required()
                    ->disabledOn('edit'),
                DatePicker::make('recieve_date')->required(),
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
            ])
            ->columns([
                //
                Tables\Columns\TextColumn::make('fullname'),
                Tables\Columns\TextColumn::make('national_id'),
                Tables\Columns\TextColumn::make('governate'),
                Tables\Columns\TextColumn::make('sector'),
                Tables\Columns\TextColumn::make('modality'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
        ];
    }
}
