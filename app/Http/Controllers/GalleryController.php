<?php

namespace App\Http\Controllers;

use App\Models\BaseEvent;
use App\Models\Eventos; // Asegúrate de importar tu modelo Eventos (o Season si ese es el que usas para las instancias)
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // GalleryController.php

public function index(Request $request): View
{
    // 1. Obtener el término de búsqueda del request
    $searchTerm = $request->input('termino_busqueda');

    // 2. Iniciar la consulta base para el modelo BaseEvent
    $query = BaseEvent::query();

    // 3. Aplicar relaciones y filtros necesarios
    //    Es más eficiente filtrar los que no tienen eventos asociados a nivel de base de datos
    //    usando has().
    $query->whereHas('eventos')
        ->with(['eventos' => function ($query) {
            $query->with(['galleryImages' => function ($galleryQuery) {
                $galleryQuery->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
            }])->orderBy('season_id');
        }]);

    // 4. Si hay un término de búsqueda, aplicar el filtro por nombre
    if ($searchTerm) {
        $query->where('name', 'LIKE', "%{$searchTerm}%");
    }

    // 5. Ordenar los resultados y paginarlos en lugar de usar get()
    $baseEventsList = $query->orderBy('name', 'asc')->paginate(5); // Paginamos, por ejemplo, de 5 en 5

    // 6. Si hay un término de búsqueda, añadirlo a los enlaces de paginación
    if ($searchTerm) {
        $baseEventsList->appends(['termino_busqueda' => $searchTerm]);
    }

    // 7. Pasar los datos a la vista
    return view('galeria', [
        'baseEventsList' => $baseEventsList,
        'searchTerm' => $searchTerm // Pasar el término para repoblar el campo de búsqueda
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