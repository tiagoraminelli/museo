<?php
session_start();
// Verificar si el usuario está logueado
require_once("../modelo/bd.php");
require_once("../modelo/arqueologia.php");


$getClasificacion = "Arqueología";
// Crear una instancia de la clase 
$arqueologia = new Arqueologia();

// Parámetros de paginación
$porPagina = 10; // Número de arqueologías por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener todas las arqueologías con límite de paginación
$arqueologias = $arqueologia->getArqueologiasPaginadas($porPagina, $offset);

// Obtener el número total de arqueologías para calcular la paginación
$totalArqueologias = $arqueologia->getCantidadArqueologia();
$totalPaginas = ceil($totalArqueologias / $porPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Arqueología</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>
<body>
<?php include('../includes/navListados.php')?>


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
    <h1 class="mb-4 text-center">Listado de Arqueología</h1>
    
    <table class="table table-hover table-bordered" id="arqueologiaTable">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Integridad Histórica</th>
                <th>Estética</th>
                <th>Material</th>
                <th>ID de la Pieza</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($arqueologias)) : ?>
                <?php foreach ($arqueologias as $a) : ?>
                    <tr id="arqueologia-<?php echo $a['idArqueologia']; ?>" class="text-center">
                        <td><?php echo $a['idArqueologia']; ?></td>
                        <td><?php echo $a['integridad_historica']; ?></td>
                        <td><?php echo $a['estetica']; ?></td>
                        <td><?php echo $a['material']; ?></td>
                        <td><?php echo $a['Pieza_idPieza']; ?></td>
                        <td>
                            <a href="funciones/editarPieza.php?id=<?php echo $a['Pieza_idPieza']; ?>&clasificacion=<?php echo $getClasificacion; ?>" class="btn btn-warning btn-sm">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">No hay registros de arqueología.</td>
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
                    const tbody = $('#arqueologiaTable tbody');
                    tbody.empty();

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="6" class="text-center">No hay resultados.</td></tr>');
                    } else {
                        data.forEach(a => {
                            tbody.append(`
                                <tr id="arqueologia-${a.idArqueologia}" class="text-center">
                                    <td>${a.idArqueologia}</td>
                                    <td>${a.integridad_historica}</td>
                                    <td>${a.estetica}</td>
                                    <td>${a.material}</td>
                                    <td>${a.Pieza_idPieza}</td>
                                    <td>
                                        <a href="funciones/editarPieza.php?id=${a.Pieza_idPieza}&clasificacion=${clasificacion}" class="btn btn-warning btn-sm">Editar</a>
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
