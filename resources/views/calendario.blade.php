{{-- resources/views/calendario.blade.php --}}

@extends('layout.plantilla')
@section('title', 'Calendario')
@section('content')

<section class="calendario-section py-5">
    <div class="container">
        {{-- Contenedor Flex para el Título y el Buscador --}}
        <div class="d-flex flex-wrap justify-content-center align-items-center mb-5 position-relative">
            {{-- Título Centrado --}}
            <div class="section-title-div text-center mx-auto py-2">
                <h2 class="section-title unique-font mb-0">CALENDARIO DE EVENTOS</h2>
            </div>

            {{-- Buscador a la Derecha --}}
            {{-- No mostrar el buscador si estamos en una vista de "show" individual (poco probable aquí, pero por consistencia) --}}
            @if(!isset($isSingleShowView) || !$isSingleShowView) {{-- Puedes omitir esta condición si no aplica --}}
            <div class="search-form-container ms-md-auto mt-3 mt-md-0">
                <form action="{{ route('calendario.index') }}" method="POST" class="d-flex"> {{-- Asegúrate que 'calendario.index' es la ruta correcta --}}
                    @csrf
                    <input type="text"
                           name="termino_busqueda"
                           class="form-control form-control-sm me-2"
                           placeholder="Buscar evento..."
                           value="{{ $searchTerm ?? '' }}"
                           aria-label="Buscar evento">
                    {{-- Botones con las clases personalizadas de tu CSS global --}}
                    <button type="submit" class="btn btn-sm btn-buscar-custom">Buscar</button>
                    
                    @if(isset($searchTerm) && $searchTerm)
                    <a href="{{ route('calendario.index') }}" class="btn btn-sm btn-limpiar-custom ms-2">Limpiar</a>
                    @endif
                </form>
            </div>
            @endif
        </div>
        {{-- Fin del Contenedor Flex para Título y Buscador --}}


        @if(isset($error) && empty($eventos->items())) {{-- Mostrar error solo si no hay eventos que mostrar Y hay un error --}}
        <div class="alert alert-danger text-center" role="alert">
            {{ $error }}
        </div>
        @endif

        <div class="row g-4">
            @forelse ($eventos as $evento)
            <div class="col-12 col-md-4"> {{-- Ajusta col-md-X si paginate(Y) cambia mucho el número de items por fila --}}
                <a href="{{ route('calendario.informacion', ['id' => $evento->id]) }}" class="event-link"
                    aria-label="Detalles {{ $evento->nombre }}">
                    <div class="card h-100">
                        <img src="{{ $evento->imagen ? Storage::url($evento->imagen) : Storage::url('eventos-imagenes/EventoBase4-5.png') }}"
                            class="card-img-top" alt="Portada del evento {{ $evento->nombre }}"
                            style="filter: grayscale({{ $evento->finalizado ? 1 : 0 }});">
                        <div class="card-footer">
                            <p class="competition-name text-center mb-0">{{ $evento->nombre }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
                {{-- Mensaje si no hay eventos, o si la búsqueda no arrojó resultados --}}
                @if(isset($searchTerm) && $searchTerm)
                    <div class="col-12">
                        <p class="text-center alert alert-warning">No se encontraron eventos que coincidan con "<strong>{{ $searchTerm }}</strong>".</p>
                    </div>
                @elseif (!isset($error)) {{-- Solo muestra este si no hay un error general --}}
                    <div class="col-12">
                        <p class="text-center alert alert-info">No hay eventos próximos en el calendario.</p>
                    </div>
                @endif
            @endforelse
        </div>

        {{-- ENLACES DE PAGINACIÓN --}}
        @if ($eventos->hasPages())
        <div class="mt-5 d-flex justify-content-end">
            {{-- Los enlaces ya incluirán 'termino_busqueda' si está presente, gracias a appends() en el controlador --}}
            {{ $eventos->links() }}
        </div>
        @endif
    </div>
</section>

@endsection