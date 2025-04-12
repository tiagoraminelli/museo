<?php
session_start();

if(!isset($_SESSION['usuario_activo'])){
    header("Location: ../index.php");
    exit;
}

if($_SESSION['nivel'] != 'administrador'){
    header("Location: ../index.php");
}  

require_once("../modelo/bd.php");
require_once("../modelo/usuario.php");

$usuario = new Usuario();

// Manejo de búsqueda
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Parámetros de paginación
$porPagina = 10;
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener usuarios (con búsqueda si aplica)
if(!empty($searchTerm)) {
    $usuarios = $usuario->buscarUsuario($searchTerm);
    $totalUsuarios = count($usuarios);
    // Aplicar paginación manual para resultados de búsqueda
    $usuarios = array_slice($usuarios, $offset, $porPagina);
} else {
    $usuarios = $usuario->getUsuariosPaginados($porPagina, $offset);
    $totalUsuarios = $usuario->getCantidadUsuarios();
}

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

<!-- Buscador mejorado -->
<div class="container mt-4">
    <form class="d-flex" method="GET" action="">
        <input class="form-control me-2" type="search" name="search" id="searchInput" 
               placeholder="Buscar por DNI, nombre, apellido, email..." 
               value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button class="btn btn-outline-primary" type="submit">Buscar</button>
        <?php if(!empty($searchTerm)): ?>
            <a href="?" class="btn btn-outline-secondary ms-2">Limpiar</a>
        <?php endif; ?>
    </form>
    <?php if(!empty($searchTerm)): ?>
        <div class="mt-2 text-muted">
            Mostrando resultados para: <strong><?php echo htmlspecialchars($searchTerm); ?></strong>
        </div>
    <?php endif; ?>
</div>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Usuarios</h1>
    
    <div class="table-responsive">
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
                            <td><?php echo htmlspecialchars($u['dni']); ?></td>
                            <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($u['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo $u['fecha_alta']; ?></td>
                            <td><?php echo htmlspecialchars($u['tipo_de_usuario']); ?></td>
                            <td>
                                <a href="funciones/editarUsuario.php?id=<?php echo $u['idUsuario']; ?>" 
                                   class="btn btn-warning btn-sm">Editar</a>
                                <a href="funciones/eliminarUsuario.php?id=<?php echo $u['idUsuario']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            <?php echo empty($searchTerm) ? 'No hay registros de usuarios.' : 'No se encontraron resultados.'; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación mejorada -->
    <?php if($totalPaginas > 1): ?>
    <nav aria-label="Paginación" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $paginaActual == 1 ? 'disabled' : ''; ?>">
                <a class="page-link" 
                   href="?<?php echo !empty($searchTerm) ? 'search='.urlencode($searchTerm).'&' : ''; ?>pagina=<?php echo $paginaActual - 1; ?>" 
                   tabindex="-1">Anterior</a>
            </li>

            <?php 
            // Mostrar solo un rango de páginas alrededor de la actual
            $inicio = max(1, $paginaActual - 2);
            $fin = min($totalPaginas, $paginaActual + 2);
            
            if($inicio > 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            
            for ($i = $inicio; $i <= $fin; $i++) : ?>
                <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                    <a class="page-link" 
                       href="?<?php echo !empty($searchTerm) ? 'search='.urlencode($searchTerm).'&' : ''; ?>pagina=<?php echo $i; ?>">
                       <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; 
            
            if($fin < $totalPaginas) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            ?>

            <li class="page-item <?php echo $paginaActual == $totalPaginas ? 'disabled' : ''; ?>">
                <a class="page-link" 
                   href="?<?php echo !empty($searchTerm) ? 'search='.urlencode($searchTerm).'&' : ''; ?>pagina=<?php echo $paginaActual + 1; ?>">
                   Siguiente
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<!-- Modal para operaciones exitosas (crear/editar) -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <!-- Icono de éxito -->
                <div class="text-success mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                </div>
                
                <!-- Mensaje dinámico -->
                <h3 class="h4 mb-3" id="successModalTitle">Operación Exitosa</h3>
                <p class="text-muted" id="successModalMessage">La pieza se ha guardado correctamente.</p>
                
                <!-- Botón de acción -->
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                    <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">
                        <i class="bi bi-check-circle me-2"></i> Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal para eliminación exitosa -->
<div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <!-- Icono de confirmación -->
                <div class="text-danger mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                    </svg>
                </div>
                
                <!-- Mensaje -->
                <h3 class="h4 mb-3">Eliminación Confirmada</h3>
                <p class="text-muted">La pieza ha sido eliminada permanentemente del sistema.</p>
                
                <!-- Botones de acción -->
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                    <button type="button" class="btn btn-outline-secondary px-4 me-2" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i> Cerrar
                    </button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDeleteBtn" data-bs-dismiss="modal">
                        <i class="bi bi-trash me-2"></i> Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mostrar modales según parámetros URL
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('actualizado') && urlParams.get('actualizado') === '1') {
            new bootstrap.Modal(document.getElementById('successModal')).show();
        }
        
        if (urlParams.has('eliminado') && urlParams.get('eliminado') === '1') {
            new bootstrap.Modal(document.getElementById('deleteSuccessModal')).show();
        }
    });
</script>
<?php include('../includes/footer.php') ?>
</body>
</html>