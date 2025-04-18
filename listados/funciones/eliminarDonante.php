<?php
session_start();

if (!isset($_SESSION['usuario_activo'])) {
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../../index.php");
    exit;
}
require_once("../../modelo/bd.php");
require_once("../../modelo/donante.php");

// Verificar si se ha recibido el ID del usuario y el ID de la pieza
$idDonante = isset($_GET['id']) ? intval($_GET['id']) : 0;


// Crear una instancia de la clase UsuarioHasPieza
$donante = new Donante();

if ($idDonante) {
    $resultado = $donante->deleteDonanteById($idDonante); // Asegúrate de tener esta función

    // Verificar el resultado de la eliminación
    if ($resultado) {
        $_SESSION['mensaje'] = "Error al eliminar el elemento, problemas con las claves foraneas.";
        header("Location: ../donadoresLista.php?eliminado=0");
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el elemento, problemas con las claves foraneas.";
        header("Location: ../donadoresLista.php?eliminado=1");
    }
} else {
    $_SESSION['mensaje'] = "ID inválido.";
}

exit();
?>
