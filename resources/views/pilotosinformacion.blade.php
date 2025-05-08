@extends('layout.plantilla')

@section('title', isset($piloto) ? 'Información Piloto: ' . $piloto->Nombre . ' ' . $piloto->Apellidos : 'Información Piloto')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-11 col-md-10 col-lg-8">

            @if(isset($piloto))
                <div class="pilot-detail-header">
                    @if($piloto->Imagen)
                        <img src="{{ Storage::url($piloto->Imagen) }}"
                             alt="Foto de {{ $piloto->Nombre }} {{ $piloto->Apellidos }}"
                             class="pilot-detail-image">
                    @else
                        <img src="{{ Storage::url('imagenes-defecto/Piloto.png') }}"
                             alt="Imagen de piloto no disponible"
                             class="pilot-detail-image">
                    @endif
                    
                    <h1 class="pilot-detail-name">{{ $piloto->Nombre }} {{ $piloto->Apellidos }}</h1>
                    <p class="pilot-detail-quote">
                        @if(isset($piloto->Frase) && trim($piloto->Frase) !== '')
                            "{{ $piloto->Frase }}"
                        @else
                            "Pasión, precisión y velocidad en cada curva"
                        @endif
                    </p>
                </div>

                <hr class="section-separator">

                {{-- Sección "Sobre el Piloto" con título dinámico --}}
                @if(isset($piloto->Descripcion) && trim($piloto->Descripcion) !== '')
                    <section class="pilot-info-section pilot-about-section">
                        {{-- CAMBIO AQUÍ: Título dinámico --}}
                        <h2 class="pilot-section-title">Sobre {{ $piloto->Nombre }}</h2> 
                        <div class="pilot-about-content">
                            <p>{!! nl2br(e($piloto->Descripcion)) !!}</p>
                        </div>
                        <p class="pilot-join-date">
                            <span class="icon-calendar">📅</span>
                            Desde 2025 en el equipo.
                        </p>
                    </section>
                @endif

                <hr class="section-separator">

                <section class="pilot-info-section pilot-events-section">
                    <h2 class="pilot-section-title">Eventos en los que participa</h2>
                    
                    @if(isset($piloto->eventos) && $piloto->eventos->count() > 0)
                        <div class="events-list">
                            @foreach($piloto->eventos as $evento)
                                <div class="event-card">
                                    <div class="event-card-info">
                                        <h3 class="event-name">{{ $evento->nombre }}</h3>
                                    </div>
                                    <div class="event-card-action">
                                        <a href="{{ route('calendario.informacion', ['id' => $evento->id]) }}" class="btn btn-view-event">Ver Evento</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>Este piloto no tiene eventos programados actualmente.</p>
                    @endif
                </section>

            @else
                <div class="text-center alert alert-warning" role="alert">
                    <h4 class="alert-heading">Piloto no encontrado</h4>
                    <p>La información para este piloto no está disponible en este momento.</p>
                    <hr>
                    <p class="mb-0">Por favor, intenta con otro piloto o vuelve más tarde.</p>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection