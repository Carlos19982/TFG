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
     * Muestra la página principal de galerías, listando cada Evento Base
     * con un carrusel de sus temporadas asociadas.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $searchTerm = $request->input('termino_busqueda');
        $query = BaseEvent::query();

        // Asegurarnos de que solo traemos eventos que tengan temporadas con imágenes.
        $query->whereHas('eventos.galleryImages');

        // Cargar las relaciones necesarias de forma eficiente
        $query->with([
            // Para cada BaseEvent, cargar sus 'eventos' (temporadas)
            'eventos' => function ($seasonQuery) {
                // Para cada temporada, cargar solo su primera imagen (para la portada del carrusel)
                $seasonQuery->with(['galleryImages' => function ($imageQuery) {
                    $imageQuery->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
                }])->orderBy('season_id', 'desc'); // Ordenar temporadas, de la más nueva a la más antigua
            }
        ]);

        // Aplicar búsqueda si existe
        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Paginar los resultados de los Eventos Base
        $baseEventsList = $query->orderBy('name', 'asc')->paginate(10);

        // Devolver la vista principal 'galeria' con la lista de eventos base.
        return view('galeria', [
            'baseEventsList' => $baseEventsList,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Muestra la galería de imágenes para una temporada (Eventos) específica.
     *
     * @param Eventos $eventoInstancia La instancia del evento obtenida por Route Model Binding.
     * @return View
     */
    public function showSeasonGallery(Eventos $eventoInstancia): View
    {
        // Cargar la relación 'baseEvent' para poder usar su nombre.
        // Cargar todas las imágenes de la galería para esta temporada.
        $eventoInstancia->load(['baseEvent', 'galleryImages' => function ($query) {
            $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
        }]);

        // La vista 'galeriageneral.blade.php' se encargará de mostrar las imágenes.
        return view('galeriageneral', [
            'eventoInstancia' => $eventoInstancia,
            // Pasamos la colección completa de imágenes
            'galleryImagesToShow' => $eventoInstancia->galleryImages,
            'pageTitle' => 'Galería: ' . $eventoInstancia->baseEvent->name . ' - ' . $eventoInstancia->nombre
        ]);
    }
}