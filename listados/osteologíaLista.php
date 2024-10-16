<?php
session_start();
// Verificar si el usuario está logueado (puedes usar una variable de sesión específica, como $_SESSION['usuario_id'])
require_once("../modelo/bd.php");
require_once("../modelo/osteologia.php");

// Crear una instancia de la clase 
$osteologia = new Osteologia();
$osteologias = $osteologia->getAllOsteologias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Osteologías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>
<body>
<?php include('../includes/navListados.php')?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Osteologías</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Especie</th>
                <th>Clasificación</th>
                <th>ID de la Pieza</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($osteologias)) : ?>
                <?php foreach ($osteologias as $o) : ?>
                    <tr id="osteologia-<?php echo $o['idOsteologia']; ?>" class="text-center">
                        <td><?php echo $o['idOsteologia']; ?></td>
                        <td><?php echo $o['especie']; ?></td>
                        <td><?php echo $o['clasificacion']; ?></td>
                        <td><?php echo $o['Pieza_idPieza']; ?></td>
                        <td>
                           
                            <!-- Botón para editar -->
                            <a href="editarOsteologia.php?id=<?php echo $o['idOsteologia']; ?>" class="btn btn-warning btn-sm">Editar</a>

                            <!-- Botón para eliminar -->
                            <a href="EliminarOsteologia.php?id=<?php echo $o['idOsteologia']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">No hay osteologías registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="eliminarOsteologia.js"></script> <!-- Archivo JS para manejar la eliminación -->
</body>
<?php include('../includes/footer.php') ?>
</html>

