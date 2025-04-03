<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Calendario - ZRT MOMO</title>
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet"
        />
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        />
        <!-- Link to your specific CSS for this page -->
        <link rel="stylesheet" href="calendario.css" />
        <!-- <link rel="icon" href="../src/img/favicon.ico" type="image/x-icon"> -->
      </head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="#"> <!-- Consider linking to index.html -->
            <img
              src="../img/ZRTSINFONDO 1.svg" 
              alt="ZRT MOMO Logo"
              class="img-fluid logo-header"
            />
          </a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link" href="#">PILOTOS</a> <!-- Add href links -->
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="Calendario.html">CALENDARIO</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#">GALERÍA</a></li>
              <li class="nav-item"><a class="nav-link" href="#">ÚNETE</a></li>
            </ul>
          </div>
        </div>
      </nav>

    <!-- START: Calendario Section -->
    <section class="calendario-section py-5">
        <div class="container">
            <h2 class="text-center section-title unique-font mb-5">CALENDARIO DE EVENTOS</h2>
            <div class="row g-4"> <!-- g-4 adds gutters (spacing) between columns -->

                <!-- Card 1 -->
                <div class="col-12 col-md-4">
                    <a href="#" class="event-link" aria-label="Detalles Competición 1"> <!-- Link wraps the card, replace # -->
                        <div class="card h-100"> <!-- Added Bootstrap card class and h-100 for equal height -->
                            <!-- IMPORTANT: Replace with your actual image path -->
                            <img src="./ImagenesP/Imagen1.png" class="card-img-top" alt="Imagen Competición 1">
                            <div class="card-footer">
                                <p class="competition-name text-center mb-0">Nombre Competición 1</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="col-12 col-md-4">
                    <a href="#" class="event-link" aria-label="Detalles Competición 2">
                         <div class="card h-100">
                            <!-- IMPORTANT: Replace with your actual image path -->
                            <img src="./ImagenesP/Imagen1.png" class="card-img-top" alt="Imagen Competición 2">
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
                            <img src="./ImagenesP/Imagen1.png" class="card-img-top" alt="Imagen Competición 3">
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
                            <img src="./ImagenesP/Imagen1.png" class="card-img-top" alt="Imagen Competición 4">
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
                            <img src="./ImagenesP/Imagen1.png" class="card-img-top" alt="Imagen Competición 5">
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
                           <img src="./ImagenesP/Imagen1.png" class="card-img-top" alt="Imagen Competición 6">
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

    <footer>
        <!-- Franja roja con imágenes -->
        <div class="footer-top text-center">
          <img src="../img/PatroMomo.svg" alt="MOMO Tires Logo" class="img-footer-partner"/>
          <img src="../img/PatroillanDommarco.svg" alt="Logo Ilian Domi" class="img-footer-partner"/>
          <img src="../img/PatroTheMechtCat.svg" alt="Logo The Mech Cat" class="img-footer-partner"/>
        </div>
        <!-- Footer negro -->
        <div class="footer-bottom">
          <div class="container">
            <div class="social-icons mb-3">
              <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a> <!-- Add links -->
              <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
              <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
            </div>
            <p>© 2024 ZRT MOMO. Todos los derechos reservados.</p>
          </div>
        </div>
      </footer>

    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>