<?php
session_start();
if(!isset($_SESSION['usuario_activo'])){
    header("Location: ../index.php");
    exit;
}
if($_SESSION['nivel'] != 'administrador'){
    header("Location: ./piezaslistado.php");
}   
require_once("../modelo/bd.php");
require_once("../modelo/registros_eliminados.php");

$registrosEliminados = new registros_eliminados();
$breadcrumb = "Registros Eliminados";

// Obtener todos los registros eliminados
$registros = $registrosEliminados->getAllRegistrosEliminados();

// Mensaje para el modal
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
unset($_SESSION['mensaje']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Registros Eliminados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
    <style>
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>

<?php include('../includes/navListados.php')?>
<?php include('../includes/breadcrumb.php')?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Registros Eliminados</h1>
    
    <div class="table-responsive">
        <table id="tablaRegistros" class="table table-hover table-bordered table-striped" style="width:100%">
            <thead class="bg-light">
                <tr>
                    <th>ID Eliminado</th>
                    <th>ID Pieza</th>
                    <th>Número de Inventario</th>
                    <th>Especie</th>
                    <th>Estado de Conservación</th>
                    <th>Fecha de Ingreso</th>
                    <th>Cantidad de Piezas</th>
                    <th>Clasificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($registros)) : ?>
                    <?php foreach ($registros as $registro) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registro['id']); ?></td>
                            <td><?php echo htmlspecialchars($registro['idPieza']); ?></td>
                            <td><?php echo htmlspecialchars($registro['num_inventario']); ?></td>
                            <td><?php echo htmlspecialchars($registro['especie']); ?></td>
                            <td><?php echo htmlspecialchars($registro['estado_conservacion']); ?></td>
                            <td><?php echo htmlspecialchars($registro['fecha_ingreso']); ?></td>
                            <td><?php echo htmlspecialchars($registro['cantidad_de_piezas']); ?></td>
                            <td><?php echo htmlspecialchars($registro['clasificacion']); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="./verPiezaEliminada.php?id=<?php echo $registro['idPieza']; ?>" class="btn btn-info btn-sm">Ver</a>
                                    <a href="funciones/restaurarRegistro.php?id=<?php echo $registro['idPieza']; ?>" 
                                       class="btn btn-success btn-sm"
                                       onclick="return confirm('¿Restaurar este registro?')">Restaurar</a>
                                    <a href="funciones/eliminarRegistro.php?id=<?php echo $registro['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Eliminar permanentemente este registro?')">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">No hay registros eliminados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Mensaje de eliminación -->
    <div class="modal fade" id="mensajeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Resultado de la Operación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($mensaje) : ?>
                        <p><?php echo htmlspecialchars($mensaje); ?></p>
                    <?php else : ?>
                        <p>No se pudo realizar la operación.</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<!-- Agrega estas librerías en el head o antes del script de DataTables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script>
$(document).ready(function() {
    // Inicializar DataTable
    $('#tablaRegistros').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
        dom: '<"row"<"col-md-6"B><"col-md-6"f>>rtip',
        buttons: [
            {
                extend: 'pdf',
                text: '<i class="bi bi-file-pdf "></i> PDF',
                className: 'btn btn-danger',
                orientation: 'portrait', // o 'landscape'
                pageSize: 'A4',
                exportOptions: {
                    columns: ':visible', // exportar solo columnas visibles
                    modifier: {
                        page: 'current' // exportar solo página actual
                    }
                },
                customize: function(doc) {
                    // Personalización del documento PDF
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 11;
                    doc.styles.title.fontSize = 14;
                    
                    // Agregar título
                    doc.content.splice(0, 0, {
                        text: 'Reporte de Registros Eliminados',
                        style: 'title',
                        alignment: 'center',
                        margin: [0, 0, 0, 20]
                    });
                    
                    // Agregar fecha
                    doc.content.splice(1, 0, {
                        text: 'Generado el: ' + new Date().toLocaleDateString(),
                        alignment: 'right',
                        margin: [0, 0, 0, 10]
                    });
                }
            },
            {
                extend: 'excel',
                text: '<i class="bi bi-file-excel"></i> Excel',
                className: 'btn btn-success'
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Imprimir',
                className: 'btn btn-info'
            }
        ],
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']] // Ordenar por ID descendente por defecto
    });

    // Mostrar el modal de mensaje si hay un mensaje
    <?php if ($mensaje) : ?>
        var mensajeModal = new bootstrap.Modal(document.getElementById('mensajeModal'));
        mensajeModal.show();
    <?php endif; ?>
});
</script>

<?php include('../includes/footer.php') ?>
</body>
</html>