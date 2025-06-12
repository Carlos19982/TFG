<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use App\Models\GalleryImage; // Importar el modelo
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Para transacciones

class EditGalleryImage extends EditRecord
{
    protected static string $resource = GalleryImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $originalSortOrder = $record->getOriginal('sort_order');
        $newSortOrder = (int) ($data['sort_order'] ?? $originalSortOrder);
        $eventoId = $record->evento_id;

        DB::transaction(function () use ($record, $data, $eventoId, $originalSortOrder, $newSortOrder) {
            if ($newSortOrder === $originalSortOrder) {
                $record->update($data);
                return;
            }

            // 1. Mover temporalmente el registro a un valor que no interfiere (-1).
            // Esto LIBERA su posición original y evita cualquier conflicto.
            $record->update(['sort_order' => 0]);

            // 2. Mover los otros registros.
            if ($newSortOrder < $originalSortOrder) {
                // MOVER HACIA ARRIBA (ej. pos 5 -> 2)
                GalleryImage::where('evento_id', $eventoId)
                    ->whereBetween('sort_order', [$newSortOrder, $originalSortOrder - 1])
                    ->increment('sort_order');

            } else { // ($newSortOrder > $originalSortOrder)
                // MOVER HACIA ABAJO (ej. pos 2 -> 5)
                GalleryImage::where('evento_id', $eventoId)
                    ->whereBetween('sort_order', [$originalSortOrder + 1, $newSortOrder])
                    ->decrement('sort_order');
            }

            // 3. Aplicar los datos finales, incluyendo la nueva posición.
            $record->update($data);
        });

        return $record->refresh();
    }
}
