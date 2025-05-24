<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
                // Primero los datos base
            BaseEventSeeder::class,      // Nuevo
            SeasonSeeder::class,         // Nuevo
            PilotoSeeder::class,         // Ya existía (pilotoSeeder)
            EventoSeeder::class,         // Ya existía (eventoSeeder, ahora crea instancias)

                // Luego las relaciones y datos dependientes
            evento_pilotoSeeder::class,   // Ya existía (evento_pilotoSeeder)
            GalleryImageSeeder::class,   // Nuevo
        ]);

        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
