<?php
session_start();
// Verificar si el usuario está logueado (puedes usar una variable de sesión específica)
require_once("../modelo/bd.php");
require_once("../modelo/registros_eliminados.php");

// Crear una instancia de la clase RegistrosEliminados
$registrosEliminados = new registros_eliminados();
$breadcrumb = "Registros Eliminados";
// Parámetros de paginación
$porPagina = 10; // Número de registros por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener los registros eliminados con límite de paginación
$registros = $registrosEliminados->getAllRegistrosEliminados();
$totalRegistros = count($registros);
$totalPaginas = ceil($totalRegistros / $porPagina);
echo "<pre>";
//var_dump($registros);
echo "</pre>";
// Mensaje para el modal
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
unset($_SESSION['mensaje']); // Limpiar mensaje después de mostrarlo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Registros Eliminados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<?php include('../includes/navListados.php')?>
<?php include('../includes/breadcrumb.php')?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Registros Eliminados</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="bg-white text-center">
            <tr>
                <th>ID Eliminado</th>
                <th>ID Pieza</th>
                <th>Número de Inventario</th>
                <th>Especie</th>
                <th>Estado de Conservación</th>
                <th>Fecha de Ingreso</th>
                <th>Cantidad de Piezas</th>
                <th>Clasificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($registros)) : ?>
                <?php foreach ($registros as $registro) : ?>
                    <tr class="text-center">
                        <td><?php echo $registro['id']; ?></td>
                        <td><?php echo $registro['idPieza']; ?></td>
                        <td><?php echo $registro['num_inventario']; ?></td>
                        <td><?php echo $registro['especie']; ?></td>
                        <td><?php echo $registro['estado_conservacion']; ?></td>
                        <td><?php echo $registro['fecha_ingreso']; ?></td>
                        <td><?php echo $registro['cantidad_de_piezas']; ?></td>
                        <td><?php echo $registro['clasificacion']; ?></td>
                        <td>
                            <a href="funciones/restaurarRegistro.php?id=<?php echo $registro['idPieza']; ?>" class="btn btn-success btn-sm">Restaurar</a>
                            <a href="funciones/eliminarRegistro.php?id=<?php echo $registro['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="12" class="text-center">No hay registros eliminados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

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

    <!-- Mensaje de eliminación -->
    <div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mensajeModalLabel">Resultado de la Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($mensaje) : ?>
                        <p><?php echo $mensaje; ?></p>
                    <?php else : ?>
                        <p>No se pudo realizar la operación.</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mostrar el modal de mensaje si hay un mensaje
        <?php if ($mensaje) : ?>
            var mensajeModal = new bootstrap.Modal(document.getElementById('mensajeModal'));
            mensajeModal.show();
        <?php endif; ?>
    });
</script>

<?php include('../includes/footer.php') ?>
</body>
</html>
