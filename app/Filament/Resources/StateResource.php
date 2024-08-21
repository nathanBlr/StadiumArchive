<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StateResource\Pages;
use App\Filament\Resources\StateResource\RelationManagers;
use App\Models\Country;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Locations';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('State')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('Name'),
                    Select::make('country_id')
                        ->relationship('country','name')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('country.name'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('country')
                    ->form([
                        Select::make('country')
                            ->options(Country::query()
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->toArray())
                            ->placeholder('Select a country')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('state', null); // Reset state when country changes
                            }),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['country'])) {
                            $query->where('country_id', $data['country']);
                        }
                        return $query;
                    }),
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
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
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
