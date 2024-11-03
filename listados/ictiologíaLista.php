<?php
session_start();
// Verificar si el usuario está logueado
require_once("../modelo/bd.php");
require_once("../modelo/ictiologia.php");

$getClasificacion = "Ictiología";
// Crear una instancia de la clase 
$ictiologia = new Ictiologia();

// Parámetros de paginación
$porPagina = 10; // Número de ictiologías por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener todas las ictiologías con límite de paginación
$ictiologias = $ictiologia->getIctiologiasPaginadas($porPagina, $offset);

// Obtener el número total de ictiologías para calcular la paginación
$totalIctiologias = $ictiologia->getCantidadIctiologia();
$totalPaginas = ceil($totalIctiologias / $porPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Ictiología</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>
<body>
<?php include('../includes/navListados.php') ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Ictiología</h1>
    
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar ictiologías...">
    </div>

    <table class="table table-hover table-bordered" id="ictiologiaTable">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Clasificación</th>
                <th>Especies</th>
                <th>Descripción</th>
                <th>ID de la Pieza</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($ictiologias)) : ?>
                <?php foreach ($ictiologias as $i) : ?>
                    <tr id="ictiologia-<?php echo $i['idIctiologia']; ?>" class="text-center">
                        <td><?php echo $i['idIctiologia']; ?></td>
                        <td><?php echo $i['clasificacion']; ?></td>
                        <td><?php echo $i['especies']; ?></td>
                        <td><?php echo $i['descripcion']; ?></td>
                        <td><?php echo $i['Pieza_idPieza']; ?></td>
                        <td>
                            <a href="funciones/editarPieza.php?id=<?php echo $i['Pieza_idPieza']; ?>&clasificacion=<?php echo $getClasificacion; ?>" class="btn btn-warning btn-sm">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">No hay registros de ictiología.</td>
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
                    const tbody = $('#ictiologiaTable tbody');
                    tbody.empty();

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="6" class="text-center">No hay resultados.</td></tr>');
                    } else {
                        data.forEach(i => {
                            tbody.append(`
                                <tr id="ictiologia-${i.idIctiologia}" class="text-center">
                                    <td>${i.idIctiologia}</td>
                                    <td>${i.clasificacion}</td>
                                    <td>${i.especies}</td>
                                    <td>${i.descripcion}</td>
                                    <td>${i.Pieza_idPieza}</td>
                                    <td>
                                        <a href="funciones/editarPieza.php?id=${i.Pieza_idPieza}&clasificacion=${clasificacion}" class="btn btn-warning btn-sm">Editar</a>
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
