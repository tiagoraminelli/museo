<?php
session_start();
if(!isset($_SESSION['usuario_activo']) && $_SESSION['nivel'] != 'administrador'){
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../index.php");
    exit;
}
// Verificar si el usuario está logueado
require_once("../modelo/bd.php");
require_once("../modelo/usuarioPieza.php");

// Crear una instancia de la clase UsuarioHasPieza
$usuarioHasPieza = new UsuarioHasPieza();
$breadcrumb = "Historial";
// Parámetros de paginación
$porPagina = 10; // Número de registros por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener los registros con límite de paginación
$registros = $usuarioHasPieza->getPaginados($porPagina, $offset);

// Obtener el número total de registros para calcular la paginación
$totalRegistros = $usuarioHasPieza->getCantidadRegistros();
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
    <title>Listado de Usuario-Pieza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/Pieza.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<?php include('../includes/navListados.php')?>
<?php include('../includes/breadcrumb.php')?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Historial de cargas</h1>

    <!-- Contenedor para descargar el historial -->
    <div class="mb-4 text-center">
        <p class="text-gray-700 mb-2">Descarga el historial completo de registros de usuario-pieza para tu documentación.</p>
        <a href="./funciones/descargarHistorial.php" class="btn btn-primary">Descargar Historial</a>
    </div>
    
    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID Usuario</th>
                <th>ID Pieza</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($registros)) : ?>
                <?php foreach ($registros as $registro) : ?>
                    <tr id="usuario-pieza-<?php echo $registro['Usuario_idUsuario']; ?>-<?php echo $registro['Pieza_idPieza']; ?>" class="text-center">
                        <td><?php echo $registro['Usuario_idUsuario']; ?></td>
                        <td><?php echo $registro['Pieza_idPieza']; ?></td>
                        <td><?php echo $registro['fecha_registro']; ?></td>
                        <td>
                            <a href="funciones/eliminarHistorial.php?usuario=<?php echo $registro['Usuario_idUsuario']; ?>&pieza=<?php echo $registro['Pieza_idPieza']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="text-center">No hay registros de usuario-pieza.</td>
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

    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmación de Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este elemento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mostrar el modal de mensaje si hay un mensaje
        <?php if ($mensaje) : ?>
            var mensajeModal = new bootstrap.Modal(document.getElementById('mensajeModal'));
            mensajeModal.show();
        <?php endif; ?>

        // Eliminar el elemento al confirmar
        document.getElementById('confirmDelete').addEventListener('click', function () {
            var usuarioId = this.getAttribute('data-usuario');
            var piezaId = this.getAttribute('data-pieza');
            window.location.href = 'funciones/eliminarHistorial.php?usuario=' + usuarioId + '&pieza=' + piezaId;
        });
    });

    // Mostrar modal de confirmación de eliminación
    var deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            var usuarioId = this.closest('tr').querySelector('td:nth-child(1)').textContent;
            var piezaId = this.closest('tr').querySelector('td:nth-child(2)').textContent;
            document.getElementById('confirmDelete').setAttribute('data-usuario', usuarioId);
            document.getElementById('confirmDelete').setAttribute('data-pieza', piezaId);
        });
    });

</script>

<?php include('../includes/footer.php') ?>

</body>
</html>
