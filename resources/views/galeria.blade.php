@extends('layout.plantilla')

@section('title', 'Galería de Eventos')

@section('content')
    <main class="container mt-5 mb-5">

        @if($baseEventsList && $baseEventsList->count() > 0)
            @foreach($baseEventsList as $baseEvent)
                <div class="gallery-section mb-5">
                    <div class="text-center mb-4">
                        <h2 class="gallery-title">{{ $baseEvent->name }}</h2>
                    </div>

                    @if($baseEvent->eventos && $baseEvent->eventos->count() > 0)
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
                                    $carouselImage = $eventoInstancia->galleryImages->firstWhere('sort_order', 1) ?? $eventoInstancia->galleryImages->first();                                @endphp
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
                                        {{-- FIN DEL CAMBIO --}}

                                        <div class="carousel-caption d-none d-md-block">
                                            {{-- El caption puede seguir siendo el de la temporada/evento general --}}
                                            <h5>
                                                <a href="{{ route('gallery.season', ['eventoInstancia' => $eventoInstancia->id]) }}"
                                                    class="text-white text-decoration-none">
                                                    {{ $eventoInstancia->nombre }}
                                                </a>
                                            </h5>
                                            @if($carouselImage && $carouselImage->caption)
                                                <p>{{ $carouselImage->caption }}</p>
                                            @elseif($carouselImage && $carouselImage->title)
                                                <p>{{ $carouselImage->title }}</p>
                                            @endif
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
                        <div class="alert alert-light text-center" role="alert">
                            No hay temporadas para mostrar para {{ $baseEvent->name }}.
                        </div>
                    @endif
                </div>
                @if(!$loop->last)
                    <hr class="my-5">
                @endif
            @endforeach
        @else
            <div class="alert alert-info text-center" role="alert">
                No hay eventos con galerías para mostrar en este momento.
            </div>
        @endif

    </main>
@endsection