@extends('layout.plantilla')
@section('title', 'Calendario')
@section('content')

<section class="calendario-section py-5">
    <div class="container">
        <h2 class="text-center section-title unique-font mb-5">CALENDARIO DE EVENTOS</h2>

        @if(isset($error))
        <div class="alert alert-danger text-center" role="alert">
            {{ $error }}
        </div>
        @endif

        <div class="row g-4">

            {{-- Itera sobre los eventos o muestra mensaje si no hay --}}
            @forelse ($eventos as $evento)
            <div class="col-12 col-md-4">
                <a href="{{ route('calendario.informacion', ['id' => $evento->id]) }}" class="event-link"
                    aria-label="Detalles {{ $evento->nombre }}">
                    <div class="card h-100">
                        {{-- Muestra imagen (imagen1) o la imagen por defecto --}}
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
            {{-- Mensaje si no hay eventos --}}
            @if (!isset($error))
            <div class="col-12">
                <p class="text-center alert alert-info">No hay eventos próximos en el calendario.</p>
            </div>
            @endif
            @endforelse

        </div>

        {{-- *** INICIO: ENLACES DE PAGINACIÓN *** --}}
        @if ($eventos->hasPages()) {{-- Solo muestra la paginación si hay más de una página --}}
        <div class="mt-5 d-flex justify-content-end">
            {{ $eventos->links() }} {{-- Esto renderiza los enlaces de paginación --}}
        </div>
        @endif
        {{-- *** FIN: ENLACES DE PAGINACIÓN *** --}}

    </div>
</section>

@endsection