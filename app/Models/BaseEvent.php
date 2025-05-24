<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaseEvent extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'base_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get all of the event instances for the BaseEvent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventos(): HasMany // Nombre de la relación para acceder a las instancias (tu tabla 'eventos')
    {
        // Se relaciona con tu modelo 'Eventos' existente
        return $this->hasMany(Eventos::class, 'base_event_id');
    }
}
