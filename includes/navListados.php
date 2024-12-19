<?php if (isset($_SESSION['usuario_activo']) and ($_SESSION['nivel']=='gerente')){ ?>
<nav class="navbar navbar-expand-lg bg-white shadow-lg p-3">
  <div class="container">
    <a class="navbar-brand text-gray-800" href="../index.php">Museo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <!-- Menú Piezas -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-gray-800" href="#" id="piezasDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Piezas
          </a>
          <div class="dropdown-menu" aria-labelledby="piezasDropdown">
            <a class="dropdown-item" href="./piezasListado.php">Todas</a>
            <a class="dropdown-item" href="./paleontologíaLista.php">Paleontología</a>
            <a class="dropdown-item" href="./osteologíaLista.php">Osteología</a>
            <a class="dropdown-item" href="./ictiologíaLista.php">Ictiología</a>
            <a class="dropdown-item" href="./geologíaLista.php">Geología</a>
            <a class="dropdown-item" href="./botánicaLista.php">Botánica</a>
            <a class="dropdown-item" href="./zoologíaLista.php">Zoología</a>
            <a class="dropdown-item" href="./arqueologíaLista.php">Arqueología</a>
            <a class="dropdown-item" href="./octologíaLista.php">Octología</a>
          </div>
        </li>
        <!-- Donadores y Historial -->
        <li class="nav-item">
          <a class="nav-link text-gray-800" href="./donadoresLista.php">Donadores</a>
        </li>
      
      </ul>

      <!-- Dropdown Usuario Activo -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="../assets/img/user.png" alt="Usuario" class="rounded-circle">
            <?php echo $_SESSION['usuario_activo']; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
            <a class="dropdown-item disabled" href="#">
              <?php echo "ID: " . $_SESSION['id']; ?>
            </a>
            <a class="dropdown-item" href="../contacto/perfil.php?id=<?php echo $_SESSION['id']; ?>">Perfil y Preferencias</a>
            <a class="dropdown-item" href="../contacto/cerrar.php">Cerrar sesión</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php } ?>
<?php if (isset($_SESSION['usuario_activo']) and ($_SESSION['nivel']=='administrador')){ ?>
<nav class="navbar navbar-expand-lg bg-white shadow-lg p-3">
  <div class="container">
    <a class="navbar-brand text-gray-800" href="../index.php">Museo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <!-- Menú Piezas -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-gray-800" href="#" id="piezasDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Piezas
          </a>
          <div class="dropdown-menu" aria-labelledby="piezasDropdown">
            <a class="dropdown-item" href="./piezasListado.php">Todas</a>
            <a class="dropdown-item" href="./paleontologíaLista.php">Paleontología</a>
            <a class="dropdown-item" href="./osteologíaLista.php">Osteología</a>
            <a class="dropdown-item" href="./ictiologíaLista.php">Ictiología</a>
            <a class="dropdown-item" href="./geologíaLista.php">Geología</a>
            <a class="dropdown-item" href="./botánicaLista.php">Botánica</a>
            <a class="dropdown-item" href="./zoologíaLista.php">Zoología</a>
            <a class="dropdown-item" href="./arqueologíaLista.php">Arqueología</a>
            <a class="dropdown-item" href="./octologíaLista.php">Octología</a>
          </div>
        </li>
        <!-- Donadores y Historial -->
        <li class="nav-item">
          <a class="nav-link text-gray-800" href="./donadoresLista.php">Donadores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-gray-800" href="./historial.php">Historial</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-gray-800" href="./crearGerente.php">Nuevo Gerente</a>
        </li>
        <!-- Dropdown Eliminados -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-gray-800" href="#" id="eliminadosDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Eliminados
          </a>
          <div class="dropdown-menu" aria-labelledby="eliminadosDropdown">
            <a class="dropdown-item" href="./eliminados.php">Piezas</a>
            <a class="dropdown-item" href="./verPiezaEliminada.php">Datos</a>
            <a class="dropdown-item" href="./donadoresEliminadosList.php">Donadores</a>
          </div>
        </li>
      </ul>

      <!-- Dropdown Usuario Activo -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="../assets/img/user.png" alt="Usuario" class="rounded-circle">
            <?php echo $_SESSION['usuario_activo']; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
            <a class="dropdown-item disabled" href="#">
              <?php echo "ID: " . $_SESSION['id']; ?>
            </a>
            <a class="dropdown-item" href="../contacto/perfil.php?id=<?php echo $_SESSION['id']; ?>">Perfil y Preferencias</a>
            <a class="dropdown-item" href="../contacto/cerrar.php">Cerrar sesión</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php } ?>



