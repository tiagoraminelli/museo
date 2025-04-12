<?php
session_start();
if (!isset($_SESSION['usuario_activo'])) {
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../../index.php");
    exit;
}
$breadcrumb = "Formulario para agregar nuevas pieza"
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Carga de Piezas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../public/css/nuevaPieza.css">
</head>
<body>
<?php include("../../includes/navFunciones.php");?>
<div class="container my-5">
    <!-- Breadcrumb -->
<nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$breadcrumb?></li>
            </ol>
</nav>
</div>


<div class="container mt-5">
    <h1 class="mb-4 text-center">Cargar Nueva Pieza</h1>
    <form action="./cargarPieza.php" method="post" id="piezaForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="num_inventario" class="form-label">Número de Inventario</label>
                <input type="text" class="form-control" id="num_inventario" name="num_inventario" required 
                value="NDH-">
            </div>
            <div class="col-md-6 mb-3">
                <label for="especie" class="form-label">Especie</label>
                <input type="text" class="form-control" id="especieP" name="especieP" required>
            </div>
        </div>
        <div class="row">

        <div class="mb-3 col-md-6">
    <label for="estado_conservacion" class="form-label">Estado de Conservación</label>
    <select class="form-select form-control" id="estado_conservacion" name="estado_conservacion" required>
        <option value="">Seleccione un estado...</option>
        <option value="Excelente" <?= (isset($datos['estado_conservacion']) && $datos['estado_conservacion'] == 'Excelente') ? 'selected' : '' ?>>Excelente</option>
        <option value="Bueno" <?= (isset($datos['estado_conservacion']) && $datos['estado_conservacion'] == 'Bueno') ? 'selected' : '' ?>>Bueno</option>
        <option value="Regular" <?= (isset($datos['estado_conservacion']) && $datos['estado_conservacion'] == 'Regular') ? 'selected' : '' ?>>Regular</option>
        <option value="Malo" <?= (isset($datos['estado_conservacion']) && $datos['estado_conservacion'] == 'Malo') ? 'selected' : '' ?>>Malo</option>
        <option value="Pérdida total" <?= (isset($datos['estado_conservacion']) && $datos['estado_conservacion'] == 'Pérdida total') ? 'selected' : '' ?>>Pérdida total</option>
        <option value="En restauración" <?= (isset($datos['estado_conservacion']) && $datos['estado_conservacion'] == 'En restauración') ? 'selected' : '' ?>>En restauración</option>
    </select>
</div>

    <div class="mb-3 col-md-6">
    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
    <input 
        type="date" 
        class="form-control" 
        id="fecha_ingreso" 
        name="fecha_ingreso" 
        required
        max="<?= date('Y-m-d') ?>"
        value="<?= isset($datos['fecha_ingreso']) ? htmlspecialchars($datos['fecha_ingreso']) : '' ?>"
        onchange="validarFecha(this)"
    >
    <div id="error-fecha" class="text-danger small d-none">La fecha no puede ser futura</div>
</div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cantidad_de_piezas" class="form-label">Cantidad de Piezas</label>
                <input type="number" class="form-control" id="cantidad_de_piezas" name="cantidad_de_piezas" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="clasificacion" class="form-label">Clasificación</label>
                <select class="form-select" id="clasificacion" name="clasificacion" required>
                    <option value="" selected disabled>Seleccione una clasificación</option>
                    <option value="Paleontología">Paleontología</option>
                    <option value="Osteología">Osteología</option>
                    <option value="Ictiología">Ictiología</option>
                    <option value="Geología">Geología</option>
                    <option value="Botánica">Botánica</option>
                    <option value="Zoología">Zoología</option>
                    <option value="Arqueología">Arqueología</option>
                    <option value="Octología">Octología</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="observacion" class="form-label">Observación</label>
            <textarea class="form-control" id="observacion" name="observacion"></textarea>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        </div>
         <!-- Campos adicionales donante -->
        <div class="mb-3" id="donanteForm">
            <h5>Datos del Donante</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="donante_nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="donante_nombre" name="donante_nombre">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="donante_apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="donante_apellido" name="donante_apellido">
                </div>
            </div>
            
        </div>
        
       <!-- Campos adicionales para Paleontología -->
<div class="hidden" id="paleontologiaFields">
    <h5>Información de Paleontología</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="era" class="form-label">Era</label>
            <select class="form-control" id="era" name="era">
                <option value="" selected disabled>Selecciona una era</option>
                <option value="Precámbrico">Precámbrico</option>
                <option value="Paleozoico">Paleozoico</option>
                <option value="Mesozoico">Mesozoico</option>
                <option value="Cenozoico">Cenozoico</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="periodo" class="form-label">Periodo</label>
            <select class="form-control" id="periodo" name="periodo">
                <option value="" selected disabled>Selecciona un periodo</option>
                <option value="Cámbrico">Cámbrico</option>
                <option value="Ordovícico">Ordovícico</option>
                <option value="Silúrico">Silúrico</option>
                <option value="Devónico">Devónico</option>
                <option value="Carbonífero">Carbonífero</option>
                <option value="Pérmico">Pérmico</option>
                <option value="Triásico">Triásico</option>
                <option value="Jurásico">Jurásico</option>
                <option value="Cretácico">Cretácico</option>
                <option value="Paleógeno">Paleógeno</option>
                <option value="Neógeno">Neógeno</option>
                <option value="Cuaternario">Cuaternario</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea class="form-control" id="descripcionPal" name="descripcionPal" rows="3" ></textarea>
    </div>
</div>


        <!-- Campos adicionales para Osteología -->
        <div class="hidden" id="osteologiaFields">
            <h5>Información de Osteología</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="especieOsteologia" class="form-label">Especie</label>
                    <input type="text" class="form-control" id="especieOst" name="especieOst">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="clasificacionOsteologia" class="form-label">Clasificación</label>
                    <input type="text" class="form-control" id="clasificacionOst" name="clasificacionOst">
                </div>
            </div>
        </div>

<!-- Campos adicionales para Ictiología -->
<div class="hidden" id="ictiologiaFields">
    <h5>Información de Ictiología</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="clasificacionIctiologia" class="form-label">Clasificación</label>
            <input type="text" class="form-control" id="clasificacionIct" name="clasificacionIct">
        </div>
        <div class="col-md-6 mb-3">
            <label for="especies" class="form-label">Especies</label>
            <input type="text" class="form-control" id="especiesIct" name="especiesIct">
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcionIctiologia" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcionIct" name="descripcionIct"></textarea>
    </div>
</div>


    <!-- Campos adicionales para Geología -->
<div class="hidden" id="geologiaFields">
    <h5>Información de Geología</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tipo_rocas" class="form-label">Tipo de Rocas</label>
            <select class="form-control" id="tipo_rocas" name="tipo_rocas">
                <option value="">Seleccione el tipo de rocas</option>
                <option value="ígneas">Ígneas</option>
                <option value="sedimentarias">Sedimentarias</option>
                <option value="metamórficas">Metamórficas</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="descripcionGeologia" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
        </div>
    </div>
</div>


        <!-- Campos adicionales para Botánica -->
        <div class="hidden" id="botanicaFields">
            <h5>Información de Botánica</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="reino" class="form-label">Reino</label>
                    <input type="text" class="form-control" id="reino" name="reinoBot">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="familia" class="form-label">Familia</label>
                    <input type="text" class="form-control" id="familia" name="familiaBot">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="especieBotanica" class="form-label">Especie</label>
                    <input type="text" class="form-control" id="especie" name="especieBot">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="orden" class="form-label">Orden</label>
                    <input type="text" class="form-control" id="orden" name="ordenBot">
                </div>
            </div>
            <div class="mb-3">
                <label for="division" class="form-label">División</label>
                <input type="text" class="form-control" id="division" name="divisionBot">
            </div>
            <div class="mb-3">
                <label for="clase" class="form-label">Clase</label>
                <input type="text" class="form-control" id="clase" name="claseBot">
            </div>
            <div class="mb-3">
                <label for="descripcionBotanica" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcionBot" name="descripcionBot"></textarea>
            </div>
        </div>

        <!-- Campos adicionales para Zoología -->
        <div class="hidden" id="zoologiaFields">
            <h5>Información de Zoología</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="reinoZoologia" class="form-label">Reino</label>
                    <input type="text" class="form-control" id="reino" name="reino">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="familiaZoologia" class="form-label">Familia</label>
                    <input type="text" class="form-control" id="familia" name="familia">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="especie" class="form-label">Especie</label>
                    <input type="text" class="form-control" id="especie" name="especie">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="orden" class="form-label">Orden</label>
                    <input type="text" class="form-control" id="orden" name="orden">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phylum" class="form-label">Phylum</label>
                    <input type="text" class="form-control" id="phylum" name="phylum">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="clase" class="form-label">Clase</label>
                    <input type="text" class="form-control" id="clase" name="clase">
                </div>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Género</label>
                <input type="text" class="form-control" id="genero" name="genero">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>
        </div>

        <!-- Campos adicionales para Arqueología -->
        <div class="hidden" id="arqueologiaFields">
            <h5>Información de Arqueología</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="integridad_historica" class="form-label">Integridad Histórica</label>
                    <input type="text" class="form-control" id="integridad_historica" name="integridad_historica">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="estetica" class="form-label">Estética</label>
                    <input type="text" class="form-control" id="estetica" name="estetica">
                </div>
            </div>
            <div class="mb-3">
                <label for="material" class="form-label">Material</label>
                <input type="text" class="form-control" id="material" name="material">
            </div>
        </div>

        <!-- Campos adicionales para Octología -->
        <div class="hidden" id="octologiaFields">
            <h5>Información de Octología</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="clasificacionOctologia" class="form-label">Clasificación</label>
                    <input type="text" class="form-control" id="clasificacionOct" name="clasificacionOct">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <input type="text" class="form-control" id="tipoOct" name="tipoOct">
                </div>
            </div>
            <div class="mb-3">
                <label for="especieOctologia" class="form-label">Especie</label>
                <input type="text" class="form-control" id="especieOct" name="especieOct">
            </div>
            <div class="mb-3">
                <label for="descripcionOctologia" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcionOct" name="descripcionOct"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='../piezasListado.php'">Cancelar</button>


    </form>
</div>
<script src="../../public/js/nuevaPieza.js"></script>
</body>
<?php include("../../includes/footer.php"); ?>
</html>
