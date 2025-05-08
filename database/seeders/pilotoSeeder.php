<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Necesario para Str::random
use Carbon\Carbon; // Necesario para las fechas

class pilotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('pilotos')->insert([
                'Nombre' => 'PilotoNombre ' . Str::random(5),
                'Apellidos' => 'Apellido ' . Str::random(8),
                'Descripcion' => 'Descripción del piloto ' . ($i + 1) . '. ' . Str::random(50),
                'Imagen' => null, // Campo de imagen vacío (null)
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}