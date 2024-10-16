<?php
session_start();
// Verificar si el usuario está logueado (puedes usar una variable de sesión específica, como $_SESSION['usuario_id'])
require_once("../modelo/bd.php");
require_once("../modelo/arqueologia.php");

// Crear una instancia de la clase 
$arqueologia = new Arqueologia();
$arqueologias = $arqueologia->getAllArqueologias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Arqueología</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
</head>
<body>
<?php include('../includes/navListados.php')?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Arqueología</h1>
    
    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Integridad Histórica</th>
                <th>Estética</th>
                <th>Material</th>
                <th>ID de la Pieza</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($arqueologias)) : ?>
                <?php foreach ($arqueologias as $a) : ?>
                    <tr id="arqueologia-<?php echo $a['idArqueologia']; ?>" class="text-center">
                        <td><?php echo $a['idArqueologia']; ?></td>
                        <td><?php echo $a['integridad_historica']; ?></td>
                        <td><?php echo $a['estetica']; ?></td>
                        <td><?php echo $a['material']; ?></td>
                        <td><?php echo $a['Pieza_idPieza']; ?></td>
                        <td>
                          
                            <!-- Botón para editar -->
                            <a href="editarArqueologia.php?id=<?php echo $a['idArqueologia']; ?>" class="btn btn-warning btn-sm">Editar</a>

                            <!-- Botón para eliminar -->
                            <a href="eliminarArqueologia.php?id=<?php echo $a['idArqueologia']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">No hay registros de arqueología.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="eliminarArqueologia.js"></script> <!-- Archivo JS para manejar la eliminación -->
</body>
<?php include('../includes/footer.php') ?>
</html>
