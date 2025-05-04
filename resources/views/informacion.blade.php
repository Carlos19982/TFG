@extends('layout.plantilla')
@section('title', 'Informacion')
@section('content')



    <div class="container my-5">
        <div class="row"> <!-- Fila de Bootstrap para las columnas -->

            <!-- Columna Izquierda -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="text-center">
                    <!-- Mantenemos text-center para centrar imagen y título -->

                    <!-- Imagen descriptiva izquierda -->
                    <img src="{{ asset('img/Oran circuito2.png')}}" alt="Imagen descriptiva izquierda"
                        class="img-fluid rounded mb-3" style="max-height: 400px; object-fit: cover;" />
                    <!-- El estilo inline anterior es opcional para controlar tamaño/aspecto -->
                    <!-- Las clases img-fluid, rounded, mb-3 son de Bootstrap -->

                    <!-- === TÍTULO DEBAJO DE LA IMAGEN === -->
                    <!-- Reemplazamos <p> por <h2> y añadimos la clase 'first-title' -->
                    <h2 class="first-title mt-3" style="color: var(--yellow);">
                        <!-- El estilo inline añade color blanco y mt-3 añade margen superior -->
                        Oran Park <!-- Reemplaza esto con tu texto -->
                    </h2>
                    <!-- === FIN DEL TÍTULO === -->
                </div>
            </div>

            <!-- Columna Derecha -->
            <div class="col-md-6">
                <!-- Aplicamos la clase común .content-box aquí -->
                <!-- Quitamos clase 'informacion-derecha', 'p-4', 'rounded' y el style inline -->
                <div class="content-box">
                    <h3 class="first-title mb-3" style="color: var(--red);">Información Relevante</h3>
                    <p>
                        La carrera de Oran Park fue una de las competiciones automovilísticas más emblemáticas de Australia,
                        celebrada en un circuito técnico y desafiante que albergó emocionantes duelos hasta su cierre en
                        2010.
                    </p>
                    <ul>
                        <li>Dato importante 1</li>
                        <li>Característica destacada</li>
                        <li>Enlace a <a href="#" style="color: var(--yellow);">otra sección</a></li>
                        <li>Más detalles sobre el equipo.</li>
                    </ul>
                    <p>
                        Adapta este contenido según tus necesidades específicas para la página "Información".
                    </p>
                </div>
            </div>

        </div> <!-- Fin de .row -->
    </div> <!-- Fin de .container -->




@endsection