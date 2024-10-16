<?php

# src="https://via.placeholder.com/150x40" placeholder de imagen generico
// Verifica si existe una sesión activa
if (isset($_SESSION['usuario_activo'])){
    // Navbar para usuarios con sesión activa
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="#">
            <img src="./assets/img/logo.jfif" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="piezasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Piezas
                    </a>
                    <div class="dropdown-menu" aria-labelledby="piezasDropdown">
                        <a class="dropdown-item" href="listados/piezasListado.php">Todas</a>
                        <a class="dropdown-item" href="listados/paleontologíaLista.php">Paleontología</a>
                        <a class="dropdown-item" href="listados/osteologíaLista.php">Osteología</a>
                        <a class="dropdown-item" href="listados/ictiologíaLista.php">Ictiología</a>
                        <a class="dropdown-item" href="listados/geologíaLista.php">Geología</a>
                        <a class="dropdown-item" href="listados/botánicaLista.php">Botánica</a>
                        <a class="dropdown-item" href="listados/zoologíaLista.php">Zoología</a>
                        <a class="dropdown-item" href="listados/arqueologíaLista.php">Arqueología</a>
                        <a class="dropdown-item" href="listados/octologíaLista.php">Octología</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listados/donadoresLista.php">Donadores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listados/historial.php">Historial</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://via.placeholder.com/30" alt="Usuario" class="rounded-circle"> <?php echo $_SESSION['usuario_activo']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="usuarioDropdown">
                    <a class="dropdown-item disabled" href="#"><?php echo "ID: " . $_SESSION['id']; ?></a>
                        <a class="dropdown-item" href="./contacto/perfil.php?id=<?php echo $_SESSION['id'];?>">Perfil y Preferencias</a>
                        <a class="dropdown-item" href="./contacto/cerrar.php">Cerrar sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <?php
} else {
    // Navbar para usuarios sin sesión activa
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="#">
            <img src="https://via.placeholder.com/150x40" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../../proyectoMuseo/index.php">Inicio</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://via.placeholder.com/30" alt="Usuario" class="rounded-circle"> Usuario
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="usuarioDropdown">
                        <a class="dropdown-item" href="./contacto/formulario.php">Iniciar sesión</a>
                        <a class="dropdown-item" href="./contacto/formulario.php">Crear cuenta</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <?php
}
?>