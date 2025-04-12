<?php
session_start();

require_once("../../modelo/bd.php");
require_once("../../modelo/usuario.php");

if(!isset($_SESSION['usuario_activo'])) {
    header("Location: ../index.php");
    exit;
}

if($_SESSION['nivel'] != 'administrador') {
    header("Location: ../index.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y limpiar datos
    $idUsuario = isset($_POST['idUsuario']) ? intval($_POST['idUsuario']) : 0;
    $dni = isset($_POST['dni']) ? trim($_POST['dni']) : '';
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $clave = isset($_POST['clave']) ? trim($_POST['clave']) : '';
    $tipo_de_usuario = isset($_POST['tipo_de_usuario']) ? trim($_POST['tipo_de_usuario']) : '';

    // Validaciones

    var_dump($_POST);
$errores = [];
$errores_campos = [];

/**
 * Función para agregar errores de validación
 * @param string $campo Nombre del campo
 * @param string $mensaje Mensaje de error
 * @param bool $agregarAErroresGenerales Si se agrega también al array de errores generales
 */
function agregarError(&$errores_campos, &$errores, $campo, $mensaje, $agregarAErroresGenerales = true) {
    if (!isset($errores_campos[$campo])) {
        $errores_campos[$campo] = [];
    }
    $errores_campos[$campo][] = $mensaje;
    if ($agregarAErroresGenerales) {
        $errores[] = $mensaje;
    }
}

// Validar DNI
if (empty($dni)) {
    agregarError($errores_campos, $errores, 'dni', "El DNI es obligatorio");
} elseif (!preg_match('/^[0-9]{8,10}$/', $dni)) {
    agregarError($errores_campos, $errores, 'dni', "DNI debe tener entre 8 y 10 dígitos");
}

// Validar nombre
if (strlen($nombre) < 3 || !preg_match('/^[a-zA-Z\s]+$/', $nombre) || substr_count($nombre, ' ') > 2) {
    agregarError($errores_campos, $errores, 'nombre', "El nombre debe tener al menos 3 caracteres, solo puede contener letras y espacios, y no más de 2 espacios en blanco");
}

if (strlen($apellido) < 3 || !preg_match('/^[a-zA-Z\s]+$/', $apellido) || substr_count($apellido, ' ') > 2) {
    agregarError($errores_campos, $errores, 'apellido', "El apellido debe tener al menos 3 caracteres, solo puede contener letras y espacios, y no más de 2 espacios en blanco");
}




// Validar email
if (empty($email)) {
    agregarError($errores_campos, $errores, 'email', "El email es obligatorio");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    agregarError($errores_campos, $errores, 'email', "Formato de email inválido");
}else{
    $emailTrim = trim($email);
    if (strlen($emailTrim) > 40) {
        agregarError($errores_campos, $errores, 'email', "El email no puede exceder los 40 caracteres", false);
    }
}

// Validar tipo de usuario
if (empty($tipo_de_usuario)) {
    agregarError($errores_campos, $errores, 'tipo_de_usuario', "Seleccione un tipo de usuario");
}
if (isset($tipo_de_usuario)) {
    $tiposPermitidos = ['administrador', 'gerente', 'usuario']; // Ajusta según tus necesidades
    if (!in_array($tipo_de_usuario, $tiposPermitidos)){
        agregarError($errores_campos, $errores, 'tipo_de_usuario', "No existe ese tipo de usuario en el sistema");
    }

}

// Validar contraseña si se proporcionó
if (!empty($clave) && strlen($clave) < 8) {
    agregarError($errores_campos, $errores, 'clave', "La contraseña debe tener al menos 8 caracteres");
}

// Si hay errores, guardar en sesión y redirigir
    // Verificar duplicados
    $usuario = new Usuario();
    $usuarioActual = $usuario->getUsuariosById($idUsuario);

    if ($usuarioActual['dni'] !== $dni && $usuario->existeDni($dni, $idUsuario)) {
        $errores_campos['dni'] = "Este DNI ya está registrado desde la db";
        $errores[] = "El DNI ya está registrado por otro usuario";
    }

    if ($usuarioActual['email'] !== $email && $usuario->existeEmail($email, $idUsuario)) {
        $errores_campos['email'] = "Este email ya está registrado desde la bd";
        $errores[] = "El email ya está registrado por otro usuario";
    }

    // Si hay errores, guardar en sesión y redirigir
    if (!empty($errores)) {
        $_SESSION['errores_validacion'] = $errores;
        $_SESSION['errores_campos'] = $errores_campos;
        $_SESSION['datos_formulario'] = [
            'idUsuario' => $idUsuario,
            'dni' => $dni,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'tipo_de_usuario' => $tipo_de_usuario
        ];
        header("Location: ./editarUsuario.php?id=" . $idUsuario);
        exit();
    }

    // Preparar datos para guardar
    $param = [
        'idUsuario' => $idUsuario,
        'dni' => $dni,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'tipo_de_usuario' => $tipo_de_usuario
    ];

    // Solo actualizar contraseña si se proporcionó
    if (!empty($clave)) {
        $param['clave'] = $clave;
    }


    // Intentar guardar
    try {
        $resultado = $usuario->save($param);
        echo "resultado: <br>" . $resultado;
        if ($resultado) {
            $_SESSION['mensaje_exito'] = "Usuario actualizado correctamente";
            header("Location: ../gerentesListados.php?actualizado=1");
            exit();
        } else {
            throw new Exception("No se realizaron cambios en el usuario");
        }
    } catch (Exception $e) {
        $_SESSION['error_edicion'] = "Error al actualizar el usuario: " . $e->getMessage();
        $_SESSION['datos_formulario'] = $param;
        header("Location: ./editarUsuario.php?id=" . $idUsuario);
        exit();
    }
} else {
    header("Location: ../gerentesListados.php");
    exit();
}