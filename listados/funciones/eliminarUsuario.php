<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/usuario.php");

if (!isset($_SESSION['usuario_activo'])) {
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../../index.php");
    exit;
}


// Verificar si se ha enviado el ID del usuario a eliminar
if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']); // Obtener el ID del usuario desde la URL
    var_dump($_GET);

    // Crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // Eliminar el usuario utilizando el método deleteUsuariosById
    $resultado = $usuario->deleteUsuariosById($idUsuario);

    if ($resultado) {
        $_SESSION['mensaje'] = "Usuario eliminado correctamente.";
    } else {
        $_SESSION['error'] = "Error al eliminar el usuario.";
    }
} else {
    $_SESSION['error'] = "ID de usuario no proporcionado.";
}

// Redirigir al listado de usuarios después de la eliminación
header("Location: ../gerentesListados.php?eliminado=1");
exit();
?>