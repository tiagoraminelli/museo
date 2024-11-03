<?php
// Incluir el archivo que contiene la clase Pieza y la conexión a la base de datos
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";
require_once "../../modelo/arqueologia.php";
require_once "../../modelo/paleontologia.php";
require_once "../../modelo/osteologia.php";
require_once "../../modelo/geologia.php";
require_once "../../modelo/ictiologia.php";
require_once "../../modelo/botanica.php";
require_once "../../modelo/octologia.php";
require_once "../../modelo/zoologia.php";

// Comprobar si se ha recibido el parámetro 'search' y 'clasificacion'
if (isset($_GET['search']) && isset($_GET['clasificacion'])) {
    $search = $_GET['search'];
    $clasificacion = $_GET['clasificacion'];
    $resultados = [];

    switch ($clasificacion) {
        case "Paleontología":
            $paleontologia = new Paleontologia();
            $resultados = $paleontologia->buscarPaleontologias($search);
            break;
        case "Arqueología":
            $arqueologia = new Arqueologia();
            $resultados = $arqueologia->buscarArqueologias($search);
            break;
        case "Octología":
            $octologia = new Octologia();
            $resultados = $octologia->buscarOctologias($search);
            break;
        // Agregar otros casos según las clasificaciones que tengas
        case "Osteología":
            $osteologia = new Osteologia();
            $resultados = $osteologia->buscarOsteologias($search);
            break;
        case "Geología":
            $geologia = new Geologia();
            $resultados = $geologia->buscarGeologias($search);
            break;
        case "Ictiología":
            $ictiologia = new Ictiologia();
            $resultados = $ictiologia->buscarIctiologias($search);
            break;
        case "Botánica":
            $botanica = new Botanica();
            $resultados = $botanica->buscarBotanicas($search);
            break;
        case "Zoología":
            $zoologia = new Zoologia();
            $resultados = $zoologia->buscarZoologias($search);
            break;
        default:
            echo json_encode("Clasificación no reconocida.");
            exit;
    }

    // Enviar los resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($resultados);

} else {
    // Si no se recibe el parámetro de búsqueda, devolver un array vacío
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>
