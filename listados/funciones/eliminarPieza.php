<?php
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idPieza = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if (isset($_GET['clasificacion'])) {
        $clasificacion = $_GET['clasificacion'];
    } else {
        echo "Clasificación no proporcionada.";
    }
    $pieza = new Pieza();
    $resultado = $pieza->getPiezaByIdAndClasificacionAndDonante($idPieza,$clasificacion);
// Paleontología
if (isset($resultado['paleontologia']) && !empty($resultado['paleontologia'])) {
    $resultados['paleontologia'] = $resultado['paleontologia'];
    $newPaleontologia = new Paleontologia(); // Instancia de la tabla
    //$newPaleontologia->deletePaleontologiaByIDPieza($resultado['paleontologia']['Pieza_idPieza']);
}

// Osteología
if (isset($resultado['osteologia']) && !empty($resultado['osteologia'])) {
    $resultados['osteologia'] = $resultado['osteologia'];
    $newOsteologia = new Osteologia(); // Instancia de la tabla
    //$newOsteologia->deleteOsteologiaByIDPieza($resultado['osteologia']['Pieza_idPieza']);
}

// Ictiología
if (isset($resultado['ictiologia']) && !empty($resultado['ictiologia'])) {
    $resultados['ictiologia'] = $resultado['ictiologia'];
    $newIctiologia = new Ictiologia(); // Instancia de la tabla
    //$newIctiologia->deleteIctiologiaByIDPieza($resultado['ictiologia']['Pieza_idPieza']);
}

// Geología
if (isset($resultado['geologia']) && !empty($resultado['geologia'])) {
    $resultados['geologia'] = $resultado['geologia'];
    $newGeologia = new Geologia(); // Instancia de la tabla
    //$newGeologia->deleteGeologiaByIDPieza($resultado['geologia']['Pieza_idPieza']);
}

// Botánica
if (isset($resultado['botanica']) && !empty($resultado['botanica'])) {
    $resultados['botanica'] = $resultado['botanica'];
    $newBotanica = new Botanica(); // Instancia de la tabla
    //$newBotanica->deleteBotanicaByIDPieza($resultado['botanica']['Pieza_idPieza']);
}

// Zoología
if (isset($resultado['zoologia']) && !empty($resultado['zoologia'])) {
    $resultados['zoologia'] = $resultado['zoologia'];
    $newZoologia = new Zoologia(); // Instancia de la tabla
    //$newZoologia->deleteZoologiaByIDPieza($resultado['zoologia']['Pieza_idPieza']);
}

// Arqueología
if (isset($resultado['arqueologia']) && !empty($resultado['arqueologia'])) {
    $resultados['arqueologia'] = $resultado['arqueologia'];
    $newArqueologia = new Arqueologia(); // Instancia de la tabla
    //$newArqueologia->deleteArqueologiaByIDPieza($resultado['arqueologia']['Pieza_idPieza']);
}

// Octología
if (isset($resultado['octologia']) && !empty($resultado['octologia'])) {
    $resultados['octologia'] = $resultado['octologia'];
    $newOctologia = new Octologia(); // Instancia de la tabla
    //$newOctologia->deleteOctologiaByIDPieza($resultado['octologia']['Pieza_idPieza']);
}

    if ($idPieza > 0) {
        die;
        $pieza = new Pieza();
        $resultado = $pieza->eliminarPorIdPieza($idPieza);

        // Redirigir a piezasListado.php según el resultado de la eliminación
        if ($resultado = true) {
            
            header("Location: ../piezasListado.php?eliminado=1"); // Puedes enviar un parámetro para indicar éxito
        } else {
            header("Location: ../piezasListado.php?eliminado=0"); // O un parámetro para indicar fracaso
        }
        exit; // Asegúrate de detener la ejecución del script después de la redirección
    } else {
        header("Location: piezasListado.php?eliminado=2"); // Redirigir en caso de que no se pase un ID válido
        exit;
    }
}
?>
