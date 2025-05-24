@extends('layout.plantilla')

@section('title', isset($evento) ? 'Galería - ' . $evento->nombre : 'Galería de Eventos')

@section('content')
<main class="container mt-5 mb-5"> {{-- Añadimos mt-5 y mb-5 para espaciado vertical --}}
    <div class="gallery-section">
        <div class="text-center mb-5">
            <h2 class="gallery-title">
                {{-- Si tienes una variable $evento, puedes usar su nombre. Si no, un título genérico. --}}
                {{-- Para este ejemplo, como pediste "Evento 1", lo pongo directamente --}}
                {{-- Si quieres que sea dinámico: isset($evento) ? $evento->nombre : 'Evento 1' --}}
                Evento 1
            </h2>
        </div>

        {{-- Inicio del Carrusel Bootstrap --}}
        <div id="eventGalleryCarousel" class="carousel slide" data-bs-ride="carousel">
            {{-- Indicadores (los puntitos de abajo) --}}
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#eventGalleryCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#eventGalleryCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#eventGalleryCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                {{-- Puedes añadir más botones aquí si añades más imágenes --}}
            </div>

            {{-- Contenedor de las imágenes (slides) --}}
            <div class="carousel-inner">
                {{-- Primer slide (activo por defecto) --}}
                <div class="carousel-item active">
                    {{-- Usaremos un placeholder para la imagen. Reemplaza esto con tus imágenes reales --}}
                    {{-- Ejemplo: {{ asset('storage/galeria/evento1/imagen1.jpg') }} --}}
                    <img src="https://placehold.co/1200x600/333333/EFEFEF?text=Imagen+1" class="d-block w-100" alt="Descripción de la Imagen 1">
                    {{-- Opcional: Caption para la imagen --}}
                    {{-- <div class="carousel-caption d-none d-md-block">
                        <h5>Título Imagen 1</h5>
                        <p>Pequeña descripción de la imagen 1.</p>
                    </div> --}}
                </div>

                {{-- Segundo slide --}}
                <div class="carousel-item">
                    <img src="https://placehold.co/1200x600/444444/EFEFEF?text=Imagen+2" class="d-block w-100" alt="Descripción de la Imagen 2">
                </div>

                {{-- Tercer slide --}}
                <div class="carousel-item">
                    <img src="https://placehold.co/1200x600/555555/EFEFEF?text=Imagen+3" class="d-block w-100" alt="Descripción de la Imagen 3">
                </div>
                {{-- Añade más .carousel-item aquí para más imágenes --}}
            </div>

            {{-- Controles de Anterior/Siguiente --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#eventGalleryCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#eventGalleryCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        {{-- Final del Carrusel Bootstrap --}}

    </div>
</main>
@endsection