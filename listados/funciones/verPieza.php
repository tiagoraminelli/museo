<?php
session_start();
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";
$breadcrumb = "Detalles";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idPieza = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($idPieza > 0) {
        $detalles = new Pieza();
        $resultado = $detalles->getTablasRelacionadasConPieza($idPieza);

        // Inicializar el array $resultados
        $resultados = [];

        // Paleontología
        if (isset($resultado['paleontologia']) && !empty($resultado['paleontologia'])) {
            $resultados['paleontologia'] = $resultado['paleontologia'];
        }

        // Osteología
        if (isset($resultado['osteologia']) && !empty($resultado['osteologia'])) {
            $resultados['osteologia'] = $resultado['osteologia'];
        }

        // Ictiología
        if (isset($resultado['ictiologia']) && !empty($resultado['ictiologia'])) {
            $resultados['ictiologia'] = $resultado['ictiologia'];
        }

        // Geología
        if (isset($resultado['geologia']) && !empty($resultado['geologia'])) {
            $resultados['geologia'] = $resultado['geologia'];
        }

        // Botánica
        if (isset($resultado['botanica']) && !empty($resultado['botanica'])) {
            $resultados['botanica'] = $resultado['botanica'];
        }

        // Zoología
        if (isset($resultado['zoologia']) && !empty($resultado['zoologia'])) {
            $resultados['zoologia'] = $resultado['zoologia'];
        }

        // Arqueología
        if (isset($resultado['arqueologia']) && !empty($resultado['arqueologia'])) {
            $resultados['arqueologia'] = $resultado['arqueologia'];
        }

        // Octología
        if (isset($resultado['octologia']) && !empty($resultado['octologia'])) {
            $resultados['octologia'] = $resultado['octologia'];
        }
    } else {
        echo "ID de pieza no válido.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Piezas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
    <style>
        /* Personaliza aquí los colores y estilos según sea necesario */
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: white;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .table td {
            background-color: #ffffff;
            color: #212529;
        }
    </style>
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
      <?php if (isset($_SESSION['usuario_activo'])): ?>
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
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container my-5 shadow-lg p-4 bg-white rounded-lg">
    <div class="row align-items-center">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$breadcrumb?></li>
            </ol>
        </nav>
        <!-- Columna del texto -->
        <div class="col-md-6">
            <h3 class="text-left mb-4 text-gray-700">Listado de Resultados Relacionados con la Pieza</h3>
            <p class="lead text-gray-600">
                Este listado incluye información detallada sobre las piezas de diversas disciplinas, como paleontología, osteología, ictiología, geología, y más. Aquí podrás explorar datos específicos de cada pieza, desde su clasificación científica hasta su relevancia en diferentes campos de estudio.
            </p>
            <p class="text-gray-600">
                Utiliza esta información para comprender mejor la historia y el valor de cada pieza, ya sea que estés investigando fósiles antiguos, especies animales, plantas o artefactos históricos. Cada pieza cuenta una historia única, y este listado te ayudará a descubrirla.
            </p>
        </div>

        <!-- Columna de la imagen -->
        <div class="col-md-6 text-center">
            <img src="../../assets/img/verpieza.jpg" alt="Imagen representativa de piezas" class="img-fluid rounded shadow">
        </div>
    </div>
</div>

<!-- Contenedor de información sobre crear pieza y descargar PDF -->
<div class="container mt-8 text-center">
    <div class="bg-white shadow-md rounded-lg p-6">
        <p class="mb-2 text-gray-600">
            También puedes descargar el PDF con información de todas las piezas. Esto es útil para la documentación, auditorías o para compartir información con otros interesados.
        </p>
        <a href="../funciones/generaPDF.php?id=<?php echo $idPieza?>" class="text-blue-600 hover:underline">Descargar PDF de Todas las Piezas</a>
    </div>
</div>

<div class="container my-5">
    <?php
    if (!empty($resultados)) {
        // Mostrar tablas por cada tipo de resultado
        foreach ($resultados as $tabla => $filas) {
            echo "<h4 class='mt-4 text-center text-xl font-semibold text-gray-800'>" . ucfirst($tabla) . "</h4>";
            echo "<table class='table table-striped table-hover my-4'>";
            echo "<thead><tr>";

            // Mostrar encabezados dinámicos
            if (!empty($filas)) {
                foreach ($filas[0] as $campo => $valor) {
                    echo "<th>" . ucfirst(str_replace('_', ' ', $campo)) . "</th>";
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
        }
    } else {
        echo "<p class='text-center text-gray-600'>No se encontraron resultados relacionados con la pieza.</p>";
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include('../../includes/footer.php') ?>
</html>
