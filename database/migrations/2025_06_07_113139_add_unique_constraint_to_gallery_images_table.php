<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Primero, limpiar duplicados si existen
        $this->removeDuplicates();
        
        // Luego añadir la restricción única
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->unique(['evento_id', 'sort_order'], 'gallery_images_evento_sort_unique');
        });
    }

    public function down(): void
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->dropUnique('gallery_images_evento_sort_unique');
        });
    }
    
    private function removeDuplicates(): void
    {
        // Encontrar y corregir duplicados
        $duplicates = DB::select("
            SELECT evento_id, sort_order, COUNT(*) as count
            FROM gallery_images 
            GROUP BY evento_id, sort_order 
            HAVING COUNT(*) > 1
        ");
        
        foreach ($duplicates as $duplicate) {
            $images = DB::table('gallery_images')
                ->where('evento_id', $duplicate->evento_id)
                ->where('sort_order', $duplicate->sort_order)
                ->orderBy('id')
                ->get();
            
            // Mantener el primero, renumerar los demás
            foreach ($images->skip(1) as $index => $image) {
                $maxSort = DB::table('gallery_images')
                    ->where('evento_id', $duplicate->evento_id)
                    ->max('sort_order');
                
                DB::table('gallery_images')
                    ->where('id', $image->id)
                    ->update(['sort_order' => $maxSort + 1 + $index]);
            }
        }
    }
};