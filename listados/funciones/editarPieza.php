<?php
session_start();
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id']) && isset($_GET['clasificacion'])) {
        $idPieza = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validar id como entero
        $clasificacion = $_GET['clasificacion'];

        if ($idPieza && $clasificacion) {
            $pieza = new Pieza();
            // Obtener los detalles de la pieza
            $datos = $pieza->getPiezaByIdAndClasificacionAndDonante($idPieza, $clasificacion);
            var_dump($datos);
            if (!$datos) {
                echo "No se encontró la pieza.";
            }
        } else {
            echo "ID o clasificación no válidos.";
        }
    } else {
        echo "Parámetros no recibidos.";
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
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php include('../../includes/navFunciones.php') ?>

<div class="container my-5">
    <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">Editar Pieza</h2>
    <form action="./cargarPieza.php" method="post" id="piezaForm" enctype="multipart/form-data">
        <input type="hidden" name="idPieza" value="<?= isset($idPieza) ? htmlspecialchars($idPieza) : '' ?>">
        <input type="hidden" name="clasificacion" value="<?= isset($clasificacion) ? htmlspecialchars($clasificacion) : '' ?>">

        
        <!-- Número de Inventario y Especie -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="mb-3">
                <label for="num_inventario" class="form-label">Número de Inventario</label>
                <input type="text" class="form-control" id="num_inventario" name="num_inventario" required 
                       value="<?= isset($datos['num_inventario']) ? htmlspecialchars($datos['num_inventario']) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="especie" class="form-label">Especie</label>
                <input type="text" class="form-control" id="especie" name="especie" required 
                       value="<?= isset($datos['especie']) ? htmlspecialchars($datos['especie']) : '' ?>">
            </div>
        </div>

        <!-- Estado de Conservación y Fecha de Ingreso -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="mb-3">
                <label for="estado_conservacion" class="form-label">Estado de Conservación</label>
                <input type="text" class="form-control" id="estado_conservacion" name="estado_conservacion" required 
                       value="<?= isset($datos['estado_conservacion']) ? htmlspecialchars($datos['estado_conservacion']) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required 
                       value="<?= isset($datos['fecha_ingreso']) ? htmlspecialchars($datos['fecha_ingreso']) : '' ?>">
            </div>
        </div>

        <!-- Cantidad de Piezas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="mb-3">
                <label for="cantidad_de_piezas" class="form-label">Cantidad de Piezas</label>
                <input type="text" class="form-control" id="cantidad_de_piezas" name="cantidad_de_piezas" required 
                       value="<?= isset($datos['cantidad_de_piezas']) ? htmlspecialchars($datos['cantidad_de_piezas']) : '' ?>">
            </div>
        </div>

        <!-- Descripción y Observación -->
        <div class="mb-4">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : '' ?></textarea>
        </div>
        <div class="mb-4">
            <label for="observacion" class="form-label">Observación</label>
            <textarea class="form-control" id="observacion" name="observacion" rows="3" required><?= isset($datos['observacion']) ? htmlspecialchars($datos['observacion']) : '' ?></textarea>
        </div>

        <!-- Imagen -->
        <div class="mb-4">
            <label for="imagen" class="form-label">Imagen (opcional)</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>

        <div class="mb-4 bg-white rounded ">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del donante</label>
                <input type="text" id="nombre" class="form-control" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" >
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido del donante</label>
                <input type="text" id="apellido" class="form-control" name="apellido" value="<?= htmlspecialchars($datos['apellido']) ?>" >
            </div>
        </div>

        <!--CAMPOS DE CADA CLASFICACION-->

        <?php if ($clasificacion == 'Arqueología') { ?> 
    <!-- Arqueología -->
    <div id="form-arqueologia" class="form-group mb-3">
        <label for="idArqueologia" class="form-label">IdPaleontologia</label>
        <input type="text" class="form-control" name="idArqueologia" value="<?= isset($datos['idArqueologia']) ? htmlspecialchars($datos['idArqueologia']) : '' ?>" readonly>

        <label for="integridad_historica" class="form-label">Integridad Histórica</label>
        <input type="text" class="form-control" id="integridad_historica" name="integridad_historica" value="<?= isset($datos['integridad_historica']) ? htmlspecialchars($datos['integridad_historica']) : '' ?>" required>

        <label for="estetica" class="form-label">Estética</label>
        <input type="text" class="form-control" id="estetica" name="estetica" value="<?= isset($datos['estetica']) ? htmlspecialchars($datos['estetica']) : '' ?>" required>

        <label for="material" class="form-label">Material</label>
        <input type="text" class="form-control" id="material" name="material" value="<?= isset($datos['material']) ? htmlspecialchars($datos['material']) : '' ?>" required>
    </div>
<?php } elseif ($clasificacion == 'Paleontología') { ?>
    <!-- Paleontología -->
    <div id="form-paleontologia" class="form-group mb-3">
        <label for="IdPaleontologia" class="form-label">IdPaleontologia</label>
        <input type="text" class="form-control" name="idPaleontologia" value="<?= isset($datos['idPaleontologia']) ? htmlspecialchars($datos['idPaleontologia']) : '' ?>" readonly>

        <label for="era" class="form-label">Era</label>
        <input type="text" class="form-control" id="era" name="era" value="<?= isset($datos['era']) ? htmlspecialchars($datos['era']) : '' ?>" required>

        <label for="periodo" class="form-label">Periodo</label>
        <input type="text" class="form-control" id="periodo" name="periodo" value="<?= isset($datos['periodo']) ? htmlspecialchars($datos['periodo']) : '' ?>" required>

        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : '' ?></textarea>
    </div>
<?php } elseif ($clasificacion == 'Osteología') { ?>
    <!-- Osteología -->
    <div id="form-osteologia" class="form-group mb-3">
        <label for="idOsteologia" class="form-label">idOsteologia</label>
        <input type="text" class="form-control" name="idOsteologia" value="<?= isset($datos['idOsteologia']) ? htmlspecialchars($datos['idOsteologia']) : '' ?>" readonly>
        <label for="especie" class="form-label">Especie</label>
        <input type="text" class="form-control" id="especie" name="especie" value="<?= isset($datos['especie']) ? htmlspecialchars($datos['especie']) : '' ?>" required>

        <label for="clasificacion" class="form-label">Clasificación</label>
        <input type="text" class="form-control" id="clasificacion" name="clasificacion" value="<?= isset($datos['clasificacion']) ? htmlspecialchars($datos['clasificacion']) : '' ?>" required>
    </div>
<?php } elseif ($clasificacion == 'Ictiología') { ?>
    <!-- Ictiología -->
    <div id="form-ictiologia" class="form-group mb-3">
        <label for="idIctiologia" class="form-label">idIctiologia</label>
        <input type="text" class="form-control" name="idIctiologia" value="<?= isset($datos['idIctiologia']) ? htmlspecialchars($datos['idIctiologia']) : '' ?>" readonly>

        <label for="clasificacion" class="form-label">Clasificación</label>
        <input type="text" class="form-control" id="clasificacion" name="clasificacion" value="<?= isset($datos['clasificacion']) ? htmlspecialchars($datos['clasificacion']) : '' ?>" required>

        <label for="especies" class="form-label">Especies</label>
        <input type="text" class="form-control" id="especies" name="especies" value="<?= isset($datos['especies']) ? htmlspecialchars($datos['especies']) : '' ?>" required>

        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : '' ?></textarea>
    </div>
<?php } elseif ($clasificacion == 'Geología') { ?>
    <!-- Geología -->
    <div id="form-geologia" class="form-group mb-3">

        <label for="idGeologia" class="form-label">idGeologia</label>
        <input type="text" class="form-control" name="idGeologia" value="<?= isset($datos['idGeologia']) ? htmlspecialchars($datos['idGeologia']) : '' ?>" readonly>
        

        <label for="tipo_rocas" class="form-label">Tipo de Rocas</label>
        <input type="text" class="form-control" id="tipo_rocas" name="tipo_rocas" value="<?= isset($datos['tipo_rocas']) ? htmlspecialchars($datos['tipo_rocas']) : '' ?>" required>

        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : '' ?></textarea>
    </div>
<?php } elseif ($clasificacion == 'Botánica') { ?>
    <!-- Botánica -->
    <div id="form-botanica" class="form-group mb-3">

        <label for="idBotanica" class="form-label">idBotanica</label>
        <input type="text" class="form-control" name="idBotanica" value="<?= isset($datos['idBotanica']) ? htmlspecialchars($datos['idBotanica']) : '' ?>" readonly>

        <label for="reino" class="form-label">Reino</label>
        <input type="text" class="form-control" id="reino" name="reino" value="<?= isset($datos['reino']) ? htmlspecialchars($datos['reino']) : '' ?>" required>

        <label for="familia" class="form-label">Familia</label>
        <input type="text" class="form-control" id="familia" name="familia" value="<?= isset($datos['familia']) ? htmlspecialchars($datos['familia']) : '' ?>" required>

        <label for="especie" class="form-label">Especie</label>
        <input type="text" class="form-control" id="especie" name="especie" value="<?= isset($datos['especie']) ? htmlspecialchars($datos['especie']) : '' ?>" required>

        <label for="orden" class="form-label">Orden</label>
        <input type="text" class="form-control" id="orden" name="orden" value="<?= isset($datos['orden']) ? htmlspecialchars($datos['orden']) : '' ?>" required>

        <label for="division" class="form-label">División</label>
        <input type="text" class="form-control" id="division" name="division" value="<?= isset($datos['division']) ? htmlspecialchars($datos['division']) : '' ?>" required>

        <label for="clase" class="form-label">Clase</label>
        <input type="text" class="form-control" id="clase" name="clase" value="<?= isset($datos['clase']) ? htmlspecialchars($datos['clase']) : '' ?>" required>

        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : '' ?></textarea>
    </div>
<?php } elseif ($clasificacion == 'Zoología') { ?>
    <!-- Zoología -->
    <div id="form-zoologia" class="form-group mb-3">

        <label for="idZoologia" class="form-label">idZoologia</label>
        <input type="text" class="form-control" name="idZoologia" value="<?= isset($datos['idZoologia']) ? htmlspecialchars($datos['idZoologia']) : '' ?>" readonly>

        <label for="reino" class="form-label">Reino</label>
        <input type="text" class="form-control" id="reino" name="reino" value="<?= isset($datos['reino']) ? htmlspecialchars($datos['reino']) : '' ?>" required>

        <label for="familia" class="form-label">Familia</label>
        <input type="text" class="form-control" id="familia" name="familia" value="<?= isset($datos['familia']) ? htmlspecialchars($datos['familia']) : '' ?>" required>

        <label for="especie" class="form-label">Especie</label>
        <input type="text" class="form-control" id="especie" name="especie" value="<?= isset($datos['especie']) ? htmlspecialchars($datos['especie']) : '' ?>" required>

        <label for="orden" class="form-label">Orden</label>
        <input type="text" class="form-control" id="orden" name="orden" value="<?= isset($datos['orden']) ? htmlspecialchars($datos['orden']) : '' ?>" required>

        <label for="phylum" class="form-label">Phylum</label>
        <input type="text" class="form-control" id="phylum" name="phylum" value="<?= isset($datos['phylum']) ? htmlspecialchars($datos['phylum']) : '' ?>" required>

        <label for="clase" class="form-label">Clase</label>
        <input type="text" class="form-control" id="clase" name="clase" value="<?= isset($datos['clase']) ? htmlspecialchars($datos['clase']) : '' ?>" required>

        <label for="genero" class="form-label">Género</label>
        <input type="text" class="form-control" id="genero" name="genero" value="<?= isset($datos['genero']) ? htmlspecialchars($datos['genero']) : '' ?>" required>

        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : '' ?></textarea>
    </div>
<?php } elseif ($clasificacion == 'Octología') { ?>
    <!-- Octología -->
    <div id="form-octologia" class="form-group mb-3">

        <label for="idOctologia" class="form-label">idOctologia</label>
        <input type="text" class="form-control" name="idOctologia" value="<?= isset($datos['idOctologia']) ? htmlspecialchars($datos['idOctologia']) : '' ?>" readonly>

        <label for="clasificacion" class="form-label">Clasificación</label>
        <input type="text" class="form-control" id="clasificacion" name="clasificacion" value="<?= isset($datos['clasificacion']) ? htmlspecialchars($datos['clasificacion']) : '' ?>" required>

        <label for="tipo" class="form-label">Tipo</label>
        <input type="text" class="form-control" id="tipo" name="tipo" value="<?= isset($datos['tipo']) ? htmlspecialchars($datos['tipo']) : '' ?>" required>

        <label for="especie" class="form-label">Especie</label>
        <input type="text" class="form-control" id="especie" name="especie" value="<?= isset($datos['especie']) ? htmlspecialchars($datos['especie']) : '' ?>" required>

        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : '' ?></textarea>
    </div>
<?php } ?>


        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="listarPiezas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
