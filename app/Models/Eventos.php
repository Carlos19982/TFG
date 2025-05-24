<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;      // Añadir para BaseEvent y Season
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;         // Añadir para GalleryImage
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str; // No lo usaremos directamente si el nombre es manual o generado en Filament

class Eventos extends Model
{
    use HasFactory;

    // protected $table = 'eventos'; // No es necesario si el nombre de la clase es el plural de la tabla

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'imagen2',
        'descripcion2',
        'finalizado',
        'base_event_id', // Nueva clave foránea
        'season_id',     // Nueva clave foránea
        // 'event_date', // Si tienes este campo para la fecha específica de la instancia
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'finalizado' => 'boolean',
        // 'event_date' => 'date', // Si tienes este campo
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        // Lógica existente para borrar 'imagen' e 'imagen2'
        static::deleting(function (Eventos $evento) {
            if ($evento->imagen) {
                Storage::disk('public')->delete($evento->imagen);
            }
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
            if ($evento->isDirty('imagen2')) {
                $rutaImagenOriginal2 = $evento->getOriginal('imagen2');
                if ($rutaImagenOriginal2) {
                    Storage::disk('public')->delete($rutaImagenOriginal2);
                }
            }
        });

        // Lógica para generar el nombre (opcional, si quieres que se haga automáticamente)
        // Se podría hacer también en el Resource de Filament antes de guardar.
        // static::saving(function (Eventos $evento) {
        //     if (empty($evento->nombre) && $evento->base_event_id && $evento->season_id) {
        //         $baseEventName = $evento->baseEvent->name ?? 'Evento'; // Carga la relación
        //         $seasonName = $evento->season->name ?? 'Temporada'; // Carga la relación
        //         $evento->nombre = $baseEventName . ' - ' . $seasonName;
        //     } elseif (empty($evento->nombre) && $evento->base_event_id) {
        //         $evento->nombre = $evento->baseEvent->name ?? 'Evento';
        //     }
        //     // Si el nombre ya viene del formulario, no se sobrescribe.
        // });
    }

    /**
     * Get the base event that this event instance belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function baseEvent(): BelongsTo
    {
        return $this->belongsTo(BaseEvent::class, 'base_event_id');
    }

    /**
     * Get the season that this event instance belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'season_id');
    }

    /**
     * Get all of the gallery images for the Evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleryImages(): HasMany
    {
        return $this->hasMany(GalleryImage::class, 'evento_id');
    }

    /**
     * Los pilotos que participan en este evento.
     * (Esta relación ya la tenías y sigue siendo válida)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pilotos(): BelongsToMany
    {
        return $this->belongsToMany(
                Pilotos::class,
                'evento_piloto', // Nombre de tu tabla pivote
                'evento_id',    // Clave de Eventos en tabla pivote
                'piloto_id'     // Clave de Pilotos en tabla pivote
            )
            ->using(EventoPiloto::class) // Si usas modelo Pivote personalizado
            ->withPivot('id', 'fecha_registro') // Campos extra de la tabla pivote
            ->withTimestamps(); // Asume que la tabla pivote tiene timestamps
    }
}
