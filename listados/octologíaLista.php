<?php
session_start();
// Verificar si el usuario está logueado
require_once("../modelo/bd.php");
require_once("../modelo/octologia.php");

$getClasificacion = "Octología";
// Crear una instancia de la clase 
$octologia = new Octologia();

// Parámetros de paginación
$porPagina = 10; // Número de octologías por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener todas las octologías con límite de paginación
$octologias = $octologia->getOctologiasPaginadas($porPagina, $offset);

// Obtener el número total de octologías para calcular la paginación
$totalOctologias = $octologia->getTotalOctologias();
$totalPaginas = ceil($totalOctologias / $porPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Octologías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>
<body>
<?php include('../includes/navListados.php')?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Octologías</h1>
    
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar octologías...">
    </div>

    <table class="table table-hover table-bordered" id="octologiaTable">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Clasificación</th>
                <th>Tipo</th>
                <th>Especie</th>
                <th>Descripción</th>
                <th>ID de la Pieza</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($octologias)) : ?>
                <?php foreach ($octologias as $o) : ?>
                    <tr id="octologia-<?php echo $o['idOctologia']; ?>" class="text-center">
                        <td><?php echo $o['idOctologia']; ?></td>
                        <td><?php echo $o['clasificacion']; ?></td>
                        <td><?php echo $o['tipo']; ?></td>
                        <td><?php echo $o['especie']; ?></td>
                        <td><?php echo $o['descripcion']; ?></td>
                        <td><?php echo $o['Pieza_idPieza']; ?></td>
                        <td>
                            <a href="funciones/editarPieza.php?id=<?php echo $o['Pieza_idPieza']; ?>&clasificacion=<?php echo $getClasificacion; ?>" class="btn btn-warning btn-sm">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="text-center">No hay registros de octologías.</td>
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
                    const tbody = $('#octologiaTable tbody');
                    tbody.empty();

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="7" class="text-center">No hay resultados.</td></tr>');
                    } else {
                        data.forEach(o => {
                            tbody.append(`
                                <tr id="octologia-${o.idOctologia}" class="text-center">
                                    <td>${o.idOctologia}</td>
                                    <td>${o.clasificacion}</td>
                                    <td>${o.tipo}</td>
                                    <td>${o.especie}</td>
                                    <td>${o.descripcion}</td>
                                    <td>${o.Pieza_idPieza}</td>
                                    <td>
                                        <a href="funciones/editarPieza.php?id=${o.Pieza_idPieza}&clasificacion=${clasificacion}" class="btn btn-warning btn-sm">Editar</a>
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
