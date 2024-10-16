<?php
// Iniciamos la sesión
session_start();

// Incluimos las carpetas necesarias
include_once('../modelo/bd.php');
require('../modelo/usuario.php');

// Verificamos si se han enviado datos a través del formulario
if (isset($_POST)) {
    $datos = $_POST;
    //var_dump($datos);
    // Verificar si se mandaron solo el correo y la contraseña
    if (isset($datos['email']) && isset($datos['clave'])) {
        // Crear una instancia de Usuario
        $usuario = new Usuario();
        var_dump($datos);
        // Buscar el usuario en la base de datos usando el email
        $usuarioDesdeDB = $usuario->getUsuarioPorEmail($datos['email']);

        // Verificar si el usuario existe
        if ($usuarioDesdeDB) {
            // Verificar la contraseña
            if ($datos['clave'] == $usuarioDesdeDB['clave']){
                // Almacenar el nombre en la sesión
                $_SESSION['usuario_activo'] = $usuarioDesdeDB['nombre'];
                $_SESSION['id'] = $usuarioDesdeDB['idUsuario'];
                header("Location: ../index.php"); // Redirigir al índice
                exit;
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
    }

    
}
?>
