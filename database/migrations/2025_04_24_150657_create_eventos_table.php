<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id(); // Crea una columna BIGINT UNSIGNED AUTO_INCREMENT 'id' (clave primaria)
            $table->string('nombre', 40); // Crea un VARCHAR 'nombre' con longitud máxima de 40
            $table->string('imagen', 50)->nullable(); // Crea un VARCHAR 'imagen' con longitud máxima de 50 y permite valores nulos
            $table->string('imagen2', 50)->nullable();
            $table->string('descripcion', 255); // Crea un VARCHAR 'descripcion' con longitud máxima de 255
            // Añadimos descripcion2, similar a descripcion, permitiendo nulos y después de 'descripcion'
            $table->string('descripcion2', 255)->nullable();
            // Añadimos el campo booleano 'finalizado'
            // Lo ponemos como no nulable y con valor por defecto 'false' (0)
            // Esto es importante para las filas existentes, que tomarán este valor por defecto.
            // Lo colocamos después de 'descripcion2'
            $table->boolean('finalizado')->default(false);
            $table->timestamps(); // Crea las columnas 'created_at' y 'updated_at' (TIMESTAMP NULLABLE)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
};