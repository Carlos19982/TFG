<?php

namespace App\Http\Controllers;

use App\Models\BaseEvent;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(): View
    {
        $baseEvents = BaseEvent::with([
            'eventos' => function ($query) {
                $query->with(['season', 'galleryImages' => function ($galleryQuery) {
                    // Opcional: Ordenar las imágenes de la galería si quieres la "primera" basada en un orden específico
                    $galleryQuery->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
                }])
                ->orderBy('season_id'); // O como prefieras ordenar las instancias de evento
            }
        ])
        ->orderBy('name', 'asc')
        ->get();

        // Filtrar BaseEvents que no tengan instancias de evento,
        // o cuyas instancias de evento no tengan imágenes de galería (si decides filtrar aquí)
        $baseEvents = $baseEvents->filter(function ($baseEvent) {
            if ($baseEvent->eventos->isEmpty()) {
                return false;
            }
          
            return true;
        });

        return view('galeria', [
            'baseEventsList' => $baseEvents,
        ]);
    }
}