<?php
session_start();
// Verificar si el usuario está logueado
require_once "../modelo/donante.php";

// Crear una instancia de la clase Donante
$breadcrumb = "Donante";
$donante = new Donante();

// Parámetros de paginación
$porPagina = 10; // Número de donantes por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener todos los donantes con límite de paginación
$donantes = $donante->getDonantesPaginados($porPagina, $offset);

// Obtener el número total de donantes para calcular la paginación
$totalDonantes = $donante->getTotalDonantes();
$totalPaginas = ceil($totalDonantes / $porPagina);

// Verificar si hay un mensaje de eliminación
$eliminado = isset($_GET['eliminado']) ? intval($_GET['eliminado']) : -1; // -1 si no hay mensaje
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Donantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>

<body>
<?php include('../includes/navListados.php')?>
<?php include('../includes/breadcrumb.php')?>

<!-- Contenedor de información sobre crear donante -->
<div class="container mt-4 text-center">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Crear un nuevo donante</h4>
        <p>Si deseas crear un nuevo donante, dirígete al formulario correspondiente.</p>
        <a href="./funciones/formularioAgregarDonante.php" class="btn btn-primary">Cargar nuevo donante</a>
    </div>
</div>

<!-- Buscador -->
<div class="container mt-4">
    <div class="search-box">
        <form class="d-flex" id="searchForm" action="./funciones/buscarDonante.php" method="post">
            <input class="form-control me-2" type="search" id="searchInput" placeholder="Buscar..." aria-label="Buscar">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </form>
    </div>
</div>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Donantes</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de Donación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($donantes)) : ?>
                <?php foreach ($donantes as $d) : ?>
                    <tr id="donante-<?php echo $d['idDonante']; ?>" class="text-center">
                        <td><?php echo $d['idDonante']; ?></td>
                        <td><?php echo $d['nombre']; ?></td>
                        <td><?php echo $d['apellido']; ?></td>
                        <td><?php echo $d['fecha']; ?></td>
                        <td>
                            <a href="funciones/verDonante.php?id=<?php echo $d['idDonante']; ?>" class="btn btn-success btn-sm">Ver</a>
                            <a href="funciones/formularioAgregarDonante.php?idDonante=<?php echo $d['idDonante']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="funciones/eliminarDonante.php?id=<?php echo $d['idDonante']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">No hay donantes registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav aria-label="Paginación">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $paginaActual == 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>" tabindex="-1">Anterior</a>
            </li>
            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $paginaActual == $totalPaginas ? 'disabled' : ''; ?>">
                <a class="page-link" href="?pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Modal para mostrar resultado de la eliminación -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Resultado de Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($eliminado == 1): ?>
                    El donante ha sido eliminado exitosamente.
                <?php elseif ($eliminado == 0): ?>
                    Hubo un error al eliminar el donante.
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mostrar el modal al cargar la página si hay un mensaje de eliminación
    document.addEventListener("DOMContentLoaded", function() {
        <?php if ($eliminado != -1): ?>
            var eliminarModal = new bootstrap.Modal(document.getElementById('eliminarModal'));
            eliminarModal.show();
        <?php endif; ?>
    });
</script>
<script>
    document.querySelector('.search-box form').addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = this.querySelector('input[type="search"]').value;

        fetch(`./funciones/buscarDonante.php?search=${encodeURIComponent(searchTerm)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = ''; // Limpiar el contenido actual

                if (data.length > 0) {
                    data.forEach(d => {
                        const row = `
                            <tr id="donante-${d.idDonante}" class="text-center">
                                <td>${d.idDonante}</td>
                                <td>${d.nombre}</td>
                                <td>${d.apellido}</td>
                                <td>${d.fecha}</td>
                                <td>
                                    <a href="funciones/verDonante.php?id=${d.idDonante}" class="btn btn-success btn-sm">Ver</a>
                                    <a href="funciones/editarDonante.php?id=${d.idDonante}" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="funciones/eliminarDonante.php?id=${d.idDonante}" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        `;
                        tbody.innerHTML += row; // Agregar la nueva fila a la tabla
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center">No se encontraron donantes.</td></tr>`;
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>

</body>
<?php include('../includes/footer.php') ?>
</html>
