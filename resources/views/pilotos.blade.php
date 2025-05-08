{{-- resources/views/pilotos.blade.php --}}

@extends('layout.plantilla')
@section('title', 'Pilotos')
@section('content')

<section id="nosotros" class="container my-5 nosotros-section">
    <div class="text-center mb-5 section-title-div">
        <h1 class="section-title first-title">NUESTRO EQUIPO</h1>
    </div>

    {{-- Opcional: Mostrar un mensaje de error si el controlador lo pasó --}}
    @if(isset($error))
    <div class="alert alert-danger text-center" role="alert">
        {{ $error }}
    </div>
    @endif

    {{-- Itera sobre los pilotos o muestra mensaje si está vacío/error --}}
    @forelse($pilotos as $piloto)
    {{-- Calcular si la fila es par para invertir el layout --}}
    @php $isInverso = ($loop->iteration % 2 == 0); @endphp

    {{-- Estructura de fila para un piloto --}}
    <div class="team-member row align-items-center mb-5">

        {{-- Columna para Imagen y Nombre del Piloto --}}
        {{-- Columna para Imagen y Nombre del Piloto --}}
        <div class="col-md-3 text-center member-visual {{ $isInverso ? 'order-md-2' : '' }}">
            {{-- Envolvemos la imagen en una etiqueta <a> --}}
            <a href="{{ route('pilotos.show', ['id' => $piloto->id]) }}">
                <img src="{{ $piloto->Imagen ? Storage::url($piloto->Imagen) : Storage::url('imagenes-defecto/Piloto.png') }}"
                    alt="Foto de {{ $piloto->Nombre }} {{ $piloto->Apellidos }}" class="img-fluid member-photo mb-2" />
            </a>
            {{-- El nombre también podría ser un enlace si lo deseas, o mantenerse como está --}}
            <div class="member-name text-break">{{ $piloto->Nombre }} {{ $piloto->Apellidos }}</div>
        </div>

        {{-- Columna para Información del Piloto --}}
        <div
            class="col-md-9 member-info d-flex flex-column {{ $isInverso ? 'order-md-1 align-items-md-end' : 'align-items-md-start' }} px-3">
            <p class="text-break">
                {{-- Mostrar descripción --}}
                {{ $piloto->Descripcion ?? 'Información no disponible.' }}
            </p>

            {{-- *** INICIO: Mostrar Eventos Asociados *** --}}
            <h5 class="mt-3">Eventos en los que participa:</h5>
            @if ($piloto->eventos->isNotEmpty())
            <ul>
                @foreach ($piloto->eventos as $evento)
                <li>
                    {{-- Envolvemos el nombre en un enlace 'a' --}}
                    <a class="pilot_event_link" href="{{ route('calendario.informacion', ['id' => $evento->id]) }}">
                        {{ $evento->nombre }}
                    </a>

                </li>
                @endforeach
            </ul>
            @else
            <p>No participa en ningún evento.</p>
            @endif
            {{-- *** FIN: Mostrar Eventos Asociados *** --}}

        </div>

    </div>
    {{-- Fin de la estructura para un piloto --}}

    @empty {{-- Esto se ejecuta si $pilotos está vacío --}}
    @if(!isset($error))
    <div class="alert alert-info text-center" role="alert">
        No hay pilotos registrados en este momento.
    </div>
    @endif
    @endforelse
            {{-- *** INICIO: ENLACES DE PAGINACIÓN *** --}}
            @if ($pilotos->hasPages()) {{-- Solo muestra la paginación si hay más de una página --}}
        <div class="mt-5 d-flex justify-content-end">
            {{ $pilotos->links() }} {{-- Esto renderiza los enlaces de paginación --}}
        </div>
        @endif
        {{-- *** FIN: ENLACES DE PAGINACIÓN *** --}}

</section>
@endsection