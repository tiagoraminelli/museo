<?php
session_start();
// Verificar si el usuario está logueado (puedes usar una variable de sesión específica, como $_SESSION['usuario_id'])
require_once("../modelo/bd.php");
require_once("../modelo/ictiologia.php");

// Crear una instancia de la clase 
$ictiologia = new Ictiologia();
$ictiologias = $ictiologia->getAllIctiologias();
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
<?php include('../includes/navListados.php')?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Ictiología</h1>
    
    <table class="table table-hover table-bordered">
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
                           
                            <!-- Botón para editar -->
                            <a href="editarIctiologia.php?id=<?php echo $i['idIctiologia']; ?>" class="btn btn-warning btn-sm">Editar</a>

                            <a href="EliminarIctiologia.php?id=<?php echo $i['idIctiologia']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="eliminarIctiologia.js"></script> <!-- Archivo JS para manejar la eliminación -->
</body>
<?php include('../includes/footer.php') ?>
</html>
