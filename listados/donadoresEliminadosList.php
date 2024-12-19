<?php
session_start();
if (!isset($_SESSION['usuario_activo'])) {
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../index.php");
    exit;
}
if($_SESSION['nivel'] != 'administrador'){
    header("Location: ../index.php");
}  

// Verificar si el usuario está logueado (puedes usar una variable de sesión específica)
require_once("../modelo/bd.php");
require_once("../modelo/donadores_eliminados.php"); // Asegúrate de que este archivo esté presente

// Crear una instancia de la clase DonadoresEliminados
$donadoresEliminados = new DonadoresEliminados();
$breadcrumb = "Donadores Eliminados";
// Parámetros de paginación
$porPagina = 10; // Número de registros por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;
//$datosTotales = $donadoresEliminados->getDonadoresEliminados();
//var_dump($datosTotales);
// Obtener los registros eliminados con límite de paginación
$registros = $donadoresEliminados->getDonadoresEliminados($offset, $porPagina); // Asegúrate de que esta función esté implementada
//var_dump($registros);
$totalRegistros = $donadoresEliminados->getTotalDonadoresEliminados(); // Método para contar total de registros
$totalPaginas = ceil($totalRegistros / $porPagina);

// Mensaje para el modal
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
unset($_SESSION['mensaje']); // Limpiar mensaje después de mostrarlo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Donadores Eliminados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../includes/navListados.php') ?>
<?php include('../includes/breadcrumb.php') ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Donadores Eliminados</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="bg-white text-center">
            <tr>
                <th>ID Eliminado</th>
                <th>ID Donante</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de Donación</th>
                <th>Fecha de Eliminación</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($registros)) : ?>
                <?php foreach ($registros as $registro) : ?>
                    <tr class="text-center">
                        <td><?php echo $registro['id']; ?></td>
                        <td><?php echo $registro['idDonante']; ?></td>
                        <td><?php echo $registro['nombre']; ?></td>
                        <td><?php echo $registro['apellido']; ?></td>
                        <td><?php echo $registro['fecha']; ?></td>
                        <td><?php echo $registro['fecha_eliminacion']; ?></td>
                       
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="text-center">No hay donadores eliminados.</td>
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
                    <h5 class="modal-title" id="mensajeModalLabel">Resultado de la Operación</h5>
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
