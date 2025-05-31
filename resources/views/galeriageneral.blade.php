@extends('layout.plantilla')

{{-- Usar el pageTitle que pasamos desde el controlador, o un default --}}
@section('title', $pageTitle ?? 'Galería de Imágenes')

@section('content')
<div class="container gallery-container-general my-5">
    {{-- Mostrar el nombre de la instancia del evento/temporada como título --}}
    <h2 class="gallery-title-general text-center mb-5">
        Galería: {{ $eventoInstancia->nombre }}
    </h2>

    {{-- Comprobar si hay imágenes para mostrar EN LA COLECCIÓN FILTRADA ($galleryImagesToShow) --}}
    @if(isset($galleryImagesToShow) && $galleryImagesToShow->count() > 0)
        <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

            {{-- Iterar sobre la colección filtrada que excluye la primera imagen --}}
            @foreach($galleryImagesToShow as $image)
                <div class="col">
                    <div class="gallery-card-general">
                        {{-- Enlace:
                             - href apunta a la imagen original para verla en grande (o para el lightbox).
                             - data-bs-toggle="lightbox": Atributo para inicializar un plugin de lightbox de Bootstrap.
                             - data-gallery: Agrupa imágenes en la misma galería del lightbox.
                             - data-title/data-footer: Para mostrar título/descripción en el lightbox.
                             Si no usarás lightbox inmediatamente, puedes simplificar el <a> o incluso quitarlo
                             y solo mostrar la <img> si no quieres que sean clickables.
                        --}}
                        <a href="{{ Storage::url($image->file_path) }}"
                           data-bs-toggle="lightbox"
                           data-gallery="season-gallery-{{ $eventoInstancia->id }}"
                           data-title="{{ $image->title ?? $eventoInstancia->nombre }}"
                           data-footer="{{ $image->caption ?? '' }}">
                            <img src="{{ Storage::url($image->file_path) }}"
                                 class="img-fluid gallery-image-general"
                                 alt="{{ $image->title ?: ($image->caption ?: 'Imagen de ' . $eventoInstancia->nombre) }}">
                        </a>
                    </div>
                </div>
            @endforeach

        </div> {{-- Fin .row --}}
    @else
        <div class="alert alert-info text-center" role="alert">
            No hay imágenes adicionales para mostrar en esta galería (excluyendo la imagen de portada).
        </div>
    @endif
</div> {{-- Fin .container --}}



@endsection