{{-- resources/views/pilotos.blade.php --}}

@extends('layout.plantilla')
@section('title', 'Pilotos')
{{-- No hay estilos CSS específicos de página aquí --}}

@section('content')

<section id="nosotros" class="container my-5 nosotros-section">

    {{-- Contenedor Flex para el Título y el Buscador --}}
    <div class="d-flex flex-wrap justify-content-center align-items-center mb-5 position-relative">
        {{-- Título Centrado --}}
        <div class="section-title-div text-center mx-auto py-2">
            <h1 class="section-title first-title mb-0">NUESTRO EQUIPO</h1>
        </div>

        {{-- Buscador a la Derecha --}}
        {{-- No mostrar el buscador si estamos en una vista de "show" individual (si implementaste esa bandera en el futuro) --}}
        @if(!isset($isSingleShowView) || !$isSingleShowView)
        <div class="search-form-container ms-md-auto mt-3 mt-md-0">
            <form action="{{ route('pilotos.index') }}" method="POST" class="d-flex">
                @csrf
                <input type="text"
                       name="termino_busqueda"
                       class="form-control form-control-sm me-2"
                       placeholder="Buscar piloto..."
                       value="{{ $searchTerm ?? '' }}"
                       aria-label="Buscar piloto">
                {{-- Clases personalizadas aplicadas, estilos definidos en CSS global --}}
                <button type="submit" class="btn btn-sm btn-buscar-custom">Buscar</button>
                
                @if(isset($searchTerm) && $searchTerm)
                {{-- Opción 1: Botón sólido con color personalizado --}}
                <a href="{{ route('pilotos.index') }}" class="btn btn-sm btn-limpiar-custom ms-2">Limpiar</a>
                {{-- Opción 2: Botón con borde y color personalizado (si definiste .btn-outline-limpiar-custom) --}}
                {{-- <a href="{{ route('pilotos.index') }}" class="btn btn-sm btn-outline-limpiar-custom ms-2">Limpiar</a> --}}
                @endif
            </form>
        </div>
        @endif
    </div>
    {{-- Fin del Contenedor Flex para Título y Buscador --}}

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
        <div class="col-md-3 text-center member-visual {{ $isInverso ? 'order-md-2' : '' }}">
            {{-- Enlace a la ficha individual del piloto --}}
            <a href="{{ route('pilotos.show', ['id' => $piloto->id]) }}">
                <img src="{{ $piloto->Imagen ? Storage::url($piloto->Imagen) : Storage::url('imagenes-defecto/Piloto.png') }}"
                    alt="Foto de {{ $piloto->Nombre }} {{ $piloto->Apellidos }}" class="img-fluid member-photo mb-2" />
            </a>
            <div class="member-name text-break">{{ $piloto->Nombre }} {{ $piloto->Apellidos }}</div>
        </div>

        {{-- Columna para Información del Piloto --}}
        <div
            class="col-md-9 member-info d-flex flex-column {{ $isInverso ? 'order-md-1 align-items-md-end' : 'align-items-md-start' }} px-3">
            <p class="text-break">
                {{-- Mostrar descripción --}}
                {{ $piloto->Descripcion ?? 'Información no disponible.' }}
            </p>

            {{-- Mostrar Eventos Asociados --}}
            <h5 class="mt-3">Eventos en los que participa:</h5>
            @if ($piloto->eventos && $piloto->eventos->isNotEmpty()) {{-- Comprobar que $piloto->eventos existe y no está vacío --}}
            <ul>
                @foreach ($piloto->eventos as $evento)
                <li>
                    {{-- Enlace al detalle del evento --}}
                    <a class="pilot_event_link" href="{{ route('calendario.informacion', ['id' => $evento->id]) }}">
                        {{ $evento->nombre }}
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p>No participa en ningún evento.</p>
            @endif
            {{-- Fin Mostrar Eventos Asociados --}}
        </div>

    </div>
    {{-- Fin de la estructura para un piloto --}}

    @empty {{-- Esto se ejecuta si $pilotos está vacío --}}
        @if(isset($searchTerm) && $searchTerm)
            <div class="alert alert-warning text-center" role="alert">
                No se encontraron pilotos que coincidan con "<strong>{{ $searchTerm }}</strong>".
            </div>
        @elseif(!isset($error)) {{-- Solo muestra este si no hay un error general --}}
            <div class="alert alert-info text-center" role="alert">
                No hay pilotos registrados en este momento.
            </div>
        @endif
    @endforelse

    {{-- Enlaces de Paginación --}}
    @if ($pilotos->hasPages()) {{-- Solo muestra la paginación si hay más de una página --}}
        <div class="mt-5 d-flex justify-content-end">
            {{ $pilotos->links() }} {{-- Esto renderiza los enlaces de paginación --}}
        </div>
    @endif
    {{-- Fin Enlaces de Paginación --}}

</section>
@endsection