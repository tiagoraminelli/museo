<?php
session_start();

// Incluimos las carpetas necesarias
include_once('../modelo/bd.php'); // Asegúrate de que la conexión esté correcta
require('../modelo/usuario.php'); // Asegúrate de que esta clase esté bien definida

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar datos del formulario
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $clave = $_POST['clave'];
   

    // Hash de la contraseña
    $hashedClave = password_hash($clave, PASSWORD_DEFAULT);

    // Crear un array con los parámetros
    $parametros = [
        'dni' => $dni,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'clave' => $hashedClave,
    ];

    echo "<pre>";
    var_dump($parametros);
    echo "</pre>";

    // Crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // Llamar al método save para guardar los datos
    if ($usuario->save($parametros)) {
        $_SESSION['mensaje'] = 'Usuario cargado exitosamente.';
        header("Location: ../index.php?success=1"); // Redirigir al índice
        exit();
    } else {
        $_SESSION['error'] = 'Error al cargar el usuario.';
        header("Location: ../index.php?success=0"); // Redirigir al índice
        exit();
    }
} else {
    //header('Location: formulario.php'); // Redirigir si no es una petición POST
    exit();
}
?>
