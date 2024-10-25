<?php
session_start();
// Verificar si el usuario está logueado
require_once "../modelo/pieza.php";

// Crear una instancia de la clase Pieza
$breadcrumb = "Pieza";
$pieza = new Pieza();

// Parámetros de paginación
$porPagina = 10; // Número de piezas por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener todas las piezas con límite de paginación
$piezas = $pieza->getPiezasPaginadas($porPagina, $offset);

// Obtener el número total de piezas para calcular la paginación
$totalPiezas = $pieza->getTotalPiezas();
$totalPaginas = ceil($totalPiezas / $porPagina);

// Verificar si hay un mensaje de eliminación
$eliminado = isset($_GET['eliminado']) ? intval($_GET['eliminado']) : -1; // -1 si no hay mensaje
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Piezas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
 
    <link rel="stylesheet" href="./public/css/index.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
</head>


<?php include('../includes/navListados.php')?>
<?php include('../includes/breadcrumb.php')?>

<!-- Contenedor de información sobre crear pieza y descargar PDF -->
<div class="container mt-8 text-center">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h4 class="text-2xl font-bold text-gray-800 mb-4">Crear una Nueva Pieza</h4>
        <p class="text-gray-600 mb-4">
            Si deseas añadir una nueva pieza a nuestro registro, dirígete al formulario correspondiente. Esto te permitirá mantener nuestra base de datos actualizada con las últimas adiciones y garantizar una gestión eficiente de nuestras piezas.
        </p>
        <a href="./funciones/formularioAgregar.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition">Cargar Nueva Pieza</a>
        <hr class="my-4 border-gray-300">
        <p class="mb-2 text-gray-600">
            También puedes descargar el PDF con información de todas las piezas. Esto es útil para la documentación, auditorías o para compartir información con otros interesados.
        </p>
        <a href="" class="text-blue-600 hover:underline">Descargar PDF de Todas las Piezas</a>
    </div>
</div>

<!-- Buscador -->
<div class="container mt-4">
    <div class="search-box">
        <form class="d-flex" id="searchForm" action="./funciones/buscarPieza.php" method="post">
            <input class="form-control me-2" type="search" id="searchInput" placeholder="Buscar..." aria-label="Buscar">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </form>
    </div>
</div>

<div class="container mt-5">
    <h1 class="mb-4 text-center text-2xl font-bold">Listado de Piezas</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Número de Inventario</th>
                <th>Especie</th>
                <th>Estado de Conservación</th>
                <th>Fecha de ingreso</th>
                <th>Cantidad de Piezas</th>
                <th>Clasificacion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($piezas)) : ?>
                <?php foreach ($piezas as $p) : ?>
                    <tr id="pieza-<?php echo $p['idPieza']; ?>" class="text-center">
                        <td><?php echo $p['idPieza']; ?></td>
                        <td><?php echo $p['num_inventario']; ?></td>
                        <td><?php echo $p['especie']; ?></td>
                        <td><?php echo $p['estado_conservacion']; ?></td>
                        <td><?php echo $p['fecha_ingreso']; ?></td>
                        <td><?php echo $p['cantidad_de_piezas']; ?></td>
                        <td><?php echo $p['clasificacion']; ?></td>
                        <td>
                            <!-- Botón para ver -->
                            <a href="funciones/verPieza.php?id=<?php echo $p['idPieza']; ?>" class="btn btn-success btn-sm">Ver</a>

                            <!-- Botón para editar -->
                            <a href="funciones/editarPieza.php?id=<?php echo $p['idPieza']; ?>&clasificacion=<?php echo ($p['clasificacion']); ?>" class="btn btn-warning btn-sm">Editar</a>


                            <!-- Botón para eliminar -->
                            <a href="funciones/eliminarPieza.php?id=<?php echo $p['idPieza']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center">No hay piezas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

      <!-- Paginación -->
      <nav aria-label="Paginación" class="mt-4">
        <ul class="pagination justify-content-center">
            <!-- Botón anterior -->
            <li class="page-item <?php echo $paginaActual == 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>" tabindex="-1">Anterior</a>
            </li>

            <!-- Páginas numeradas -->
            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <!-- Botón siguiente -->
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
                    La pieza ha sido eliminada exitosamente.
                <?php elseif ($eliminado == 0): ?>
                    Hubo un error al eliminar la pieza.
                <?php else: ?>
                    <!-- No se muestra nada si no hay un mensaje -->
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

        fetch(`./funciones/buscarPieza.php?search=${encodeURIComponent(searchTerm)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Actualizar la tabla con los datos devueltos
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="8" class="text-center">No hay resultados.</td></tr>';
                } else {
                    data.forEach(p => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${p.idPieza}</td>
                            <td>${p.num_inventario}</td>
                            <td>${p.especie}</td>
                            <td>${p.estado_conservacion}</td>
                            <td>${p.fecha_ingreso}</td>
                            <td>${p.cantidad_de_piezas}</td>
                            <td>${p.Donante_idDonante}</td>
                            <td>
                                <a href="funciones/verPieza.php?id=${p.idPieza}" class="btn btn-success btn-sm">Ver</a>
                                <a href="funciones/editarPieza.php?id=${p.idPieza}" class="btn btn-warning btn-sm">Editar</a>
                                <a href="funciones/eliminarPieza.php?id=${p.idPieza}" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
</body>
<?php include('../includes/footer.php') ?>
</html>

