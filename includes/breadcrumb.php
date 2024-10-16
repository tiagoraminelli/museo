<style>
    .image-box {
        width: 600px; /* Ancho del contenedor */
        height: 400px; /* Alto del contenedor */
    }

    .img-ajustada {
        width: 100%; /* Ajusta la imagen al tamaño del contenedor */
        height: 100%; /* Mantiene la altura al tamaño del contenedor */
        object-fit: cover; /* Opción para que la imagen se ajuste bien dentro del recuadro */
    }
</style>

<div class="container mt-5 d-flex flex-column flex-md-row">
    <!-- Columna izquierda -->
    <div class="flex-fill me-md-3">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Inicio</li>
                <li class="breadcrumb-item active" aria-current="page"><?= $breadcrumb ?></li>
            </ol>
        </nav>

        <!-- Cuadro de texto -->
        <div class="mt-4">
            <h5 class="text-2xl font-semibold">Herramientas para desarrolladores</h5>
            <p>Las piezas de un museo son testimonios tangibles de nuestra historia, cultura y biodiversidad. Cada objeto, desde artefactos arqueológicos hasta obras de arte contemporáneo, cuenta una historia única que refleja la creatividad, los conocimientos y las tradiciones de civilizaciones pasadas y presentes.</p>
            <p>En un museo, estas piezas no solo son exhibiciones; son portadoras de conocimiento que nos conectan con nuestro patrimonio y nos ayudan a comprender el mundo en el que vivimos. A través de su conservación y exhibición, los museos preservan la memoria colectiva de la humanidad, ofreciendo a los visitantes la oportunidad de explorar y aprender sobre diversas culturas, épocas y disciplinas.</p>
        </div>

        <!-- Dropdown de Piezas -->
        <div class="dropdown mt-4">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="piezasDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Piezas
            </button>
            <div class="dropdown-menu" aria-labelledby="piezasDropdown">
                <a class="dropdown-item" href="piezasListado.php">Todas</a>
                <a class="dropdown-item" href="paleontologíaLista.php">Paleontología</a>
                <a class="dropdown-item" href="osteologíaLista.php">Osteología</a>
                <a class="dropdown-item" href="ictiologíaLista.php">Ictiología</a>
                <a class="dropdown-item" href="geologíaLista.php">Geología</a>
                <a class="dropdown-item" href="botánicaLista.php">Botánica</a>
                <a class="dropdown-item" href="zoologíaLista.php">Zoología</a>
                <a class="dropdown-item" href="arqueologíaLista.php">Arqueología</a>
                <a class="dropdown-item" href="octologíaLista.php">Octología</a>
                <a class="dropdown-item" href="historial.php">Historial</a>
            </div>
        </div>
    </div>

    <!-- Columna derecha -->
    <div class="mt-4 flex-fill d-flex justify-content-center align-items-center">
        <!-- Recuadro con imagen -->
        <div class="image-box shadow-lg rounded overflow-hidden"> <!-- Añadido sombra y bordes redondeados -->
            <img src="../assets/img/gestion de inventario.webp" alt="Imagen Genérica" class="img-ajustada">
        </div>
    </div>
</div>

