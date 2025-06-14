<?php

namespace App\Http\Controllers;

use App\Models\BaseEvent;
use App\Models\Eventos;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Muestra la página de lista 'galeria.blade.php'.
     */
    public function index(Request $request): View
    {
        $searchTerm = $request->input('termino_busqueda');
        $query = BaseEvent::query();

        $query->whereHas('eventos.galleryImages');

        $query->with([
            'eventos' => function ($seasonQuery) {
                $seasonQuery->with(['galleryImages' => function ($imageQuery) {
                    $imageQuery->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
                }])->orderBy('season_id', 'desc');
            }
        ]);

        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $baseEventsList = $query->orderBy('name', 'asc')->paginate(10);

        return view('galeria', [
            'baseEventsList' => $baseEventsList,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Muestra la galería de imágenes para una temporada (Eventos) específica,
     * OMITIENDO LA PRIMERA IMAGEN (que se usa como portada).
     *
     * @param Eventos $eventoInstancia La instancia del evento obtenida por Route Model Binding.
     * @return View
     */
    public function showSeasonGallery(Eventos $eventoInstancia): View
    {
        // 1. Cargar la relación 'baseEvent' para el título.
        //    Cargar todas las imágenes ordenadas.
        $eventoInstancia->load(['baseEvent', 'galleryImages' => function ($query) {
            $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
        }]);

        // 2. Obtener la colección completa de imágenes.
        $allImages = $eventoInstancia->galleryImages;

        // 3. ¡CAMBIO CLAVE! Crear una nueva colección que empieza desde el segundo elemento.
        //    El método slice(1) omite el primer elemento (índice 0).
        $imagesForGrid = $allImages->slice(1);

        // 4. Devolver la vista 'galeriageneral' con la colección ya filtrada.
        return view('galeriageneral', [
            'eventoInstancia' => $eventoInstancia,
            'galleryImagesToShow' => $imagesForGrid, // <--- Pasamos la colección sin la primera foto
            'pageTitle' => 'Galería: ' . $eventoInstancia->baseEvent->name . ' - ' . $eventoInstancia->nombre
        ]);
    }
}