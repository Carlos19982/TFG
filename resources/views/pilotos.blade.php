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

  {{-- Usamos @forelse para iterar y manejar el caso vacío fácilmente --}}
  @forelse($pilotos as $piloto)
    {{-- Calcular si la fila es par para invertir el layout --}}
    @php $isInverso = ($loop->iteration % 2 == 0); @endphp

    {{-- Estructura de fila para un piloto --}}
    <div class="team-member row align-items-center mb-5">

      {{-- Columna para Imagen y Nombre del Piloto --}}
      <div class="col-md-3 text-center member-visual {{ $isInverso ? 'order-md-2' : '' }}">
        <img
          {{-- Generar URL pública para la imagen usando Storage. --}}
          src="{{ Storage::url($piloto->Imagen ?? 'img/default-pilot.png') }}"
          alt="Foto de {{ $piloto->Nombre }} {{ $piloto->Apellidos }}"
          class="img-fluid member-photo mb-2" />
        <div class="member-name">{{ $piloto->Nombre }} {{ $piloto->Apellidos }}</div>
      </div>

      {{-- Columna para Información del Piloto --}}
<div class="col-md-9 member-info d-flex flex-column {{ $isInverso ? 'order-md-1 align-items-md-end' : 'align-items-md-start' }} px-3">
         <p>
           {{-- Mostrar descripción, con un texto por defecto si es null --}}
           {{ $piloto->Descripcion ?? 'Información no disponible.' }}
         </p>
         {{-- Lista estática - Modificar si tienes datos dinámicos para esto --}}
         <ul>
           <li>Ejemplo 1</li>
           <li>Ejemplo 2</li>
           <li>Ejemplo 3</li>
           <li>Ejemplo 4</li>
         </ul>
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

</section>
@endsection