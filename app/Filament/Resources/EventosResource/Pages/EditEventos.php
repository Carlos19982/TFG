<?php

namespace App\Filament\Resources\EventosResource\Pages;

use App\Filament\Resources\EventosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventos extends EditRecord
{
    protected static string $resource = EventosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
