<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de eventos (instancias) existentes
        // Asegúrate que EventoSeeder se ejecute ANTES.
        $eventoInstanceIds = DB::table('eventos')->pluck('id')->toArray();

        if (empty($eventoInstanceIds)) {
            $this->command->warn('Por favor, ejecuta EventoSeeder primero o asegúrate de que la tabla eventos tenga datos.');
            return;
        }

        $imagesPerGallery = 5; // Cuántas imágenes de galería por instancia de evento

        foreach ($eventoInstanceIds as $eventoId) {
            for ($i = 0; $i < $imagesPerGallery; $i++) {
                DB::table('gallery_images')->insert([
                    'evento_id' => $eventoId,
                    'file_path' => 'gallery_images/placeholder_gallery_' . rand(1, 5) . '.jpg', // Rutas placeholder
                    'title' => 'Imagen de Galería ' . Str::ucfirst(Str::random(5)),
                    'caption' => 'Pie de foto para la imagen ' . ($i + 1) . ' del evento ' . $eventoId,
                    'sort_order' => $i,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
