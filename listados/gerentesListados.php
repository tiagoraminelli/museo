<?php
session_start();

if(!isset($_SESSION['usuario_activo'])){
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../index.php");
    exit;
}
// Verificar el tipo de usuario

if($_SESSION['nivel'] != 'administrador'){
    header("Location: ../index.php");
}  
// Verificar si el usuario está logueado
require_once("../modelo/bd.php");
require_once("../modelo/usuario.php");

// Crear una instancia de la clase Usuario
$usuario = new Usuario();

// Parámetros de paginación
$porPagina = 10; // Número de usuarios por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener todos los usuarios con límite de paginación
$usuarios = $usuario->getUsuariosPaginados($porPagina, $offset);

// Obtener el número total de usuarios para calcular la paginación
$totalUsuarios = $usuario->getCantidadUsuarios();
$totalPaginas = ceil($totalUsuarios / $porPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/usuario.css">
</head>
<body>
<?php include('../includes/navListados.php')?>

<!-- Buscador -->
<div class="container mt-4">
    <div class="search-box">
        <form class="d-flex" id="searchForm" action="./funciones/buscarUsuario.php" method="post">
            <input class="form-control me-2" type="search" id="searchInput" placeholder="Buscar..." aria-label="Buscar">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </form>
    </div>
</div>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Usuarios</h1>
    
    <table class="table table-hover table-bordered" id="usuarioTable">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Fecha de Alta</th>
                <th>Tipo de Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)) : ?>
                <?php foreach ($usuarios as $u) : ?>
                    <tr id="usuario-<?php echo $u['idUsuario']; ?>" class="text-center">
                        <td><?php echo $u['idUsuario']; ?></td>
                        <td><?php echo $u['dni']; ?></td>
                        <td><?php echo $u['nombre']; ?></td>
                        <td><?php echo $u['apellido']; ?></td>
                        <td><?php echo $u['email']; ?></td>
                        <td><?php echo $u['fecha_alta']; ?></td>
                        <td><?php echo $u['tipo_de_usuario']; ?></td>
                        <td>
                            <a href="funciones/editarUsuario.php?id=<?php echo $u['idUsuario']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="funciones/eliminarUsuario.php?id=<?php echo $u['idUsuario']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center">No hay registros de usuarios.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav aria-label="Paginación" class="mt-4">
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

  <!-- Modal de éxito -->
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    El gerente se ha actualizado correctamente.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

      <!-- Modal de éxito para eliminación -->
      <div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteSuccessModalLabel">Eliminación Exitosa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    El gerente se ha eliminado correctamente.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            const searchTerm = $(this).val();

            $.ajax({
                url: './funciones/buscarUsuario.php',
                method: 'GET',
                data: { search: searchTerm },
                success: function(data) {
                    const tbody = $('#usuarioTable tbody');
                    tbody.empty();

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="8" class="text-center">No hay resultados.</td></tr>');
                    } else {
                        data.forEach(u => {
                            tbody.append(`
                                <tr id="usuario-${u.idUsuario}" class="text-center">
                                    <td>${u.idUsuario}</td>
                                    <td>${u.dni}</td>
                                    <td>${u.nombre}</td>
                                    <td>${u.apellido}</td>
                                    <td>${u.email}</td>
                                    <td>${u.fecha_alta}</td>
                                    <td>${u.tipo_de_usuario}</td>
                                    <td>
                                        <a href="funciones/editarUsuario.php?id=${u.idUsuario}" class="btn btn-warning btn-sm">Editar</a>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
<script>
        // Mostrar el modal automáticamente si el parámetro "actualizado" está en la URL
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('actualizado') && urlParams.get('actualizado') === '1') {
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            }
        });
</script>

<script>
        // Mostrar el modal automáticamente si el parámetro "eliminado" está en la URL
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('eliminado') && urlParams.get('eliminado') === '1') {
                const deleteSuccessModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
                deleteSuccessModal.show();
            }
        });
</script>
<?php include('../includes/footer.php') ?>
</body>
</html>