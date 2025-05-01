<?php

namespace App\Filament\Resources\EventosResource\Pages;

use App\Filament\Resources\EventosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventos extends ListRecords
{
    protected static string $resource = EventosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
