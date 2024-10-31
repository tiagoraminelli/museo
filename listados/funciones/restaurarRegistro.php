<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/registros_eliminados.php");
require_once("../../modelo/datos_eliminados.php");

// Verificar si el ID es válido
$IdPiezaRestaurada = isset($_GET['id']) ? intval($_GET['id']) : 0;
echo "<pre>";
var_dump($IdPiezaRestaurada);
echo "</pre>";
if ($IdPiezaRestaurada > 0) {
    // Crear una instancia de la clase registros_eliminados
    $registro = new registros_eliminados();
    $nuevoIdPieza = $registro->restorePieza($IdPiezaRestaurada); // Captura el ID restaurado
    // Verificar el resultado de la restauración
    if ($nuevoIdPieza) {  // Verifica que `$nuevoIdPieza` no sea falso
        $_SESSION['mensaje'] = "Restaurado con éxito correctamente";
        echo "Restaurado con éxito correctamente con el nuevo id:".$nuevoIdPieza."<br>";
        $restaurarTabla = new DatosEliminados();
        $datosTraidos = $restaurarTabla->getDatosEliminadosByPiezaId($IdPiezaRestaurada);
        var_dump($datosTraidos);
        
        // Llamar a restorePiezaByTable con el nuevo ID restaurado
        $restaurarTabla->restorePiezaByTable($nuevoIdPieza,40);
        
        header("Location: ../eliminados.php?restaurado=1");
        exit();
    } else {
        $_SESSION['mensaje'] = "Error al restaurar el elemento.";
        //header("Location: ../eliminados.php?restaurado=0");
        exit();
    }
} else {
    $_SESSION['mensaje'] = "ID inválido.";
    //header("Location: ../eliminados.php?restaurado=0");
    exit();
}
?>