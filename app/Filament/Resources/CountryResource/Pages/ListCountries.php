<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Imports\CountryImporter;
use App\Filament\Resources\CountryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ImportAction;

class ListCountries extends ListRecords
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make('Country')
                    ->importer(CountryImporter::class),
            
        ];
    }
}
