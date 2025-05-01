<?php

namespace App\Filament\Resources\EventoPilotoResource\Pages;

use App\Filament\Resources\EventoPilotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventoPilotos extends ListRecords
{
    protected static string $resource = EventoPilotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
