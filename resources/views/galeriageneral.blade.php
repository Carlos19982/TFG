@extends('layout.plantilla')

@section('title', 'Galerías de Eventos')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-5">Galerías de Eventos</h1>

    {{-- Aquí va tu formulario de búsqueda si tienes uno --}}
    
    {{-- Comprobar si hay eventos para mostrar --}}
    @if($baseEventsList->count() > 0)

        {{-- BUCLE PRINCIPAL: Recorre cada EVENTO BASE (ej: Formula 1, MotoGP) --}}
        @foreach($baseEventsList as $baseEvent)
            <div class="event-block mb-5">
                {{-- TÍTULO DEL EVENTO BASE --}}
                <h2 class="event-title">{{ $baseEvent->name }}</h2>
                
                {{-- CARRUSEL PARA LAS TEMPORADAS DE ESTE EVENTO --}}
                @if($baseEvent->eventos->count() > 0)
                    <div id="carousel-{{ $baseEvent->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            
                            {{-- BUCLE ANIDADO: Recorre cada TEMPORADA (evento) de este Evento Base --}}
                            @foreach($baseEvent->eventos as $season)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    {{-- Enlace a la galería de la temporada específica --}}
                                    <a href="{{ route('gallery.season', ['eventoInstancia' => $season->id]) }}">
                                        @php
                                            // Tomamos la primera imagen como portada del carrusel
                                            $coverImage = $season->galleryImages->first();
                                        @endphp
                                        @if($coverImage)
                                            <img src="{{ Storage::url($coverImage->file_path) }}" class="d-block w-100 carousel-image" alt="Portada de {{ $season->nombre }}">
                                        @else
                                            {{-- Imagen por defecto si no hay portada --}}
                                            <img src="https://via.placeholder.com/800x400?text=Sin+Portada" class="d-block w-100 carousel-image" alt="Sin portada">
                                        @endif
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>{{ $season->nombre }}</h5>
                                            <p>Ver galería de esta temporada</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        {{-- Controles del carrusel --}}
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $baseEvent->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $baseEvent->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                @else
                    <p>Este evento no tiene temporadas con galerías.</p>
                @endif
            </div>
            <hr class="my-5">
        @endforeach

        {{-- Enlaces de paginación para los eventos base --}}
        <div class="d-flex justify-content-center">
            {{ $baseEventsList->links() }}
        </div>

    @else
        <p class="text-center">No se encontraron eventos con galerías.</p>
    @endif
</div>
@endsection

@push('styles')
<style>
    .event-title {
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .carousel-image {
        height: 400px;
        object-fit: cover;
        filter: brightness(0.8);
        border-radius: 8px;
    }
    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 8px;
    }
</style>
@endpush