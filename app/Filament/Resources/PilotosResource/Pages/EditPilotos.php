<?php

namespace App\Filament\Resources\PilotosResource\Pages;

use App\Filament\Resources\PilotosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPilotos extends EditRecord
{
    protected static string $resource = PilotosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
