<?php
session_start();
// Verificar si el usuario está logueado (puedes usar una variable de sesión específica, como $_SESSION['usuario_id'])
require_once("../modelo/bd.php");
require_once("../modelo/geologia.php");

// Crear una instancia de la clase 
$geologia = new Geologia();
$geologias = $geologia->getAllGeologias();
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
<?php include('../includes/navListados.php')?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Geologías</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Tipo de Rocas</th>
                <th>Descripción</th>
                <th>ID de la Pieza</th>
                <th>Acciones</th>
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
                        <td>
                          
                            <!-- Botón para editar -->
                            <a href="editarGeologia.php?id=<?php echo $g['idGeologia']; ?>" class="btn btn-warning btn-sm">Editar</a>

                            <!-- Botón para eliminar -->
                            <a href="eliminarGeologia.php?id=<?php echo $g['idGeologia']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">No hay registros de geología.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="eliminarGeologia.js"></script> <!-- Archivo JS para manejar la eliminación -->
</body>
<?php include('../includes/footer.php') ?>
</html>
