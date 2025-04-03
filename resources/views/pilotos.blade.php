<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nosotros - ZRT MOMO</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" href="../resources/css/pilotos.css" />
    <!-- <link rel="icon" href="../src/img/favicon.ico" type="image/x-icon"> -->
  </head>
  <body>
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="#">
          <!-- Ruta del logo principal -->
          <img
            src="../src/img/ZRTSINFONDO 1.svg"
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
              <a class="nav-link active" href="#">PILOTOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">CALENDARIO</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="#">GALERÍA</a></li>
            <li class="nav-item"><a class="nav-link" href="#">ÚNETE</a></li>
          </ul>
        </div>
      </div>
    </nav>

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
            src="ImagenesP/Imagen2.png"
            alt="Foto de Carlos Blanco Hidalgo"
            class="img-fluid member-photo mb-2"
          />
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
            src="ImagenesP/Imagen1.png"
            alt="Foto de Javier Zurita"
            class="img-fluid member-photo mb-2"
          />
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

    <footer>
      <!-- Franja roja con imágenes -->
      <div class="footer-top text-center">
        <!-- Logos de Partners -->
        <img
          src="../src/img/PatroMomo.svg"
          alt="MOMO Tires Logo"
          class="img-footer-partner"
        />
        <img
          src="../src/img/PatroillanDommarco.svg"
          alt="Logo Ilian Domi"
          class="img-footer-partner"
        />
        <img
          src="../src/img/PatroTheMechtCat.svg"
          alt="Logo The Mech Cat"
          class="img-footer-partner"
        />
      </div>
      <!-- Footer negro -->
      <div class="footer-bottom">
        <div class="container">
          <div class="social-icons mb-3">
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" aria-label="Instagram"
              ><i class="bi bi-instagram"></i
            ></a>
            <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
          </div>
          <p>© 2024 ZRT MOMO. Todos los derechos reservados.</p>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
