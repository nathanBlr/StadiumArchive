<?php

namespace App\Filament\Resources;

use AbanoubNassem\FilamentPhoneField\Forms\Components\PhoneInput;
use App\Filament\Resources\StadiumResource\Pages;
use App\Filament\Resources\StadiumResource\Widgets\StadiumMap;
use App\Models\City;
use App\Models\Country;
use App\Models\Sport;
use App\Models\Stadium;
use App\Models\State;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction as ActionsViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\RatingTheme;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class StadiumResource extends Resource
{
    protected static ?string $model = Stadium::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    
    public static function getModelLabel(): string
    {
        return __('stadiums');
    }
    public static function getNavigationGroup(): string
    {
        return __('Complexes');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('tabs')->schema([
                    Tab::make('Informations')->icon('heroicon-o-identification')->schema([
                        Fieldset::make('')->schema([
                            Forms\Components\TextInput::make('name')
                            ->live()
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->reactive()
                            ->required(),
                        TextInput::make('slug')
                            ->afterStateUpdated(function (Closure $set) {
                                $set('is_slug_changed_manually', true);
                            })
                            ->required(),
                        Hidden::make('is_slug_changed_manually')
                            ->default(false)
                            ->dehydrated(false),
                            Forms\Components\TextInput::make('full_name')
                                ->maxLength(255),
                            PhoneInput::make('phone_number')
                                // make sure to set Initial Country to null, in the admin panel
                                // especially if you have multiple records of phone numbers from
                                // multiple different countries.
                               ->initialCountry(null)
                                ->tel(),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('website')
                                ->maxLength(255),
                        ])
                    ]),
                    Tab::make('Rating')->icon('heroicon-o-star')->schema([
                        Fieldset::make('')->schema([
                            Rating::make('stadium_rating')
                                ->theme(RatingTheme::HalfStars)
                                ->stars(20)
                                ->allowZero()
                                ->size('xl')
                                ->color('info')
                        ])
                    ]),
                    Tab::make('Activities')->icon('heroicon-o-table-cells')->schema([
                        Fieldset::make('')->schema([
                            TinyEditor::make('services'),
                            TinyEditor::make('amenities'),
                            TinyEditor::make('features'),
                            TinyEditor::make('location_description'),
                            TinyEditor::make('facilities'),
                            TinyEditor::make('recreational_facilities'),
                            TinyEditor::make('restaurants'),
                            TinyEditor::make('bars'),
                            TinyEditor::make('themed_areas'),
                            TinyEditor::make('events'),
                        ])
                    ]),
                    Tab::make('Images')->icon('heroicon-o-photo')->schema([
                        Fieldset::make('')->schema([
                            FileUpload::make('photo_1')
                                ->image()
                                ->maxSize(140000000),
                            FileUpload::make('photo_2')
                                ->image()
                                ->maxSize(140000000),
                            FileUpload::make('photo_3')
                                ->image()
                                ->maxSize(140000000),
                        ])
                    ]),
                    //dd(Country::all()->pluck('name', 'id')->toArray()),

                    Tab::make('Location')->icon('heroicon-o-globe-alt')->schema([
                        Fieldset::make('')
                        ->schema([
                            Forms\Components\Select::make('country')
                                ->label('Country')
                                ->preload()
                                ->options(Country::all()->pluck('name', 'name')->toArray()) // Store the name
                                ->reactive()
                                ->afterStateUpdated(fn (callable $set) => $set('state', null))
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    ColorPicker::make('country_nacional_color'),
                                ])
                                ->createOptionUsing(fn ($data) => Country::create([
                                    'name' => $data['name'],
                                    'country_nacional_color' => $data['country_nacional_color'],
                                ])),
                            Forms\Components\Select::make('state')
                                ->label('State')
                                ->preload()
                                ->options(function (callable $get) {
                                    $country = Country::where('name', $get('country'))->first();
                                    if (!$country) {
                                        return State::all()->pluck('name', 'name'); // Store the name
                                    }
                                    return $country->states->pluck('name', 'name'); // Store the name
                                })
                                ->reactive()
                                ->afterStateUpdated(fn (callable $set) => $set('city', null))
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->label('Name'),
                                    Select::make('country_id')
                                    ->label('Countries')
                                        //->relationship('country','name')
                                        ->options(function (callable $get) {
                                            return Country::all()->pluck('name', 'id'); // Use 'id' for the value, 'name' for display
                                        })
                                ])
                                ->createOptionUsing(fn ($data) => State::create([
                                    'name' => $data['name'],
                                    'country_id' => $data['country_id'],
                                ])),

                            Forms\Components\Select::make('city')
                                ->label('City')
                                ->preload()
                                ->options(function (callable $get) {
                                    $state = State::where('name', $get('state'))->first();
                                    if (!$state) {
                                        return City::all()->pluck('name', 'name'); // Store the name
                                    }
                                    return $state->cities->pluck('name', 'name'); // Store the name
                                })
                                ->createOptionForm([
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
                                ->createOptionUsing(fn ($data) => City::create([
                                    'name' => $data['name'],
                                    'country' => $data['country'],
                                    'state_id' => $data['state_id'],
                                ])),


                            Forms\Components\TextInput::make('address')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('latitude')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('longitude')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('zip_code')
                                ->maxLength(255),
                        ]),
                    ]),
                    Tab::make('Standings')->icon('heroicon-o-cog-8-tooth')->schema([
                        Fieldset::make('')->schema([
                            Forms\Components\TextInput::make('capacity')
                                ->numeric(),
                            MoneyInput::make('construction_price')
                                ->currency('USD'),
                            Forms\Components\DatePicker::make('construction_start_date'),
                            Forms\Components\DatePicker::make('construction_end_date'),
                        ])
                    ]),
                    Tab::make('Sports')->icon('heroicon-o-book-open')->schema([
                        Fieldset::make('')->schema([
                            Select::make('sport_id')
                            ->relationship('sport','name')
                            ->label('Sports Played')
                            ->default('General')
                            ->multiple()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('description')
                                    ->maxLength(255),
                            ])
                        ]),
                    ]),
                    Tab::make('History')->icon('heroicon-o-book-open')->schema([
                        Fieldset::make('')->schema([
                            TinyEditor::make('history')
                                ->columnSpanFull(),
                        ])
                    ]),
                    Tab::make('Tenants')->icon('heroicon-o-user-group')->schema([
                        Fieldset::make('')->schema([
                            TagsInput::make('tenants')
                                ->separator(',')
                                ->columnSpanFull(),
                        ])
                    ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->recordClasses(fn(Stadium $record, Country $recordCountry) => match($record->country) {
            $recordCountry->name =>'border-l-2 m-4 bg-['.$recordCountry->country_nacional_color.']',
            default => 'border-l-2 m-4 bg-[#2D54D4]',
            false => null,
        })
        //->style(fn(Stadium $record) => 'background-color: ' . $record->country->country_nacional_color . ';')               
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                ImageColumn::make('photo_1')
                ->label('Picture')
                ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('zip_code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('website')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('photo_2')
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('photo_3')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->sortable(),
                MapColumn::make('location')
                    ->extraAttributes([
                      'class' => 'my-funky-class'
                    ]) // Optionally set any additional attributes, merged into the wrapper div around the image tag
                    ->extraImgAttributes(
                        fn ($record): array => ['title' => $record->latitude . ',' . $record->longitude]
                    ) // Optionally set any additional attributes you want on the img tag
                    ->height('150') // API setting for map height in PX
                    ->width('250') // API setting got map width in PX
                    ->type('hybrid') // API setting for map type (hybrid, satellite, roadmap, tarrain)
                    ->zoom(15) // API setting for zoom (1 through 20)
                    ->ttl(60 * 60 * 24 * 30), // number of seconds to cache image before refetching from API
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('construction_price')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('construction_start_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('construction_end_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->filters([
                Filter::make('country')
                ->form([
                    Select::make('country')
                        ->options(
                            Stadium::query()
                                ->distinct()
                                ->orderBy('country')
                                ->pluck('country', 'country')
                                ->toArray()
                        )
                        ->placeholder('Select a country')
                        ->reactive() // Makes the select box reactive
                        ->afterStateUpdated(function (callable $set) {
                            $set('state', null); // Reset state when country changes
                        }),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (!empty($data['country'])) {
                        return $query->where('country', $data['country']);
                    }
                    return $query;
                }),

            Filter::make('state')
                ->form([
                    Select::make('state')
                        ->options(function (callable $get) {
                            $country = $get('country');
                            if ($country) {
                                return Stadium::query()
                                    ->where('country', $country)
                                    ->distinct()
                                    ->orderBy('state')
                                    ->pluck('state', 'state')
                                    ->toArray();
                            }
                            return Stadium::query()
                                ->distinct()
                                ->orderBy('state')
                                ->pluck('state', 'state')
                                ->toArray();
                        })
                        ->placeholder('Select a state')
                        ->reactive() // Makes the select box reactive
                        ->afterStateUpdated(function (callable $set) {
                            $set('city', null); // Reset city when state changes
                        }),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (!empty($data['state'])) {
                        return $query->where('state', $data['state']);
                    }
                    return $query;
                }),

            Filter::make('city')
                ->form([
                    Select::make('city')
                        ->options(function (callable $get) {
                            $state = $get('state');
                            if ($state) {
                                return Stadium::query()
                                    ->where('state', $state)
                                    ->distinct()
                                    ->orderBy('city')
                                    ->pluck('city', 'city')
                                    ->toArray();
                            }
                            return Stadium::query()
                                ->distinct()
                                ->orderBy('city')
                                ->pluck('city', 'city')
                                ->toArray();
                        })
                        ->placeholder('Select a city'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (!empty($data['city'])) {
                        return $query->where('city', $data['city']);
                    }
                    return $query;
                }),
                Filter::make('Sport')
                ->form([
                    Select::make('Sport')
                        ->options(Sport::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray())
                        ->placeholder('Select a sport')
                        ->reactive(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (!empty($data['Sport'])) {
                        $query->whereHas('sport', function ($subQuery) use ($data) {
                            $subQuery->where('sport_id', $data['Sport']);
                        });
                    }
            
                    return $query;
                })
  
            ])
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter')
                    ->slideOver(),
            )
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('')
                ->tooltip('Edit'),
                Tables\Actions\DeleteAction::make()
                ->label('')
                ->tooltip('Delete'),
                Tables\Actions\RestoreAction::make()
                ->label(''),
                Tables\Actions\ForceDeleteAction::make()
                ->label(''),
                ActionsViewAction::make()
                ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getResourceView(): View
    {
        // Load the custom CSS for PostResource
        view()->share('custom_css', asset('css/stadium-resource.css'));

        return parent::getResourceView();
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\StadiumIndex::route('/'),
            'list' => Pages\ListStadia::route('/stadiums'),
            'create' => Pages\CreateStadium::route('/create'),
            'edit' => Pages\EditStadium::route('/{record}/edit'),
            'view' => Pages\ViewStadium::route('/{record}'),
        ];
    }
    public static function getWidgets(): array
    {
        return [
            StadiumMap::class,
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
