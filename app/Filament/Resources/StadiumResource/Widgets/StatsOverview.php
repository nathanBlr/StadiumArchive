<?php

namespace App\Filament\Resources\StadiumResource\Widgets;

use App\Models\Sport;
use App\Models\Stadium;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{   
    use InteractsWithPageFilters;
    protected static ?string $pollingInterval = '10s';
    protected function getStats(): array
    {    
        $countryWithMostStadiums = Stadium::select('country', DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderByDesc('total')
            ->first();
        $label = $countryWithMostStadiums ? $countryWithMostStadiums->country : 'N/A';
        $value = $countryWithMostStadiums ? $countryWithMostStadiums->total : 0;
        //
        $stateWithMostStadiums = Stadium::select('state', DB::raw('count(*) as total'))
            ->groupBy('state')
            ->orderByDesc('total')
            ->first();
        $labelState = $stateWithMostStadiums ? $stateWithMostStadiums->state: 'N/A';
        $valueState = $stateWithMostStadiums ? $stateWithMostStadiums->total : 0;
        //
        $cityWithMostStadiums = Stadium::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->first();
        $labelCity = $cityWithMostStadiums ? $cityWithMostStadiums->city: 'N/A';
        $valueCity = $cityWithMostStadiums ? $cityWithMostStadiums->total : 0;
        //
        $mostSport = Sport::select('name',DB::raw('count(*) as total'))
        ->groupBy('name')
        ->orderByDesc('total')
        ->first();
        $labelSport = $mostSport ? $mostSport->name: 'N/A';
        $valueSport = $mostSport ? $mostSport->total : 0;
        //
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
       return  [
            Stat::make(
                label: 'Total New Stadiums',
                value: Stadium::query()
                    ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            )->description('New Stadiums')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
            Stat::make(
                label: 'Total Stadiums',
                value: Stadium::count(),
            )->description('Total Stadiums')
            ->chart([27, 2, 10, 13, 15, 4, 17])
            ->color('info'),
            Stat::make(
                label: 'Country With Most Stadiums',
                value: "$label: $value"
            )->description('Highest number of stadiums by country')
             ->descriptionIcon('heroicon-m-arrow-trending-up')
             ->chart([3, 2 ,78 ,2 , 3, 12, 4])
             ->color('success'),
             Stat::make(
                label: 'State With Most Stadiums',
                value: "$labelState: $valueState"
            )->description('Highest number of stadiums by state')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
             ->chart([30, 26 ,18 ,24 , 35, 12, 48])
             ->color('danger'),
            Stat::make(
                label: 'City With Most Stadiums',
                value: "$labelCity: $valueCity"
            )->description('Highest number of stadiums by City')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
             ->chart([30, 56 ,28 ,24 , 35, 22, 18])
             ->color('secondary'),
            Stat::make(
                label: 'Most present sport',
                value: "$labelSport: $valueSport"
            )
            ->description('Most present sport')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
             ->chart([30, 56 ,28 ,24 , 35, 22, 18])
             ->color('primary'),
       ];
    }
}
