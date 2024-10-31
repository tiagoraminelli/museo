<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/registros_eliminados.php");
require_once("../../modelo/datos_eliminados.php");
$IdPiezaRestaurada = isset($_GET['id']) ? intval($_GET['id']) : 0;
var_dump($IdPiezaRestaurada);
// Crear una instancia de la clase UsuarioHasPieza
$registro = new registros_eliminados();

if ($IdPiezaRestaurada) {
    $resultado = $registro->restorePieza($IdPiezaRestaurada); // Asegúrate de tener esta función
    $restaurarTabla = new DatosEliminados();
    $datosTraidos = $restaurarTabla->getDatosEliminadosByPiezaId($IdPiezaRestaurada);
    var_dump($datosTraidos);
    $restaurarTabla->restorePiezaByTable($IdPiezaRestaurada);
    // Verificar el resultado de la eliminación
    if ($resultado) {
        $_SESSION['mensaje'] = "restaurado con exito correctamente.";
        header("Location: ../eliminados.php?restaurado=1");
    } else {
        $_SESSION['mensaje'] = "Error al restaurar el elemento.";
        header("Location: ../eliminados.php?restaurado=0");
    }
} else {
    $_SESSION['mensaje'] = "ID inválido.";
}

// Redirigir de vuelta al historial
header("Location: ../eliminados.php");
exit();

?>
