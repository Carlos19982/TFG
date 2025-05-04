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
                        <img src="{{ $evento->imagen ? Storage::url(path: $evento->imagen) : Storage::url('imagenes-defecto/evento-default.png') }}"
                            class="card-img-top" alt="Imagen {{ $evento->nombre }}">
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
    </div>
</section>

@endsection