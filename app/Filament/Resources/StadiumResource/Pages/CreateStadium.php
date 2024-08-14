<?php

namespace App\Filament\Resources\StadiumResource\Pages;

use App\Filament\Resources\StadiumResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;
class CreateStadium extends CreateRecord
{
    protected static string $resource = StadiumResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Action::make('return')
                ->label('')
                ->icon('heroicon-o-arrow-uturn-left')
                ->url($this->getRedirectUrl()),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
