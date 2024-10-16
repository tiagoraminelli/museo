<?php
session_start();
// Verificar si el usuario está logueado (puedes usar una variable de sesión específica, como $_SESSION['usuario_id'])
require_once("../modelo/bd.php");
require_once("../modelo/zoologia.php");

// Crear una instancia de la clase 
$zoologia = new Zoologia();
$zoologias = $zoologia->getAllZoologias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Zoología</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>
<body>
<?php include('../includes/navListados.php')?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Zoología</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Reino</th>
                <th>Familia</th>
                <th>Especie</th>
                <th>Orden</th>
                <th>Phylum</th>
                <th>Clase</th>
                <th>Género</th>
                <th>Descripción</th>
                <th>ID de la Pieza</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($zoologias)) : ?>
                <?php foreach ($zoologias as $z) : ?>
                    <tr id="zoologia-<?php echo $z['idZoologia']; ?>" class="text-center">
                        <td><?php echo $z['idZoologia']; ?></td>
                        <td><?php echo $z['reino']; ?></td>
                        <td><?php echo $z['familia']; ?></td>
                        <td><?php echo $z['especie']; ?></td>
                        <td><?php echo $z['orden']; ?></td>
                        <td><?php echo $z['phylum']; ?></td>
                        <td><?php echo $z['clase']; ?></td>
                        <td><?php echo $z['genero']; ?></td>
                        <td><?php echo $z['descripcion']; ?></td>
                        <td><?php echo $z['Pieza_idPieza']; ?></td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <!-- Botón para editar -->
                                <a href="editarZoologia.php?id=<?php echo $z['idZoologia']; ?>" class="btn btn-warning btn-sm me-2">Editar</a>

                                <!-- Botón para eliminar -->
                                <a href="eliminarZoologia.php?id=<?php echo $z['idZoologia']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="11" class="text-center">No hay registros de zoología.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="eliminarZoologia.js"></script> <!-- Archivo JS para manejar la eliminación -->
</body>
<?php include('../includes/footer.php') ?>
</html>
