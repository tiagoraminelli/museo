<?php
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idPieza = isset($_GET['id']) ? intval($_GET['id']) : 0;

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
