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
    $errores = [];
    $errores_campos = [];

    // Validar DNI
    if (empty($dni)) {
        $errores_campos['dni'] = "El DNI es obligatorio";
        $errores[] = "El campo DNI es obligatorio";
    } elseif (!preg_match('/^[0-9]{8,10}$/', $dni)) {
        $errores_campos['dni'] = "DNI debe tener 8-10 dígitos";
        $errores[] = "El DNI debe contener entre 8 y 10 dígitos";
    }

    // Validar nombre
    if (empty($nombre)) {
        $errores_campos['nombre'] = "El nombre es obligatorio";
        $errores[] = "El campo Nombre es obligatorio";
    }

    // Validar apellido
    if (empty($apellido)) {
        $errores_campos['apellido'] = "El apellido es obligatorio";
        $errores[] = "El campo Apellido es obligatorio";
    }

    // Validar email
    if (empty($email)) {
        $errores_campos['email'] = "El email es obligatorio";
        $errores[] = "El campo Email es obligatorio";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores_campos['email'] = "Formato de email inválido";
        $errores[] = "El formato del email no es válido";
    }

    // Validar tipo de usuario
    if (empty($tipo_de_usuario)) {
        $errores_campos['tipo_de_usuario'] = "Seleccione un tipo de usuario";
        $errores[] = "Debe seleccionar un tipo de usuario";
    }

    // Validar contraseña si se proporcionó
    if (!empty($clave) && strlen($clave) < 8) {
        $errores_campos['clave'] = "Mínimo 8 caracteres";
        $errores[] = "La contraseña debe tener al menos 8 caracteres";
    }

    // Verificar duplicados
    $usuario = new Usuario();
    $usuarioActual = $usuario->getUsuariosById($idUsuario);

    if ($usuarioActual['dni'] !== $dni && $usuario->existeDni($dni, $idUsuario)) {
        $errores_campos['dni'] = "Este DNI ya está registrado";
        $errores[] = "El DNI ya está registrado por otro usuario";
    }

    if ($usuarioActual['email'] !== $email && $usuario->existeEmail($email, $idUsuario)) {
        $errores_campos['email'] = "Este email ya está registrado";
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
        
        if ($resultado) {
            $_SESSION['mensaje_exito'] = "Usuario actualizado correctamente";
            header("Location: ../gerentesListados.php");
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