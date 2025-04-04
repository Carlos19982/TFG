@extends('layout.plantilla')
@section('title', 'Calendario')
@section('content')

<!-- START: Calendario Section -->
<section class="calendario-section py-5">
  <div class="container">
    <h2 class="text-center section-title unique-font mb-5">CALENDARIO DE EVENTOS</h2>
    <div class="row g-4"> <!-- g-4 adds gutters (spacing) between columns -->

      <!-- Card 1 -->
      <div class="col-12 col-md-4">
        <a href="{{ route('calendario.informacion') }}" class="event-link" aria-label="Detalles Competición 1"> <!-- Link wraps the card, replace # -->
          <div class="card h-100"> <!-- Added Bootstrap card class and h-100 for equal height -->
            <!-- IMPORTANT: Replace with your actual image path -->
            <img src="{{ asset('img/Oran.png')}}" class="card-img-top" alt="Imagen Competición 1">
            <div class="card-footer">
              <p class="competition-name text-center mb-0">Oran Park</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card 2 -->
      <div class="col-12 col-md-4">
        <a href="#" class="event-link" aria-label="Detalles Competición 2">
          <div class="card h-100">
            <!-- IMPORTANT: Replace with your actual image path -->
            <img src="{{ asset('img/Oran.png')}}" class="card-img-top" alt="Imagen Competición 2">
            <div class="card-footer">
              <p class="competition-name text-center mb-0">Nombre Competición 2</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card 3 -->
      <div class="col-12 col-md-4">
        <a href="#" class="event-link" aria-label="Detalles Competición 3">
          <div class="card h-100">
            <!-- IMPORTANT: Replace with your actual image path -->
            <img src="{{ asset('img/Oran.png')}}" class="card-img-top" alt="Imagen Competición 3">
            <div class="card-footer">
              <p class="competition-name text-center mb-0">Nombre Competición 3</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card 4 -->
      <div class="col-12 col-md-4">
        <a href="#" class="event-link" aria-label="Detalles Competición 4">
          <div class="card h-100">
            <!-- IMPORTANT: Replace with your actual image path -->
            <img src="{{ asset('img/Oran.png')}}" class="card-img-top" alt="Imagen Competición 4">
            <div class="card-footer">
              <p class="competition-name text-center mb-0">Nombre Competición 4</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card 5 -->
      <div class="col-12 col-md-4">
        <a href="#" class="event-link" aria-label="Detalles Competición 5">
          <div class="card h-100">
            <!-- IMPORTANT: Replace with your actual image path -->
            <img src="{{ asset('img/Oran.png')}}" class="card-img-top" alt="Imagen Competición 5">
            <div class="card-footer">
              <p class="competition-name text-center mb-0">Nombre Competición 5</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card 6 -->
      <div class="col-12 col-md-4">
        <a href="#" class="event-link" aria-label="Detalles Competición 6">
          <div class="card h-100">
            <!-- IMPORTANT: Replace with your actual image path -->
            <img src="{{ asset('img/Oran.png')}}" class="card-img-top" alt="Imagen Competición 6">
            <div class="card-footer">
              <p class="competition-name text-center mb-0">Nombre Competición 6</p>
            </div>
          </div>
        </a>
      </div>

    </div> <!-- End .row -->
  </div> <!-- End .container -->
</section>
<!-- END: Calendario Section -->

@endsection