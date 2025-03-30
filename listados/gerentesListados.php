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
                                <a href="eliminarUsuario.php?id=<?php echo $u['idUsuario']; ?>" 
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

<!-- Modales (se mantienen igual) -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <!-- Contenido del modal -->
</div>

<div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-hidden="true">
    <!-- Contenido del modal -->
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