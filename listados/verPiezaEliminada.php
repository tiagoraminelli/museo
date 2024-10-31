<?php
session_start();
// Verificar si el usuario está logueado (puedes usar una variable de sesión específica)
require_once("../modelo/bd.php");
require_once("../modelo/datos_eliminados.php");

// Crear una instancia de la clase DatosEliminados
$datosEliminados = new DatosEliminados();
$breadcrumb = "Datos Eliminados";
// Parámetros de paginación
$porPagina = 10; // Número de registros por página
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener los registros eliminados con límite de paginación
$datos = $datosEliminados->getDatosEliminadosPaginadas($porPagina, $offset); // Asegúrate de implementar paginación en esta función
$totalRegistros = $datosEliminados->getTotalDatosEliminados();
// Obtener el total de registros
//echo $totalRegistros;
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
    <title>Listado de Datos Eliminados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<?php include('../includes/navListados.php')?>
<?php include('../includes/breadcrumb.php')?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Datos Eliminados</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="bg-white text-center">
            <tr>
                <th>ID Eliminado</th>
                <th>ID Pieza</th>
                <th>ID Clasificación</th>
                <th>Tabla</th>
                <th>Campo 1</th>
                <th>Campo 2</th>
                <th>Campo 3</th>
                <th>Campo 4</th>
                <th>Campo 5</th>
                <th>Campo 6</th>
                <th>Campo 7</th>
                <th>Campo 8</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($datos)) : ?>
                <?php foreach ($datos as $dato) : ?>
                    <tr class="text-center">
                        <td><?php echo $dato['id']; ?></td>
                        <td><?php echo $dato['Pieza_idPieza']; ?></td>
                        <td><?php echo $dato['IdClasificacion']; ?></td>
                        <td><?php echo $dato['Tabla']; ?></td>
                        <td><?php echo $dato['campo1']; ?></td>
                        <td><?php echo $dato['campo2']; ?></td>
                        <td><?php echo $dato['campo3']; ?></td>
                        <td><?php echo $dato['campo4']; ?></td>
                        <td><?php echo $dato['campo5']; ?></td>
                        <td><?php echo $dato['campo6']; ?></td>
                        <td><?php echo $dato['campo7']; ?></td>
                        <td><?php echo $dato['campo8']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="12" class="text-center">No hay datos eliminados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <nav aria-label="Paginación" class="mb-4">>
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

</body>
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 Museo de Ciencias. Todos los derechos reservados.</p>
</footer>
</html>
