<?php

namespace App\Filament\Widgets;

use App\Models\Stadium;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class StadiumsMap extends Widget
{
    protected static string $view = 'filament.widgets.stadiums-map';

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
}
