<?php
session_start();
// Verificar si el usuario está logueado (puedes usar una variable de sesión específica, como $_SESSION['usuario_id'])
require_once("../modelo/bd.php");
require_once("../modelo/paleontologia.php");

// Crear una instancia de la clase 
$paleontologia = new Paleontologia();
$paleontologias = $paleontologia->getAllPaleontologias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Paleontologías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>
<body>
<?php include('../includes/navListados.php')?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Paleontologías</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Era</th>
                <th>Periodo</th>
                <th>Descripción</th>
                <th>ID de la Pieza</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($paleontologias)) : ?>
                <?php foreach ($paleontologias as $p) : ?>
                    <tr id="paleontologia-<?php echo $p['idPaleontologia']; ?>" class="text-center">
                        <td><?php echo $p['idPaleontologia']; ?></td>
                        <td><?php echo $p['era']; ?></td>
                        <td><?php echo $p['periodo']; ?></td>
                        <td><?php echo $p['descripcion']; ?></td>
                        <td><?php echo $p['Pieza_idPieza']; ?></td>
                        <td>
                           
                            <!-- Botón para editar -->
                            <a href="editarPaleontologia.php?id=<?php echo $p['idPaleontologia']; ?>" class="btn btn-warning btn-sm">Editar</a>

                            <a href="EliminarPaleontologia.php?id=<?php echo $p['idPaleontologia']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">No hay paleontologías registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="eliminarPaleontologia.js"></script> <!-- Archivo JS para manejar la eliminación -->
</body>
<?php include('../includes/footer.php') ?>
</html>
