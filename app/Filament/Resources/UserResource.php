<?php
namespace App\Filament\Resources;

use App\Enums\Governates;
use App\Enums\Sectors;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Exports\UserExporter;
class UserResource extends Resource
{
    protected static ?string $model           = User::class;
 //   protected static ?int $navigationSort     = 4;
    protected static ?string $navigationIcon  = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Settings';
    
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
                        "Access to All Data"      => ['All' => 'All'],
                        "or choose one Governate" => Governates::all(),

                    ])->required(),
                Select::make('sector')->options([
                    "Full Access"           => ['All' => 'All'],
                    "Or choose one Sector " => Sectors::all(),
                ])->required(),
                Select::make('role')->options([
                    'Super Admin'      => 'Super Admin',
                    'HQ Admin'         => 'HQ Admin',
                    'Branch Admin'     => 'Branch Admin',
                    'Department Admin' => 'Department Admin',
                    'Visitor'          => 'Visitor',
                ])
                    ->required(),
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
                Tables\Columns\TextColumn::make('sector')
                    ->searchable()
                    ->sortable(),
            ])
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

                SelectFilter::make('sector')
                    ->options(Sectors::all()),
                SelectFilter::make('governate')
                    ->options(
                        Governates::all()
                    ),
                SelectFilter::make('role')->options([
                    'Super Admin'      => 'Super Admin',
                    'HQ Admin'         => 'HQ Admin',
                    'Branch Admin'     => 'Branch Admin',
                    'Department Admin' => 'Department Admin',
                    'Visitor'          => 'Visitor',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn(User $record): bool => auth()->user()->role === 'Super Admin'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                //    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                    ->exporter(UserExporter::class),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {

        return auth()->user()->isAdmin();

    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
