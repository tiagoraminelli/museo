<?php
// Iniciar sesión
session_start();

// Cerrar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Redireccionar al índice
header("Location: ../index.php"); // Cambia la ruta al índice según sea necesario
exit; // Asegurarte de que no se ejecute más código
?>
