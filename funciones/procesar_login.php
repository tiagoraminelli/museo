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
//var_dump($usuarioDesdeDB);
//$resultado = password_verify($datos['clave'], $usuarioDesdeDB['clave']);
//var_dump($resultado);

        // Verificar si el usuario existe
        if ($usuarioDesdeDB) {
            // Verificar la contraseña
            if ((password_verify($datos['clave'],$usuarioDesdeDB['clave'])) or ($datos['clave'] === $usuarioDesdeDB['clave'])){
                // Almacenar el nombre en la sesión
                $_SESSION['usuario_activo'] = $usuarioDesdeDB['nombre'];
                $_SESSION['nivel'] = $usuarioDesdeDB['tipo_de_usuario'];
                $_SESSION['id'] = $usuarioDesdeDB['idUsuario'];
                echo "Contraseña correcta.";
                header("Location: ./../listados/piezasListado.php"); // Redirigir al índice
                exit;
            } else {
                echo "Contraseña incorrecta.";
                //var_dump($usuarioDesdeDB);
                header("Location: ../contacto/formulario.php?error=1"); // Redirigir al índice
            }
        } else {
            echo "Usuario no encontrado.";
        }
    }

    
}
?>
