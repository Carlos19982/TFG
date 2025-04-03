<!DOCTYPE html>
<html lang="en"> {{-- O lang="{{ str_replace('_', '-', app()->getLocale()) }}" para idioma de Laravel --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TFG')</title>
    {{-- Bootstrap CSS (Necesitarás añadirlo si usas componentes JS/CSS de Bootstrap) --}}
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    {{-- Bootstrap Icons CSS (Necesitarás añadirlo para que se vean los iconos) --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 


    {{-- CSS Global de tu aplicación (usando Vite o Mix) --}}
    {{-- @vite(['resources/css/app.css']) --}}
    {{-- O si no usas Vite/Mix --}}
   <link rel="stylesheet" href="{{ asset('../resources/css/estilos.css') }}"> 


    {{-- Sección para estilos CSS específicos de cada página --}}
    @yield('styles')
</head>

<body>
    {{-- Barra de Navegación (como en el ejemplo anterior) --}}
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('../resources/img/ZRTSINFONDO 1.svg') }}" alt="Momo Tires Logo" class="img-fluid logo-header"> {{-- Asumiendo que está en public/img/ --}}
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">NOSOTROS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">CALENDARIO</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">GALERÍA</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">ÚNETE</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido Principal (definido por cada vista hija) --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- ====> INICIO DEL FOOTER <==== --}}
    <footer>
        <div class="footer-top text-center">
            {{-- Usa asset() para las imágenes. Ajusta la ruta si es necesario (ej: 'img/...') --}}
            <img src="{{ asset('../resources/img/PatroMomo.svg') }}" alt="MOMO Tires Logo" class="img-footer-partner">
            <img src="{{ asset('../resources/img/PatroillanDommarco.svg') }}" alt="Logo Ilian Domi" class="img-footer-partner">
            <img src="{{ asset('../resources/img/PatroTheMechtCat.svg') }}" alt="Logo The Mech Cat" class="img-footer-partner">
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="social-icons mb-3">
                    {{-- Asegúrate de tener Bootstrap Icons CSS cargado en el <head> para que se vean --}}
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                </div>
                {{-- Año dinámico --}}
                <p>© {{ date('Y') }} ZRT MOMO. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    {{-- ====> FIN DEL FOOTER <==== --}}


    {{-- ====> SCRIPTS GLOBALES Y ESPECÍFICOS <==== --}}
    {{-- Bootstrap JS (Depende de Popper.js, incluido en el bundle) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- El script de iconos de Bootstrap que pusiste no es necesario si ya cargas el CSS de los iconos en el <head> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.js"></script> --}}

    {{-- JS Global de tu aplicación (usando Vite o Mix) --}}
    {{-- @vite(['resources/js/app.js']) --}}
    {{-- O si no usas Vite/Mix --}}
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}


    {{-- Sección para scripts JS específicos de cada página --}}
    {{-- Se coloca DESPUÉS de las librerías globales para que los scripts específicos puedan usarlas --}}
    @yield('scripts')
</body>

</html>