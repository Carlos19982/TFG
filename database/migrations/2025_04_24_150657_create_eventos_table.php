<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
            $table->string('imagen', 50);
            $table->string('descripcion', 255); // Crea un VARCHAR 'descripcion' con longitud máxima de 255
                                                // Si necesitas más espacio, considera usar ->text('descripcion');
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