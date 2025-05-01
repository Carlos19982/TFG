<?php

namespace App\Filament\Resources\EventoPilotoResource\Pages;

use App\Filament\Resources\EventoPilotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventoPiloto extends EditRecord
{
    protected static string $resource = EventoPilotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
