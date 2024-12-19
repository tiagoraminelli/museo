<?php
session_start(); // Asegúrate de iniciar la sesión
if (!isset($_SESSION['usuario_activo'])) {
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../../index.php");
    exit;
}
// Verificar si el usuario activo está establecido
if (!isset($_SESSION['usuario_activo'])) {
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../../index.php");
    exit; // Asegura que no se ejecute más código después de la redirección
}

require_once "../../modelo/bd.php";
require_once "../../modelo/donante.php";
$breadcrumb = "Detalles";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idDonante = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($idDonante > 0) {
        $detalles = new Donante();
        $filas = $detalles->getTablasRelacionadasConDonante($idDonante); 
    } else {
        echo "ID de donante no válido.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Donante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white shadow-lg p-3">
  <div class="container">
    <a class="navbar-brand text-gray-800" href="../../index.php">Museo</a>
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
            <a class="dropdown-item" href="../piezasListado.php">Todas</a>
            <a class="dropdown-item" href="../paleontologíaLista.php">Paleontología</a>
            <a class="dropdown-item" href="../osteologíaLista.php">Osteología</a>
            <a class="dropdown-item" href="../ictiologíaLista.php">Ictiología</a>
            <a class="dropdown-item" href="../geologíaLista.php">Geología</a>
            <a class="dropdown-item" href="../botánicaLista.php">Botánica</a>
            <a class="dropdown-item" href="../zoologíaLista.php">Zoología</a>
            <a class="dropdown-item" href="../arqueologíaLista.php">Arqueología</a>
            <a class="dropdown-item" href="../octologíaLista.php">Octología</a>
          </div>
        </li>
        <!-- Donadores y Historial -->
        <li class="nav-item">
          <a class="nav-link text-gray-800" href="../donadoresLista.php">Donadores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-gray-800" href="../historial.php">Historial</a>
        </li>
      </ul>

      <!-- Dropdown Usuario Activo -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="../../assets/img/user.png" alt="Usuario" class="rounded-circle">
            <?php echo $_SESSION['usuario_activo']; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
            <a class="dropdown-item disabled" href="#">
              <?php echo "ID: " . $_SESSION['id']; ?>
            </a>
            <a class="dropdown-item" href="../../contacto/perfil.php?id=<?php echo $_SESSION['id']; ?>">Perfil y Preferencias</a>
            <a class="dropdown-item" href="../../contacto/cerrar.php">Cerrar sesión</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mx-auto my-5">
    <div class="my-5">
        <div class="row align-items-center">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($breadcrumb) ?></li>
                </ol>
            </nav>
            <!-- Columna del texto -->
            <div class="col-md-6">
                <h3 class="text-left mb-4 font-bold text-xl">Listado de Resultados Relacionados con el Donante</h3>
                <p class="lead">
                    Este listado incluye información detallada sobre los donantes y sus contribuciones. Aquí podrás explorar datos específicos de cada donante y su impacto en nuestra comunidad.
                </p>
                <p>
                    Utiliza esta información para comprender mejor el valor y la historia de cada donante. Cada uno de ellos contribuye a nuestra misión de manera única.
                </p>
            </div>

            <!-- Columna de la imagen -->
            <div class="col-md-6 text-center">
                <img src="../../assets/img/gestion de inventario.webp" alt="Imagen representativa de donantes" class="img-fluid rounded-lg">
            </div>
        </div>
    </div>

    <?php
    if (!empty($filas) && is_array($filas)) {
        echo "<table class='table table-light table-striped table-hover'>";
        echo "<thead><tr>";

        // Mostrar encabezados dinámicos solo si hay filas y el índice 0 está definido
        if (isset($filas[0]) && is_array($filas[0])) {
            foreach (array_keys($filas[0]) as $campo) {
                echo "<th>" . ucfirst(str_replace('_', ' ', htmlspecialchars($campo))) . "</th>";
            }
        }

        echo "</tr></thead><tbody>";

        // Mostrar filas dinámicas
        foreach ($filas as $fila) {
            echo "<tr>";
            foreach ($fila as $campo => $valor) {
                echo "<td>" . htmlspecialchars($valor) . "</td>";
            }
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p class='text-center'>No hay datos disponibles para esta tabla.</p>";
        echo '
        <div class="container text-center mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <img src="../../assets/img/error.webp" alt="Error" class="img-fluid mb-4">
                    <h1 class="display-4">¡Oops!</h1>
                    <p class="lead">Ha ocurrido un error inesperado. Por favor, vuelve a intentarlo más tarde.</p>
                    <a href="../../index.php" class="btn btn-primary">Volver al inicio</a>
                </div>
            </div>
        </div>
        ';
    }
    ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include('../../includes/footer.php') ?>
</html>
