<?php

namespace App\Http\Controllers;

use App\Models\BaseEvent;
use App\Models\Eventos; // Asegúrate de importar tu modelo Eventos (o Season si ese es el que usas para las instancias)
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(): View
    {
        $baseEvents = BaseEvent::with([
            'eventos' => function ($query) {
                $query->with(['season', /*'galleryImages'*/ // Ya no es necesario cargar todas aquí si solo mostramos una
                    'galleryImages' => function ($galleryQuery) {
                        $galleryQuery->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
                    }
                ])
                ->orderBy('season_id');
            }
        ])
        ->orderBy('name', 'asc')
        ->get();

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

    /**
     * Muestra la galería de imágenes para una instancia de evento (temporada) específica.
     *
     * @param Eventos $eventoInstancia La instancia del evento obtenida por Route Model Binding.
     * @return View
     */
    public function showSeasonGallery(Eventos $eventoInstancia): View
    {
        // 1. Cargar TODAS las imágenes de la galería para esta instancia de evento,
        // ASEGURÁNDONOS DEL ORDEN CORRECTO.
        // Este orden debe ser el mismo que usas para determinar la "primera" imagen para el carrusel.
        $eventoInstancia->load(['galleryImages' => function ($query) {
            $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc'); // Ordena por sort_order, luego por id como desempate
        }]);

        // 2. Obtener la colección completa de imágenes ordenadas.
        $allImages = $eventoInstancia->galleryImages;

        // 3. Crear una nueva colección que omite el primer elemento (la portada del carrusel).
        //    Si $allImages está vacía o solo tiene un elemento, $imagesToShow será una colección vacía.
        $imagesToShow = $allImages->slice(1);

        return view('galeriageneral', [
            'eventoInstancia' => $eventoInstancia,
            'galleryImagesToShow' => $imagesToShow, // Esta es la colección que la vista debe usar
            'pageTitle' => 'Galería de ' . $eventoInstancia->nombre
        ]);
    }
}