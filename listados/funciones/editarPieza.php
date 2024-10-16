<?php
session_start();
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id']) && isset($_GET['clasificacion'])) {
        $idPieza = $_GET['id'];
        $clasificacion = $_GET['clasificacion'];
        $pieza = new Pieza();
        // Obtener los detalles de la pieza
        $datos = $pieza->getPiezaByIdAndClasificacion($idPieza, $clasificacion); // Asume que tienes una función en el modelo que devuelve los datos de la pieza

        echo "<br>";
        var_dump($datos);
        if ($datos) {
            // Aquí puedes hacer un eco de la información para depuración, si es necesario
            echo "Editando pieza con ID: $idPieza y Clasificación: $clasificacion";
        } else {
            echo "No se encontró la pieza";
        }
    } else {
        echo "ID o clasificación no válidos.";
    }

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pieza</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center">Editar Pieza</h2>
        <form action="./cargarPieza.php" method="post" id="piezaForm" enctype="multipart/form-data">
            <input type="hidden" name="idPieza" value="<?= isset($idPieza) ? htmlspecialchars($idPieza) : '' ?>">
            <input type="hidden" name="clasificacion" value="<?= isset($clasificacion) ? htmlspecialchars($clasificacion) : '' ?>">
            <div class="row">
            <div class="col-md-6 mb-3">
                <label for="num_inventario" class="form-label">Número de Inventario</label>
                <input type="text" class="form-control" id="num_inventario" name="num_inventario" required 
                       value="<?= isset($datos['num_inventario']) ? htmlspecialchars($datos['num_inventario']) : '' ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="especie" class="form-label">Especie</label>
                <input type="text" class="form-control" id="especie" name="especie" required 
                       value="<?= isset($datos['especie']) ? htmlspecialchars($datos['especie']) : '' ?>">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="estado_conservacion" class="form-label">Estado de Conservación</label>
                <input type="text" class="form-control" id="estado_conservacion" name="estado_conservacion" required 
                       value="<?= isset($datos['estado_conservacion']) ? htmlspecialchars($datos['estado_conservacion']) : '' ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required 
                       value="<?= isset($datos['fecha_ingreso']) ? htmlspecialchars($datos['fecha_ingreso']) : '' ?>">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cantidad_de_piezas" class="form-label">Cantidad de Piezas</label>
                <input type="text" class="form-control" id="cantidad_de_piezas" name="cantidad_de_piezas" required 
                       value="<?= isset($datos['cantidad_de_piezas']) ? htmlspecialchars($datos['cantidad_de_piezas']) : '' ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="clasificacion" class="form-label">Clasificación</label>
                <select class="form-select" id="clasificacion" name="clasificacion" required>
                    <option value="Paleontología" <?= (isset($datos['clasificacion']) && $datos['clasificacion'] == 'Paleontología') ? 'selected' : '' ?>>Paleontología</option>
                    <option value="Osteología" <?= (isset($datos['clasificacion']) && $datos['clasificacion'] == 'Osteología') ? 'selected' : '' ?>>Osteología</option>
                    <option value="Ictiología" <?= (isset($datos['clasificacion']) && $datos['clasificacion'] == 'Ictiología') ? 'selected' : '' ?>>Ictiología</option>
                    <option value="Geología" <?= (isset($datos['clasificacion']) && $datos['clasificacion'] == 'Geología') ? 'selected' : '' ?>>Geología</option>
                    <option value="Botánica" <?= (isset($datos['clasificacion']) && $datos['clasificacion'] == 'Botánica') ? 'selected' : '' ?>>Botánica</option>
                    <option value="Zoología" <?= (isset($datos['clasificacion']) && $datos['clasificacion'] == 'Zoología') ? 'selected' : '' ?>>Zoología</option>
                    <option value="Arqueología" <?= (isset($datos['clasificacion']) && $datos['clasificacion'] == 'Arqueología') ? 'selected' : '' ?>>Arqueología</option>
                    <option value="Octología" <?= (isset($datos['clasificacion']) && $datos['clasificacion'] == 'Octología') ? 'selected' : '' ?>>Octología</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tipo_rocas" class="form-label">Tipo de Rocas</label>
                <input type="text" class="form-control" id="tipo_rocas" name="tipo_rocas" required 
                       value="<?= isset($datos['tipo_rocas']) ? htmlspecialchars($datos['tipo_rocas']) : '' ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="observacion" class="form-label">Observación</label>
                <textarea class="form-control" id="observacion" name="observacion" rows="3" required><?= isset($datos['observacion']) ? htmlspecialchars($datos['observacion']) : '' ?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : '' ?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="imagen" class="form-label">Imagen (opcional)</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
            </div>
        </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>
</html>
