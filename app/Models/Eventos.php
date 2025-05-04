<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Asegúrate de importar BelongsToMany
use Illuminate\Support\Facades\Storage;

class Eventos extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    // protected $table = 'eventos';

    /**
     * @var bool
     */
    // public $timestamps = true;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'imagen2',         // Incluir los nuevos campos si son fillable
        'descripcion2',    // Incluir los nuevos campos si son fillable
        'finalizado',      // Incluir los nuevos campos si son fillable (si se asignan masivamente)
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'finalizado' => 'boolean', // Asegúrate de castear el campo booleano
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::deleting(function (Eventos $evento) {
            if ($evento->imagen) {
                Storage::disk('public')->delete($evento->imagen);
            }
             // Añadir limpieza para imagen2 si existe
             if ($evento->imagen2) {
                 Storage::disk('public')->delete($evento->imagen2);
             }
        });

        static::updating(function (Eventos $evento) {
            if ($evento->isDirty('imagen')) {
                $rutaImagenOriginal = $evento->getOriginal('imagen');
                if ($rutaImagenOriginal) {
                    Storage::disk('public')->delete($rutaImagenOriginal);
                }
            }
             // Añadir limpieza para imagen2 si se modifica
             if ($evento->isDirty('imagen2')) {
                 $rutaImagenOriginal2 = $evento->getOriginal('imagen2');
                 if ($rutaImagenOriginal2) {
                     Storage::disk('public')->delete($rutaImagenOriginal2);
                 }
             }
        });
    }

    /**
     * Los pilotos que participan en este evento.
     */
    public function pilotos(): BelongsToMany
    {
        return $this->belongsToMany(
                Pilotos::class,
                'evento_piloto',
                'evento_id',    // Clave de Eventos en tabla pivote
                'piloto_id'     // Clave de Pilotos en tabla pivote
            )
            ->using(EventoPiloto::class)
            ->withPivot('id', 'fecha_registro')
            ->withTimestamps(); // Asume que la tabla pivote tiene timestamps
    }
}