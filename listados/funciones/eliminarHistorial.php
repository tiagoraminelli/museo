<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/usuarioPieza.php");

// Verificar si se ha recibido el ID del usuario y el ID de la pieza
$usuarioId = isset($_GET['usuario']) ? intval($_GET['usuario']) : 0;
$piezaId = isset($_GET['pieza']) ? intval($_GET['pieza']) : 0;

// Crear una instancia de la clase UsuarioHasPieza
$usuarioHasPieza = new UsuarioHasPieza();

if ($usuarioId > 0 && $piezaId > 0) {
    $resultado = $usuarioHasPieza->eliminarPorIds($usuarioId, $piezaId); // Asegúrate de tener esta función

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
header("Location: ../historial.php");
exit();
?>
