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
        // Buscar el usuario en la base de datos usando el email
        $usuarioDesdeDB = $usuario->getUsuarioPorEmail($datos['email']);
        //imprimimos en pantalla
        echo "<pre>";
        var_dump($datos);
        echo "</pre>";
        echo "<pre>";
        var_dump($usuarioDesdeDB);
        echo "</pre>";
        echo "Comprobamos ambas contraseñas"."<br>";


        // Verificar si el usuario existe
        if ($usuarioDesdeDB) {
            // Verificar la contraseña
            if (password_verify($datos['clave'],$usuarioDesdeDB['clave'])){
                // Almacenar el nombre en la sesión
                $_SESSION['usuario_activo'] = $usuarioDesdeDB['nombre'];
                $_SESSION['nivel'] = $usuarioDesdeDB['tipo_de_usuario'];
                $_SESSION['id'] = $usuarioDesdeDB['idUsuario'];
                echo "Contraseña correcta.";
                header("Location: ../index.php"); // Redirigir al índice
                exit;
            } else {
                echo "Contraseña incorrecta.";
                //header("Location: ../contacto/formulario.php?error=1"); // Redirigir al índice
            }
        } else {
            echo "Usuario no encontrado.";
        }
    }

    
}
?>
