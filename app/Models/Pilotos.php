<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pilotos extends Model
{
    use HasFactory;
    protected $table = 'pilotos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'Nombre',
        'Apellidos',
        'Descripcion'
    ];

    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(
            Eventos::class,           // Modelo relacionado
            'evento_piloto',         // Tabla pivote
            'piloto_id',             // Clave foránea de Piloto en tabla pivote
            'evento_id'              // Clave foránea de Evento en tabla pivote
        )->withPivot('id','FechaRegistro'); // Incluir campo extra de la tabla pivote
           
    }
}
