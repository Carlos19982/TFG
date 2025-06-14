<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TFG')</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font Awesome en tu HTML -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    {{-- CSS Global --}}
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    {{-- Sección para estilos CSS específicos --}}
    @yield('styles')
</head>

<body>

    <div class="sticky-top">
        {{-- Barra de Navegación --}}
        <nav class="navbar navbar-expand-lg">
            {{-- Considera añadir una clase de fondo como 'navbar-light bg-light' o 'navbar-dark bg-dark' si es
            necesario --}}
            <div class="container">
                {{-- Brand/Logo --}}
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/Logo.png') }}" alt="ZRT MOMO Logo" class="img-fluid logo-header">
                </a>

                {{-- Botón Toggler para Móviles (AHORA DENTRO de NAV y CONTAINER) --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Contenido Colapsable (AÑADIDO ID="navbarNav") --}}
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item li-plantilla"><a class="nav-link" href="{{ url('/pilotos') }}">PILOTOS</a>
                        </li>
                        <li class="nav-item li-plantilla"><a class="nav-link"
                                href="{{ url('/calendario') }}">EVENTOS</a>
                        </li>
                        <li class="nav-item li-plantilla"><a class="nav-link" href="{{ url('/galeria') }}">GALERÍA</a></li>
                        <li class="nav-item li-plantilla"><a class="nav-link" href="https://discord.gg/394mvsXvX9">ÚNETE</a></li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>

    {{-- Contenido Principal --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- ====> INICIO DEL FOOTER <==== --}} <footer>
        <div class="footer-top text-center">
            <img src="{{ asset('img/PatroMomo.svg') }}" alt="MOMO Tires Logo" class="img-footer-partner">
            <img src="{{ asset('img/ILLAN_DOMMARCO_SILLER.png') }}" alt="Logo Ilian Domi" class="img-footer-partner">
            <img src="{{ asset('img/TheMechCatFullBlanco.png') }}" alt="Logo The Mech Cat" class="img-footer-partner">
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="social-icons mb-3">
                    <a href="https://www.twitch.tv/zrtmomotiresarg"><i class="fab fa-twitch"></i></a>
                    <a href="https://x.com/zrt_momotiresar"><i class="bi bi-twitter"></i></a>
                    <a href="https://www.instagram.com/zrt_momotiresar/"><i class="bi bi-instagram"></i></a>
                </div>
                <p>© {{ date('Y') }} ZRT MOMO. Todos los derechos reservados.</p>
            </div>
        </div>
        </footer>
        {{-- ====> FIN DEL FOOTER <==== --}} {{--====> SCRIPTS GLOBALES Y ESPECÍFICOS <==== --}} {{-- Bootstrap JS
                (Bundle incluye Popper) --}} <script
                src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
                </script>

                {{-- JS Global (si lo necesitas) --}}
                {{--
                <script src="{{ asset('js/app.js') }}"></script> --}}

                {{-- Sección para scripts JS específicos --}}
                @yield('scripts')
</body>

</html>