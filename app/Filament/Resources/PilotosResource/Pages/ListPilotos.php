<?php

namespace App\Filament\Resources\PilotosResource\Pages;

use App\Filament\Resources\PilotosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPilotos extends ListRecords
{
    protected static string $resource = PilotosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
