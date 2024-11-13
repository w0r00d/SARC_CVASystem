<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->required(),
                TextInput::make('password')->required()
                    ->password(),
                Select::make('governate')
                    ->options([
                        'All' => 'All',
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

                    ])->required(),
                Select::make('sector')->options([
                    'All' => 'All',
                    'Health' => 'Health',
                    'Livelihood' => 'Livelihood',
                    'Protection' => 'Protection',
                    'Disaster Management' => 'Disaster Management',
                    'Wash' => 'Wash',
                    'Risk Education' => 'Risk Education',
                ])->required(),
                Select::make('role')->options([
                    'All' => 'All',
                    'Super Admin' => 'Super Admin',
                    'HQ Admin' => 'HQ Admin',
                    'Branch Admin' => 'Branch Admin',
                    'Department Admin' => 'Department Admin',
                    'Visitor' => 'Visitor',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('governate')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
