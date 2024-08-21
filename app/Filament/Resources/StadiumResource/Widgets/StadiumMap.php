<?php

namespace App\Filament\Resources\StadiumResource\Widgets;

use App\Models\Stadium;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapWidget;

class StadiumMap extends MapWidget
{
    protected static ?string $heading = 'Map';

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    protected static ?bool $clustering = true;

    protected static ?bool $fitToBounds = true;

    protected static ?int $zoom = 5;
    protected static ?string $height = '600px'; // Increased height
    protected static ?string $width = '2900px';   
    protected static ?string $maxHeight = '2900px';
    protected function getData(): array
    {
        $locations = Stadium::all();

        $data = [];

        foreach ($locations as $location)
        {
            $data[] = [
                'location'  => [
                    'lat' => $location->latitude ? round(floatval($location->latitude), static::$precision) : 0,
                    'lng' => $location->longitude ? round(floatval($location->longitude), static::$precision) : 0,
                ],
                
                // Use the stadium's name as the label
                'label'     => $location->name, 
                
                // Custom icon (optional)
                'icon' => [
                    'url' => url('images/dealership.svg'),
                    'type' => 'svg',
                    'scale' => [35, 35],
                ],
            ];
        }

        return $data;
    }
}
