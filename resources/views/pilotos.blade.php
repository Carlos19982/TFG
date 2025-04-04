@extends('layout.plantilla')
@section('title', 'Pilotos')



@section('content')

  <!-- =========== SECCIÓN NOSOTROS =========== -->
  <section id="nosotros" class="container my-5 nosotros-section">
    <div class="text-center mb-5 section-title-div">
      <h2 class="section-title first-title">NUESTRO EQUIPO</h2>
    </div>

    <!-- Miembro 1: Carlos Blanco Hidalgo (Layout Estándar) -->
    <div class="team-member row align-items-center mb-5">
      <!-- Columna Izquierda: Imagen y Nombre -->
      <div class="col-md-3 text-center member-visual">
        <!-- Imagen de Carlos -->
        <img
          src="{{ asset('img/Imagen2.png')}}"
          alt="Foto de Carlos Blanco Hidalgo"
          class="img-fluid member-photo mb-2" />
        <div class="member-name">Carlos Blanco Hidalgo</div>
      </div>
      <!-- Columna Derecha: Información (Párrafo + Lista) -->
      <div class="col-md-9 member-info">
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus
          id modi dolor tempora ullam est mollitia libero obcaecati, dolorum
          quibusda nulla incidunt atque doloribus eaque quaerat vero. Autem,
          ratione praesentium!
        </p>
        <!-- Lista de detalles sobre Carlos -->
        <ul>
          <li>CARRERA</li>
          <li>CARRERA</li>
          <li>CARRERA</li>
          <li>CARRERA</li>
        </ul>
      </div>
    </div>
    <!-- Fin Miembro 1 -->

    <!-- Miembro 2: Javier Zurita (Layout Inverso) -->
    <div class="team-member row align-items-center mb-5">
      <!-- Columna Derecha (en Desktop): Imagen y Nombre ('order-md-2') -->
      <div class="col-md-3 text-center member-visual order-md-2">
        <!-- Imagen de Javier -->
        <img
          src="{{ asset('img/imagen1.png')}}"
          alt="Foto de Javier Zurita"
          class="img-fluid member-photo mb-2" />
        <div class="member-name">Javier Zurita</div>
      </div>
      <!-- Columna Izquierda (en Desktop): Información (Párrafo + Lista) ('order-md-1') -->
      <div class="col-md-9 member-info order-md-1">
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus
          id modi dolor tempora ullam est mollitia libero obcaecati, dolorum
          quibusda nulla incidunt atque doloribus eaque quaerat vero. Autem,
          ratione praesentium!
        </p>
        <!-- Lista de detalles sobre Javier -->
        <ul>
          <li>CARRERA</li>
          <li>CARRERA</li>
          <li>CARRERA</li>
          <li>CARRERA</li>
        </ul>
      </div>
    </div>
    <!-- Fin Miembro 2 -->

    <!-- Puedes añadir más miembros siguiendo uno de los dos patrones (estándar o inverso) -->
  </section>
  <!-- =========== FIN SECCIÓN NOSOTROS =========== -->

  @endsection