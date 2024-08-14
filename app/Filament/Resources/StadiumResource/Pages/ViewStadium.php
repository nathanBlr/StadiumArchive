<?php

namespace App\Filament\Resources\StadiumResource\Pages;

use App\Filament\Resources\StadiumResource;
use Filament\Actions;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewStadium extends ViewRecord
{
    protected static string $resource = StadiumResource::class;
    public function infolist(Infolist $infolist): Infolist
    {
                return $infolist
                    ->schema([
                        Section::make([
                            TextEntry::make('name')
                            ->label('name')
                            ->size('lg')
                            ->weight('bold')
                            ->hiddenLabel(), 
                        ImageEntry::make('photo_1')
                            ->view('stadium-image'),
                        TextEntry::make('history')
                            ->hiddenLabel()
                            ->html()
                            ->alignJustify(),
                        ])->columnSpan(2),
                        Section::make([
                            Group::make([
                                TextEntry::make('created_at')
                                ->date(),
                                TextEntry::make('updated_at')
                                ->date(),
                            ])
                        ])->columns(2)
                        
                        
                    ]);
    }
}
