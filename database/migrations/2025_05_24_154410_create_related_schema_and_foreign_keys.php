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
        // Modificar tabla eventos para añadir FKs
        // Basado en: 2025_05_24_115142_add_base_event_and_season_to_eventos_table.php
        Schema::table('eventos', function (Blueprint $table) {
            $table->foreignId('base_event_id')
                  ->nullable()
                  ->after('id') // Colocar después de 'id' para orden
                  ->constrained('base_events')
                  ->onDelete('set null'); // O la política que prefieras (cascade, restrict)

            $table->foreignId('season_id')
                  ->nullable()
                  ->after('base_event_id') // Colocar después de 'base_event_id'
                  ->constrained('seasons')
                  ->onDelete('set null'); // O la política que prefieras
        });

        // Crear tabla evento_piloto (con índices)
        // Basado en: 2025_05_01_102500_create_evento_piloto_table.php
        // y 2025_05_02_155032_add_indexes_to_evento_piloto_table.php
        Schema::create('evento_piloto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piloto_id')->constrained('pilotos')->onDelete('cascade');
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');
            $table->timestamp('fecha_registro')->nullable();
            $table->timestamps();

            // Añadir índices directamente
            $table->index('piloto_id');
            $table->index('evento_id');
            $table->index('fecha_registro');
        });

        // Crear tabla gallery_images
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();
            
            // Índice único compuesto para evitar duplicados
            $table->unique(['evento_id', 'sort_order']);
            
            // Índices para mejorar rendimiento
            $table->index(['evento_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_images');

        // Para evento_piloto, si se borra la tabla, los índices se van con ella.
        // Si solo se borraran columnas o FKs, el dropIndex sería relevante.
        Schema::dropIfExists('evento_piloto');

        Schema::table('eventos', function (Blueprint $table) {
            // Es importante eliminar las FKs antes que las columnas
            // si las columnas no se eliminan con dropForeign automáticamente (depende del SGBD)
            if (Schema::hasColumn('eventos', 'base_event_id')) { // Comprobar si la columna existe antes de intentar borrar FK
                $table->dropForeign(['base_event_id']);
            }
            if (Schema::hasColumn('eventos', 'season_id')) {
                $table->dropForeign(['season_id']);
            }
            // Luego eliminar las columnas
            $table->dropColumn(['base_event_id', 'season_id']);
        });
        // La tabla 'eventos' en sí se borra en la migración anterior 'down()'
    }
};
