<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PilotoSeeder extends Seeder // Nombre de clase como lo tienes: pilotoSeeder
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
                'Frase' => 'Frase del piloto '. ($i + 1). '. '. Str::random(20),
                'Descripcion' => 'Descripción del piloto ' . ($i + 1) . '. ' . Str::random(50),
                'Imagen' => 'pilotos-fotos/placeholder_piloto.png', // Ruta placeholder
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
