<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeneficiaryViewResource\Pages;
use App\Filament\Resources\BeneficiaryViewResource\RelationManagers;
use App\Models\BeneficiaryView;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BeneficiaryViewResource extends Resource
{
    protected static ?string $model = BeneficiaryView::class;
    protected static ?string $navigationIcon  = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Projects';
  
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('national_id')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                Forms\Components\TextInput::make('fullname')
                    ->required()
                    ->maxLength(255)
                    ->default(''),
                    /*
                Forms\Components\TextInput::make('phonenumber')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('recipient_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('recipient_phone')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('recipient_nid')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('governate')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('project_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('partner')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('donor')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('transfer_value')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('transfer_count')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('project_start_date'),
                Forms\Components\DatePicker::make('project_end_date'),
                Forms\Components\DatePicker::make('recieve_date'),
                Forms\Components\TextInput::make('sector')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('modality')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('ben')
                    ->required()
                    ->maxLength(7)
                    ->default(''),
                    */
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            
                Tables\Columns\TextColumn::make('national_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fullname')
                    ->searchable(),
/*
                Tables\Columns\TextColumn::make('phonenumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('recipient_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('recipient_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('recipient_nid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('governate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('partner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('donor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transfer_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transfer_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('recieve_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sector')
                    ->searchable(),
                Tables\Columns\TextColumn::make('modality')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ben')
                    ->searchable(),
                    */
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
    public static function shouldRegisterNavigation(): bool
    {
        return true; // This should return true
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
            'index' => Pages\ListBeneficiaryViews::route('/'),
            'create' => Pages\CreateBeneficiaryView::route('/create'),
            'edit' => Pages\EditBeneficiaryView::route('/{record}/edit'),
        ];
    }
}
