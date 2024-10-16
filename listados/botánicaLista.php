<?php
session_start();
// Verificar si el usuario está logueado
require_once("../modelo/bd.php");
require_once("../modelo/botanica.php");

// Crear una instancia de la clase 
$botanica = new Botanica();
$botanicas = $botanica->getAllBotanicas();
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
    
    <table class="table table-hover table-bordered">
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
                <th>Acciones</th>
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
                        <td>
                            <div class="d-flex justify-content-center">
                                <!-- Botón para editar -->
                                <a href="editarBotanica.php?id=<?php echo $b['idBotanica']; ?>" class="btn btn-warning btn-sm me-2">Editar</a>

                                <!-- Botón para eliminar -->
                                <a href="eliminarBotanica.php?id=<?php echo $b['idBotanica']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="10" class="text-center">No hay registros de botánicas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="eliminarBotanica.js"></script> <!-- Archivo JS para manejar la eliminación -->
</body>
<?php include('../includes/footer.php') ?>
</html>
