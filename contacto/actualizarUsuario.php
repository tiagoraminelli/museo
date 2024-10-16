<?php
session_start();
require_once "../modelo/bd.php"; 
require_once "../modelo/usuario.php"; 
var_dump($_POST);
// Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUsuario = $_POST['idUsuario'] ?? null; // ID del usuario
    $nombre = $_POST['nombre'] ?? null;
    $apellido = $_POST['apellido'] ?? null;
    $email = $_POST['email'] ?? null;
    $dni = $_POST['dni'] ?? null;
    $tipo_de_usuario = $_POST['tipo_de_usuario'] ?? null;
    $clave = $_POST['clave'] ?? null;

    // Verifica que todos los campos requeridos tengan valores
    if ($idUsuario && $nombre && $apellido && $email && $dni && $tipo_de_usuario && $clave) {
        // Crea un arreglo asociativo con los datos
        $usuarioData = [
            'idUsuario' => $idUsuario,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'dni' => $dni,
            'tipo_de_usuario' => $tipo_de_usuario,
            'clave' => $clave
        ];

        // Instancia de la clase Usuario
        $usuario = new Usuario();
        
        // Llama al método save() de la clase Usuario
        if ($usuario->save($usuarioData)) {
            // Redirige al perfil del usuario si la actualización fue exitosa
            header("Location: perfil.php?id=$idUsuario");
            exit();
        } else {
            echo "Error al actualizar los datos del usuario.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    // Obtiene el ID del usuario a partir de la URL
    $id = $_GET["id"] ?? null;

    if ($id) {
        $usuario = new Usuario();
        $usuarioData = $usuario->getUsuariosById($id); 
    } else {
        die("ID de usuario no proporcionado.");
    }
}
?>
