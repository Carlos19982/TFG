@extends('layout.plantilla')

@section('title', 'Galerías de Eventos')

@section('content')
<div class="container my-5">
    <h1 class="gallery-title text-center mb-5">Galerías de Eventos</h1>
    
    @if($baseEventsList->count() > 0)
        @foreach($baseEventsList as $baseEvent)
            <div class="event-block mb-5">
                <h2 class="unique-font">{{ $baseEvent->name }}</h2>
                
                @if($baseEvent->eventos->count() > 0)
                    <div id="carousel-{{ $baseEvent->id }}" class="carousel slide" data-bs-ride="carousel">
                        
                        @if($baseEvent->eventos->count() > 1)
                            <div class="carousel-indicators">
                                @foreach($baseEvent->eventos as $season)
                                    <button type="button" data-bs-target="#carousel-{{ $baseEvent->id }}" data-bs-slide-to="{{ $loop->index }}" class="@if($loop->first) active @endif" aria-label="Temporada {{ $loop->iteration }}"></button>
                                @endforeach
                            </div>
                        @endif

                        <div class="carousel-inner">
                            @foreach($baseEvent->eventos as $season)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <a href="{{ route('gallery.season', ['eventoInstancia' => $season->id]) }}">
                                        @php $coverImage = $season->galleryImages->first(); @endphp
                                        @if($coverImage)
                                            <img src="{{ Storage::url($coverImage->file_path) }}" class="d-block w-100" alt="Portada de {{ $season->nombre }}">
                                        @else
                                            {{-- ================================================================ --}}
                                            {{-- CAMBIO REALIZADO AQUÍ --}}
                                            {{-- Se usa la misma imagen y método que en la página de pilotos --}}
                                            <img src="{{ Storage::url('imagenes-defecto/EventoBase16-9.png') }}" class="d-block w-100" alt="Sin portada">
                                            {{-- ================================================================ --}}
                                        @endif
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>{{ $season->nombre }}</h5>
                                            <p>Ver galería de esta temporada</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($baseEvent->eventos->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $baseEvent->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $baseEvent->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        @endif

                    </div>
                @else
                    <p>Este evento no tiene temporadas con galerías.</p>
                @endif
            </div>
            @if(!$loop->last)
                <hr class="my-5 section-separator">
            @endif
        @endforeach

        <div class="d-flex justify-content-center">
            {{ $baseEventsList->links() }}
        </div>

    @else
        <p class="text-center">No se encontraron eventos con galerías.</p>
    @endif
</div>
@endsection