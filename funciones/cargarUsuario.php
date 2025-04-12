<?php
session_start();
require_once('../modelo/bd.php');
require_once('../modelo/usuario.php');

// Inicializar array de errores
$_SESSION['errores_campos'] = [];
$_SESSION['datos_formulario'] = $_POST;

// Validaciones
if (empty($_POST['dni'])) {
    $_SESSION['errores_campos']['dni'][] = 'El DNI es requerido';
} elseif (!preg_match('/^\d{8}$/', $_POST['dni'])) {
    $_SESSION['errores_campos']['dni'][] = 'El DNI debe tener 8 dígitos exactos';
}

if (empty($_POST['nombre'])) {
    $_SESSION['errores_campos']['nombre'][] = 'El nombre es requerido';
} elseif (preg_match('/[0-9]/', $_POST['nombre'])) {
    $_SESSION['errores_campos']['nombre'][] = 'El nombre no puede contener números';
}

if (empty($_POST['apellido'])) {
    $_SESSION['errores_campos']['apellido'][] = 'El apellido es requerido';
} elseif (preg_match('/[0-9]/', $_POST['apellido'])) {
    $_SESSION['errores_campos']['apellido'][] = 'El apellido no puede contener números';
}

if (empty($_POST['email'])) {
    $_SESSION['errores_campos']['email'][] = 'El email es requerido';
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errores_campos']['email'][] = 'El email no tiene un formato válido';
}

if (empty($_POST['clave'])) {
    $_SESSION['errores_campos']['clave'][] = 'La contraseña es requerida';
} elseif (strlen($_POST['clave']) < 8) {
    $_SESSION['errores_campos']['clave'][] = 'La contraseña debe tener al menos 8 caracteres';
} elseif (!preg_match('/[A-Z]/', $_POST['clave']) || !preg_match('/[a-z]/', $_POST['clave']) || !preg_match('/[0-9]/', $_POST['clave'])) {
    $_SESSION['errores_campos']['clave'][] = 'La contraseña debe contener mayúsculas, minúsculas y números';
}


if (empty($_POST['tipo_de_usuario'])) {
    $_SESSION['errores_campos']['tipo_de_usuario'][] = 'Seleccione un tipo de usuario';
}

// Verificar duplicados solo si no hay otros errores
if (empty($_SESSION['errores_campos'])) {
    $usuario = new Usuario();
    
    if ($usuario->getUsuarioPorDni($_POST['dni'])) {
        $_SESSION['errores_campos']['dni'][] = 'Este DNI ya está registrado en la base de datos';
    }
    
    if ($usuario->getUsuarioPorEmail($_POST['email'])) {
        $_SESSION['errores_campos']['email'][] = 'Este email ya está registrado en la base de datos';
    }
}

// Si hay errores, redirigir de vuelta al formulario
if (!empty($_SESSION['errores_campos'])) {
    header("Location: ../listados/crearGerente.php");
    exit();
}


$parametros = [
    'dni' => $_POST['dni'],
    'nombre' => $_POST['nombre'],
    'apellido' => $_POST['apellido'],
    'email' => $_POST['email'],
    'clave' => $_POST['clave'],
    'tipo_de_usuario' => $_POST['tipo_de_usuario']
];

if ($usuario->save($parametros)) {
    $_SESSION['mensaje_exito'] = 'Usuario creado exitosamente';
    header("Location: ../listados/gerentesListados.php");
} else {
    $_SESSION['error_general'] = 'Error al guardar el usuario';
    header("Location: ../listados/crearGerente.php");
}
exit();
?>