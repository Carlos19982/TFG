@extends('layout.plantilla')

@section('title', isset($evento) ? 'Información: ' . $evento->nombre : 'Información')

@section('content')
<div class="container my-5">

    @if(isset($error))
    <div class="alert alert-danger text-center" role="alert">
        {{ $error }}
    </div>
    @elseif(isset($evento))
    <div class="row">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="text-center">

                @php
                // --- Generación de URL de Imagen (Usando imagen2) ---
                $defaultImage = 'imagenes-defecto/evento-default.png'; // Ruta relativa a public del storage

                // Comprueba si el campo 'imagen2' tiene valor Y si el archivo existe en disco 'public'.
                $imageUrl = ($evento->imagen2 && Storage::disk('public')->exists($evento->imagen2))
                ? Storage::disk('public')->url($evento->imagen2) // Usa imagen2 si existe
                : Storage::disk('public')->url($defaultImage); // Si no, usa la imagen por defecto
                @endphp

                <img src="{{ $imageUrl }}" alt="Imagen de {{ $evento->nombre }}" class="img-fluid rounded mb-3"
                    style="max-height: 400px; object-fit: cover;" />

                <h2 class="first-title mt-3" style="color: var(--yellow);">
                    {{ $evento->nombre }}
                </h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="content-box">
                <h3 class="first-title mb-3" style="color: var(--red);">Información Relevante</h3>

                <p>
                    {{ $evento->descripcion ?? 'Descripción no disponible.' }}
                </p>

                <h5 class="mt-4">Pilotos Participantes:</h5>
                @if ($evento->pilotos->isNotEmpty())
                <ul>
                    @foreach ($evento->pilotos as $piloto)
                    <li>
                        {{ $piloto->Nombre }} {{ $piloto->Apellidos }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p>No hay pilotos registrados para este evento.</p>
                @endif

                {{-- Mostrar Descripción 2 si existe --}}
                @if($evento->descripcion2)
                <h5 class="mt-4">Más Detalles:</h5>
                <p>
                    {{ $evento->descripcion2 }}
                </p>
                @endif

            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info text-center" role="alert">
        No se encontró la información del evento solicitado.
    </div>
    @endif

</div>
@endsection