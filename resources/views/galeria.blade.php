{{-- galeria.blade.php --}}
@extends('layout.plantilla')

@section('title', 'Galería de Eventos')

@section('content')
    <main class="container mt-5 mb-5">

        {{-- ========================================================== --}}
        {{-- INICIO: Formulario de Búsqueda (similar al de pilotos) --}}
        {{-- ========================================================== --}}
        <div class="d-flex flex-wrap justify-content-center align-items-center mb-5 position-relative">
            {{-- Título Centrado --}}
            <div class="section-title-div text-center mx-auto py-2">
                <h1 class="section-title first-title mb-0">GALERÍA DE EVENTOS</h1>
            </div>

            {{-- Buscador a la Derecha --}}
            <div class="search-form-container ms-md-auto mt-3 mt-md-0">
                {{-- Apunta a la ruta del índice de la galería --}}
                <form action="{{ route('galeria.index') }}" method="GET" class="d-flex">
                    {{-- Usar GET es más apropiado para búsquedas --}}
                    <input type="text" name="termino_busqueda" class="form-control form-control-sm me-2"
                        placeholder="Buscar evento..." value="{{ $searchTerm ?? '' }}" aria-label="Buscar evento">
                    
                    <button type="submit" class="btn btn-sm btn-buscar-custom">Buscar</button>

                    @if(isset($searchTerm) && $searchTerm)
                        <a href="{{ route('galeria.index') }}" class="btn btn-sm btn-limpiar-custom ms-2">Limpiar</a>
                    @endif
                </form>
            </div>
        </div>
        {{-- ========================================================== --}}
        {{-- FIN: Formulario de Búsqueda --}}
        {{-- ========================================================== --}}

    <div class="carousel-inner">
        @foreach($baseEvent->eventos as $index => $eventoInstancia)
        @php
        $carouselImage = $eventoInstancia->galleryImages->firstWhere('sort_order', 1) ?? $eventoInstancia->galleryImages->first(); @endphp
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
            {{-- INICIO DEL CAMBIO: Envolver la imagen en un enlace --}}
            <a href="{{ route('gallery.season', ['eventoInstancia' => $eventoInstancia->id]) }}">
                <img src="{{-- Inicio de la lógica condicional para src --}}
                                                          @if($carouselImage && $carouselImage->file_path)
                                                              {{ Storage::url($carouselImage->file_path) }}
                                                          @else
                                                              {{ Storage::url('gallery_images/imagen_defecto.jpg') }}
                                                          @endif
                                                          {{-- Fin de la lógica condicional para src --}}" class="d-block w-100"
                    alt="{{ $eventoInstancia->nombre }} @if($carouselImage && $carouselImage->title) - {{ $carouselImage->title }} @elseif($carouselImage) - Imagen de {{ $eventoInstancia->nombre }} @else - Imagen por defecto @endif">
            </a>
        {{-- Se cambia el @if por @forelse para manejar el caso de "no hay resultados" --}}
        @forelse($baseEventsList as $baseEvent)
            <div class="gallery-section mb-5">
                <div class="text-center mb-4">
                    <h2 class="gallery-title">{{ $baseEvent->name }}</h2>
                </div>

                @if($baseEvent->eventos->count() > 0)
                    {{-- El resto de tu lógica para el carrusel permanece igual --}}
                    <div id="baseEventCarousel-{{ $baseEvent->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach($baseEvent->eventos as $index => $eventoInstancia)
                                <button type="button" data-bs-target="#baseEventCarousel-{{ $baseEvent->id }}"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach($baseEvent->eventos as $index => $eventoInstancia)
                                @php
                                $carouselImage = $eventoInstancia->galleryImages->firstWhere('sort_order', 1) ?? $eventoInstancia->galleryImages->first();
                                @endphp
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <a href="{{ route('gallery.season', ['eventoInstancia' => $eventoInstancia->id]) }}">
                                        <img src="{{ $carouselImage ? Storage::url($carouselImage->file_path) : Storage::url('imagenes-defecto/EventoBase16-9.png') }}" class="d-block w-100"
                                            alt="{{ $eventoInstancia->nombre }}">
                                    </a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>
                                            <a href="{{ route('gallery.season', ['eventoInstancia' => $eventoInstancia->id]) }}"
                                                class="text-white text-decoration-none">
                                                {{ $eventoInstancia->nombre }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($baseEvent->eventos->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#baseEventCarousel-{{ $baseEvent->id }}"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#baseEventCarousel-{{ $baseEvent->id }}"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        @endif
                    </div>
                @else
                    {{-- Este caso ya está controlado por whereHas en el controlador, pero se deja por si acaso --}}
                    <div class="alert alert-light text-center" role="alert">
                        No hay temporadas para mostrar para {{ $baseEvent->name }}.
                    </div>
                @endif
            </div>
            @if(!$loop->last)
                <hr class="my-5">
            @endif
        @empty
            {{-- Esto se muestra si $baseEventsList está vacío --}}
            @if(isset($searchTerm) && $searchTerm)
                <div class="alert alert-warning text-center" role="alert">
                    No se encontraron eventos que coincidan con "<strong>{{ $searchTerm }}</strong>".
                </div>
            @else
                <div class="alert alert-info text-center" role="alert">
                    No hay eventos con galerías para mostrar en este momento.
                </div>
            @endif
        @endforelse


        {{-- ========================================================== --}}
        {{-- INICIO: Enlaces de Paginación --}}
        {{-- ========================================================== --}}
        @if ($baseEventsList->hasPages())
            <div class="mt-5 d-flex justify-content-end">
                {{-- Esto renderiza los enlaces de paginación de Laravel --}}
                {{ $baseEventsList->links() }}
            </div>
        @endif
        {{-- ========================================================== --}}
        {{-- FIN: Enlaces de Paginación --}}
        {{-- ========================================================== --}}

    </main>
@endsection