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

    // Sobrescribimos el método para manejar la lógica de reordenamiento
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $originalSortOrder = $record->getOriginal('sort_order');
        $newSortOrder = (int) ($data['sort_order'] ?? $originalSortOrder);
        $eventoId = $data['evento_id'] ?? $record->evento_id; // Asegurarse de tener el evento_id

        // Solo actuar si el sort_order ha cambiado y es diferente
        if ($newSortOrder !== $originalSortOrder) {
            DB::transaction(function () use ($record, $eventoId, $originalSortOrder, $newSortOrder, $data) {
                // Si el nuevo orden es MENOR que el original (la imagen sube en la lista)
                if ($newSortOrder < $originalSortOrder) {
                    // Incrementar el orden de las imágenes entre el nuevo y el antiguo orden
                    GalleryImage::where('evento_id', $eventoId)
                        ->where('id', '!=', $record->id) // No afectar a la imagen actual
                        ->where('sort_order', '>=', $newSortOrder)
                        ->where('sort_order', '<', $originalSortOrder)
                        ->increment('sort_order');
                }
                // Si el nuevo orden es MAYOR que el original (la imagen baja en la lista)
                elseif ($newSortOrder > $originalSortOrder) {
                    // Decrementar el orden de las imágenes entre el antiguo y el nuevo orden
                    GalleryImage::where('evento_id', $eventoId)
                        ->where('id', '!=', $record->id) // No afectar a la imagen actual
                        ->where('sort_order', '<=', $newSortOrder)
                        ->where('sort_order', '>', $originalSortOrder)
                        ->decrement('sort_order');
                }
                // Actualizar el registro actual con todos los datos del formulario
                // (incluyendo el nuevo sort_order y cualquier otro campo modificado)
                $record->update($data);
            });
        } else {
            // Si el sort_order no cambió, simplemente actualiza el registro
            $record->update($data);
        }

        return $record;
    }
}
