<?php

namespace App\Filament\Resources\StadiumResource\Pages;

use App\Filament\Resources\StadiumResource;
use App\Filament\Widgets\StadiumsMap;
use App\Models\Stadium;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;

class StadiumIndex extends Page
{
    protected static string $resource = StadiumResource::class;

    protected static string $view = 'filament.resources.stadium-resource.pages.stadium-index';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Create new stadium')
                ->url(static::getResource()::getUrl('create'))
                ->icon('heroicon-o-plus-circle'),
            Action::make('List Stadiums')
                ->url(static::getResource()::getUrl('list'))
                ->icon('heroicon-o-plus-circle'),
        ];
    }
    protected function getViewData(): array
    {
        // Retrieve the stadium data with city information
        $stadiums = Stadium::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->get();
        return [
            'stadiums' => $stadiums,
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            StadiumsMap::class,
        ];
    }
}
