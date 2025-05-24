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
        // Basado en: 2025_04_24_150611_create_pilotos_table.php
        Schema::create('pilotos', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre', 40);
            $table->string('Apellidos', 40);
            $table->string('Frase',255);
            $table->string('Descripcion', 255);
            $table->text('Imagen')->nullable();
            $table->timestamps();
        });

        // Basado en: 2025_05_24_114054_create_base_events_table.php
        Schema::create('base_events', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Basado en: 2025_05_24_114617_create_seasons_table.php
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Basado en: 2025_04_24_150657_create_eventos_table.php
        // y 2025_05_24_152405_alter_eventos_table_increase_nombre_length.php
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255); // Longitud ya ajustada
            $table->text('imagen')->nullable();
            $table->text('imagen2')->nullable();
            $table->string('descripcion', 255);
            $table->string('descripcion2', 255)->nullable();
            $table->boolean('finalizado')->default(false);
            // Las columnas base_event_id y season_id se añadirán en la siguiente migración
            // para asegurar que las tablas base_events y seasons ya existan.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // El orden de drop es importante debido a las futuras claves foráneas
        Schema::dropIfExists('eventos'); // Dependerá de base_events y seasons
        Schema::dropIfExists('seasons');
        Schema::dropIfExists('base_events');
        Schema::dropIfExists('pilotos');
    }
};
