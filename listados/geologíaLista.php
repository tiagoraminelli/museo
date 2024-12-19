<?php
session_start();
// Verificar si el usuario está logueado
require_once("../modelo/bd.php");
require_once("../modelo/geologia.php");

$getClasificacion = "Geología";
// Crear una instancia de la clase 
$geologia = new Geologia();

// Parámetros de paginación
$porPagina = 10; // Número de geologías por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener todas las geologías con límite de paginación
$geologias = $geologia->getGeologiasPaginadas($porPagina, $offset);

// Obtener el número total de geologías para calcular la paginación
$totalGeologias = $geologia->getCantidadGeologia();
$totalPaginas = ceil($totalGeologias / $porPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Geologías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>
<body>
<?php include('../includes/navListados.php') ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Geologías</h1>
    
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar geologías...">
    </div>

    <table class="table table-hover table-bordered" id="geologiaTable">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Tipo de Rocas</th>
                <th>Descripción</th>
                <th>ID de la Pieza</th>
                <?php if (isset($_SESSION['usuario_activo'])): ?>
                <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($geologias)) : ?>
                <?php foreach ($geologias as $g) : ?>
                    <tr id="geologia-<?php echo $g['idGeologia']; ?>" class="text-center">
                        <td><?php echo $g['idGeologia']; ?></td>
                        <td><?php echo $g['tipo_rocas']; ?></td>
                        <td><?php echo $g['descripcion']; ?></td>
                        <td><?php echo $g['Pieza_idPieza']; ?></td>
                        <?php if (isset($_SESSION['usuario_activo'])): ?>
                        <td>
                            <a href="funciones/editarPieza.php?id=<?php echo $g['Pieza_idPieza']; ?>&clasificacion=<?php echo $getClasificacion; ?>" class="btn btn-warning btn-sm">Editar</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">No hay registros de geología.</td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            const searchTerm = $(this).val();
            const clasificacion = "<?php echo $getClasificacion; ?>"; // Obtener la clasificación actual

            $.ajax({
                url: './funciones/buscarPiezaByClasificacion.php',
                method: 'GET',
                data: { search: searchTerm, clasificacion: clasificacion },
                success: function(data) {
                    const tbody = $('#geologiaTable tbody');
                    tbody.empty();

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center">No hay resultados.</td></tr>');
                    } else {
                        data.forEach(g => {
                            tbody.append(`
                                <tr id="geologia-${g.idGeologia}" class="text-center">
                                    <td>${g.idGeologia}</td>
                                    <td>${g.tipo_rocas}</td>
                                    <td>${g.descripcion}</td>
                                    <td>${g.Pieza_idPieza}</td>
                                    <td>
                                        <a href="funciones/editarPieza.php?id=${g.Pieza_idPieza}&clasificacion=${clasificacion}" class="btn btn-warning btn-sm">Editar</a>
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

<?php include('../includes/footer.php') ?>
</body>
</html>
