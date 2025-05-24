<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            // Tu tabla 'eventos' ya tiene una columna 'id', 'nombre', 'imagen', 'descripcion', etc.
            // Añadimos las nuevas claves foráneas

            $table->foreignId('base_event_id')
                  ->nullable() // Permite nulos por si tienes datos existentes o un evento no siempre pertenece a un 'base_event'
                  ->after('id') // Opcional: para el orden de la columna
                  ->constrained('base_events')
                  ->onDelete('set null'); // O 'cascade', o 'restrict'

            $table->foreignId('season_id')
                  ->nullable() // Permite nulos por si tienes datos existentes o un evento no siempre pertenece a una 'season'
                  ->after('base_event_id') // Opcional: para el orden
                  ->constrained('seasons')
                  ->onDelete('set null'); // O 'cascade', o 'restrict'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            // Es importante eliminar las FKs antes que las columnas
            $table->dropForeign(['base_event_id']);
            $table->dropForeign(['season_id']);

            $table->dropColumn('base_event_id');
            $table->dropColumn('season_id');
        });
    }
};
