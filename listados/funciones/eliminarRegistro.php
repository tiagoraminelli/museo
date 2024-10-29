<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/registros_eliminados.php");
$IdRegistro = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Crear una instancia de la clase UsuarioHasPieza
$registro = new registros_eliminados();

if ($IdRegistro) {
    $resultado = $registro->deleteRegistrosById($IdRegistro); // Asegúrate de tener esta función
    // Verificar el resultado de la eliminación
    if ($resultado) {
        $_SESSION['mensaje'] = "Elemento eliminado correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el elemento.";
    }
} else {
    $_SESSION['mensaje'] = "ID inválido.";
}

// Redirigir de vuelta al historial
header("Location: ../eliminados.php");
exit();

?>
