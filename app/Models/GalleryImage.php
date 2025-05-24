<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'evento_id', // Clave foránea a tu tabla 'eventos'
        'file_path',
        'title',
        'caption',
        'sort_order',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        // Listener para borrar el archivo físico cuando se elimina el registro
        static::deleting(function (GalleryImage $image) {
            if ($image->file_path) {
                Storage::disk('public')->delete($image->file_path);
            }
        });

        // Listener para borrar el archivo antiguo cuando se actualiza la imagen
        static::updating(function (GalleryImage $image) {
            // Verifica si el campo 'file_path' ha sido modificado
            if ($image->isDirty('file_path')) {
                // Obtiene la ruta del archivo original (antes de la actualización)
                $originalPath = $image->getOriginal('file_path');
                if ($originalPath) {
                    Storage::disk('public')->delete($originalPath);
                }
            }
        });
    }

    /**
     * Get the evento (instance) that owns the GalleryImage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evento(): BelongsTo // Se relaciona con tu modelo 'Eventos'
    {
        return $this->belongsTo(Eventos::class, 'evento_id');
    }
}
