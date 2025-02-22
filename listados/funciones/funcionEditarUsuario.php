<?php
session_start();

require_once("../../modelo/bd.php");
require_once("../../modelo/usuario.php");

if(!isset($_SESSION['usuario_activo'])){
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../index.php");
    exit;
}


// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    var_dump($_POST);
    // Recoger los datos del formulario
    $idUsuario = isset($_POST['idUsuario']) ? intval($_POST['idUsuario']) : 0;
    $dni = isset($_POST['dni']) ? trim($_POST['dni']) : '';
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $tipo_de_usuario = isset($_POST['tipo_de_usuario']) ? trim($_POST['tipo_de_usuario']) : '';

    // Validar los datos (puedes agregar más validaciones según tus necesidades)
    if (empty($dni) || empty($nombre) || empty($apellido) || empty($email) || empty($tipo_de_usuario)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: editarUsuario.php?id=" . $idUsuario);
        exit();
    }

    // Crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // Preparar los datos para el método save
    $param = [
        'idUsuario' => $idUsuario,
        'dni' => $dni,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'tipo_de_usuario' => $tipo_de_usuario
    ];

    // Si se proporciona una nueva contraseña, agregarla al array
    if (!empty($_POST['clave'])) {
        $param['clave'] = $_POST['clave'];
    }
    echo "<pre>";
    var_dump($param);
    echo "</pre>";

    // Guardar los cambios utilizando el método save
    $resultado = $usuario->save($param);

    if ($resultado) {
        $_SESSION['mensaje'] = "Usuario actualizado correctamente.";
    } else {
        $_SESSION['error'] = "Error al actualizar el usuario.";
    }

    // Redirigir al listado de usuarios después de la edición
    header("Location: ../gerentesListados.php?actualizado=1");
    exit();
} else {
    // Si no se envió el formulario, redirigir al listado de usuarios
    header("Location: ../gerentesListados.php?actualizado=0");
    exit();
}