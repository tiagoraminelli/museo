<?php
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";
require_once "../../modelo/paleontologia.php"; // Clase Paleontología
require_once "../../modelo/osteologia.php"; // Clase Osteología
require_once "../../modelo/ictiologia.php"; // Clase Ictiología
require_once "../../modelo/geologia.php"; // Clase Geología
require_once "../../modelo/botanica.php"; // Clase Botánica
require_once "../../modelo/zoologia.php"; // Clase Zoología
require_once "../../modelo/arqueologia.php"; // Clase Arqueología
require_once "../../modelo/octologia.php"; // Clase Octología

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idPieza = isset($_GET['id']) ? intval($_GET['id']) : 0;
    //var_dump($_GET);
    if (isset($_GET['clasificacion'])) {
        $clasificacion = $_GET['clasificacion'];
    } else {
        echo "Clasificación no proporcionada.";
    }
    $pieza = new Pieza();
    $resultado = $pieza->getPiezaByIdAndClasificacionAndDonante($idPieza,$clasificacion);
    //var_dump($resultado);
// Paleontología
if (isset($resultado['idPaleontologia']) && !empty($resultado['idPaleontologia'])) {
    $resultados['idPaleontologia'] = $resultado['idPaleontologia'];
    $newPaleontologia = new Paleontologia(); // Instancia de la tabla
    $newPaleontologia->deletePaleontologiaById($resultado['idPaleontologia']);
}

// Osteología
if (isset($resultado['idOsteologia']) && !empty($resultado['idOsteologia'])) {
    $resultados['idOsteologia'] = $resultado['idOsteologia'];
    $newOsteologia = new Osteologia(); // Instancia de la tabla
    $newOsteologia->deleteOsteologiaById($resultado['idOsteologia']);
}

// Ictiología
if (isset($resultado['idIctiologia']) && !empty($resultado['idIctiologia'])) {
    $resultados['idIctiologia'] = $resultado['idIctiologia'];
    $newIctiologia = new Ictiologia(); // Instancia de la tabla
    $newIctiologia->deleteIctiologiaById($resultado['idIctiologia']);
}

// Geología
if (isset($resultado['idGeologia']) && !empty($resultado['idGeologia'])) {
    $resultados['idGeologia'] = $resultado['idGeologia'];
    $newGeologia = new Geologia(); // Instancia de la tabla
    $newGeologia->deleteGeologiaById($resultado['idGeologia']);
}

// Botánica
if (isset($resultado['idBotanica']) && !empty($resultado['idBotanica'])) {
    $resultados['idBotanica'] = $resultado['idBotanica'];
    $newBotanica = new Botanica(); // Instancia de la tabla
    $newBotanica->deleteBotanicaById($resultado['idBotanica']);
}

// Zoología
if (isset($resultado['idZoologia']) && !empty($resultado['idZoologia'])) {
    $resultados['idZoologia'] = $resultado['idZoologia'];
    $newZoologia = new Zoologia(); // Instancia de la tabla
    $newZoologia->deleteZoologia($resultado['idZoologia']);
}

// Arqueología
if (isset($resultado['idArqueologia']) && !empty($resultado['idArqueologia'])) {
    $resultados['idArqueologia'] = $resultado['idArqueologia'];
    $newArqueologia = new Arqueologia(); // Instancia de la tabla
    $newArqueologia->deleteArqueologiaById($resultado['idArqueologia']);
}

// Octología
if (isset($resultado['idOctologia']) && !empty($resultado['idOctologia'])) {
    $resultados['idOctologia'] = $resultado['idOctologia'];
    $newOctologia = new Octologia(); // Instancia de la tabla
    $newOctologia->deleteOctologiaById($resultado['idOctologia']);
}

    if ($idPieza > 0) {
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
