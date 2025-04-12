<?php
session_start();
require_once "../modelo/pieza.php";

$breadcrumb = "Pieza";
$pieza = new Pieza();
$piezas = $pieza->getAllPiezas(); // Cambiamos para obtener todas las piezas (DataTables manejará la paginación)
$eliminado = isset($_GET['eliminado']) ? intval($_GET['eliminado']) : -1;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Piezas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../public/css/index.css">
</head>

<body>
<?php include('../includes/navListados.php')?>
<?php include('../includes/breadcrumb.php')?>

<?php if (isset($_SESSION['usuario_activo'])): ?>
<div class="container mt-8 text-center">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h4 class="text-2xl font-bold text-gray-800 mb-4">Crear una Nueva Pieza</h4>
        <p class="text-gray-600 mb-4">
            Si deseas añadir una nueva pieza a nuestro registro, dirígete al formulario correspondiente.
        </p>
        <a href="./funciones/formularioAgregar.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition">Cargar Nueva Pieza</a>
    </div>
</div>
<?php endif; ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center text-2xl font-bold">Listado de Piezas</h1>
    
    <table id="tablaPiezas" class="table table-hover table-bordered w-100">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>N° Inventario</th>
                <th>Especie</th>
                <th>Estado</th>
                <th>Fecha Ingreso</th>
                <th>Cantidad</th>
                <th>Clasificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($piezas)) : ?>
                <?php foreach ($piezas as $p) : ?>
                    <tr id="pieza-<?php echo $p['idPieza']; ?>">
                        <td><?php echo $p['idPieza']; ?></td>
                        <td><?php echo $p['num_inventario']; ?></td>
                        <td><?php echo $p['especie']; ?></td>
                        <td><?php echo $p['estado_conservacion']; ?></td>
                        <td><?php echo $p['fecha_ingreso']; ?></td>
                        <td><?php echo $p['cantidad_de_piezas']; ?></td>
                        <td><?php echo $p['clasificacion']; ?></td>
                        <td>
                            <a href="funciones/verPieza.php?id=<?php echo $p['idPieza']; ?>" class="btn btn-success btn-sm">Ver</a>
                            <?php if (isset($_SESSION['usuario_activo'])): ?>
                            <a href="funciones/editarPieza.php?id=<?php echo $p['idPieza']; ?>&clasificacion=<?php echo $p['clasificacion']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="funciones/eliminarPieza.php?id=<?php echo $p['idPieza']; ?>&clasificacion=<?php echo $p['clasificacion']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center">No hay piezas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Scripts necesarios -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- Botones de exportación -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#tablaPiezas').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay datos disponibles",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros coincidentes",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activar para ordenar ascendente",
                "sortDescending": ": activar para ordenar descendente"
            }
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                text: 'Exportar a PDF',
                title: 'Listado de Piezas del Museo',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6], // Excluye la columna de acciones (índice 7)
                    modifier: {
                        page: 'current'
                    }
                },
                customize: function (doc) {
                    doc.content[1].table.widths = ['10%', '15%', '15%', '15%', '15%', '15%', '15%'];
                    doc.styles.tableHeader = {
                        fillColor: '#343a40',
                        color: '#ffffff',
                        bold: true
                    };
                }
            }
        ],
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']]
    });
    
    // Mostrar modal si hay mensaje de eliminación
    <?php if ($eliminado != -1): ?>
        var eliminarModal = new bootstrap.Modal(document.getElementById('eliminarModal'));
        eliminarModal.show();
    <?php endif; ?>
});

function cerrarModal() {
    $('#modalNoDatos').modal('hide');
}
</script>

<!-- Modal para mostrar resultado de la eliminación -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Resultado de Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($eliminado == 1): ?>
                    La pieza ha sido eliminada exitosamente.
                <?php elseif ($eliminado == 0): ?>
                    Hubo un error al eliminar la pieza.
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de mensaje -->
<div id="modalNoDatos" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-lg shadow-lg border-0">
            <div class="modal-body p-5 text-center">
                <img src="../assets/img/error.webp" alt="No data" class="mb-4 mx-auto rounded-full">
                <h5 class="text-lg font-semibold text-gray-800">No se han encontrado datos asociados</h5>
                <p class="text-gray-600">La pieza solicitada no tiene datos asociados en la clasificación seleccionada.</p>
                <button type="button" class="btn btn-primary mt-4" onclick="cerrarModal()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php') ?>
</body>
</html>