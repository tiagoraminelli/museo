<?php
session_start();
// Verificar si el usuario está logueado
require_once("../modelo/bd.php");
require_once("../modelo/botanica.php");

$getClasificacion = "Botánica";
// Crear una instancia de la clase 
$botanica = new Botanica();

// Parámetros de paginación
$porPagina = 10; // Número de botánicas por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener todas las botánicas con límite de paginación
$botanicas = $botanica->getBotanicasPaginadas($porPagina, $offset);

// Obtener el número total de botánicas para calcular la paginación
$totalBotanicas = $botanica->getCantidadBotanica();
$totalPaginas = ceil($totalBotanicas / $porPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Botánicas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>

<body>
<?php include('../includes/navListados.php')?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Botánicas</h1>
    
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar botánicas...">
    </div>

    <table class="table table-hover table-bordered" id="botanicaTable">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Reino</th>
                <th>Familia</th>
                <th>Especie</th>
                <th>Orden</th>
                <th>División</th>
                <th>Clase</th>
                <th>Descripción</th>
                <th>ID de la Pieza</th>
                <?php if (isset($_SESSION['usuario_activo'])): ?>
                <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($botanicas)) : ?>
                <?php foreach ($botanicas as $b) : ?>
                    <tr id="botanica-<?php echo $b['idBotanica']; ?>" class="text-center">
                        <td><?php echo $b['idBotanica']; ?></td>
                        <td><?php echo $b['reino']; ?></td>
                        <td><?php echo $b['familia']; ?></td>
                        <td><?php echo $b['especie']; ?></td>
                        <td><?php echo $b['orden']; ?></td>
                        <td><?php echo $b['division']; ?></td>
                        <td><?php echo $b['clase']; ?></td>
                        <td><?php echo $b['descripcion']; ?></td>
                        <td><?php echo $b['Pieza_idPieza']; ?></td>
                        <?php if (isset($_SESSION['usuario_activo'])): ?>
                        <td>
                            <div class="d-flex justify-content-center">
                            <a href="funciones/editarPieza.php?id=<?php echo $b['Pieza_idPieza']; ?>&clasificacion=<?php echo $getClasificacion; ?>" class="btn btn-warning btn-sm">Editar</a>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="10" class="text-center">No hay registros de botánicas.</td>
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
                    const tbody = $('#botanicaTable tbody');
                    tbody.empty();

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="10" class="text-center">No hay resultados.</td></tr>');
                    } else {
                        data.forEach(b => {
                            tbody.append(`
                                <tr id="botanica-${b.idBotanica}" class="text-center">
                                    <td>${b.idBotanica}</td>
                                    <td>${b.reino}</td>
                                    <td>${b.familia}</td>
                                    <td>${b.especie}</td>
                                    <td>${b.orden}</td>
                                    <td>${b.division}</td>
                                    <td>${b.clase}</td>
                                    <td>${b.descripcion}</td>
                                    <td>${b.Pieza_idPieza}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="funciones/editarPieza.php?id=${b.Pieza_idPieza}&clasificacion=${clasificacion}" class="btn btn-warning btn-sm">Editar</a>
                                        </div>
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
