<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Cities';

    protected static ?string $resourceLabel = 'City';
    protected static ?string $navigationGroup = 'Locations';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('City')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Name'),
                    Forms\Components\Select::make('country')
                        ->label('Country')
                        ->preload()
                        ->options(Country::all()->pluck('name', 'name')->toArray()) // Still using the name for country selection
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('state_id', null)),

                    Forms\Components\Select::make('state_id')
                        ->label('State')
                        ->preload()
                        ->options(function (callable $get) {
                            $country = Country::where('name', $get('country'))->first();
                            if (!$country) {
                                return State::all()->pluck('name', 'id'); // Use 'id' for the value, 'name' for display
                            }
                            return $country->states->pluck('name', 'id'); // Use 'id' for the value, 'name' for display
                        })
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('city', null)),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('state.name'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
