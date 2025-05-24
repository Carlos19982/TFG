<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BaseEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseEventNames = [
            'Gran Premio de España',
            'Campeonato de Resistencia Local',
            'Rally de la Sierra',
            'Encuentro Clásicos Americanos',
            'Exhibición de Superdeportivos'
        ];

        foreach ($baseEventNames as $name) {
            DB::table('base_events')->insert([
                'name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
