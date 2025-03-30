<?php
// Iniciamos la sesión
session_start();

// Incluimos las clases necesarias
require_once('../modelo/bd.php');
require_once('../modelo/usuario.php');

// Verificamos si se han enviado datos a través del formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        echo "<h2>Datos recibidos:</h2>";
        var_dump($_POST);
        echo "<hr>";

        // Validar que los campos requeridos estén presentes
        if (empty($_POST['email']) || empty($_POST['clave'])) {
            throw new Exception('Por favor ingrese su email y contraseña');
        }

        // Sanitizar y validar el email
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El formato del email no es válido');
        }

        // Obtener la contraseña (no sanitizar contraseñas)
        $clave = $_POST['clave'];

        // Crear una instancia de Usuario
        $usuario = new Usuario();
        
        // Buscar el usuario en la base de datos
        $usuarioDesdeDB = $usuario->getUsuarioPorEmail($email);

        echo "<h2>Usuario desde BD:</h2>";
        var_dump($usuarioDesdeDB);
        echo "<hr>";

        // Verificar si el usuario existe y la contraseña es correcta
        if (!$usuarioDesdeDB) {
            // Mensaje genérico por seguridad (no revelar si el usuario existe)
            throw new Exception('Credenciales incorrectas');
        }

        // Mostrar contraseña almacenada en BD (SOLO PARA DEPURACIÓN)
        echo "<h3>Contraseña en BD:</h3>";
        echo "Texto plano: " . htmlspecialchars($usuarioDesdeDB['clave']) . "<br>";
        echo "<hr>";

        // Verificar la contraseña (con soporte para migración de contraseñas en texto plano)
        $contrasenaValida = false;
        
        // Primero verificar contraseña hasheada
        echo "<h3>Verificación de contraseña:</h3>";
        echo "Contraseña ingresada: " . htmlspecialchars($clave) . "<br>";
        echo "Hash en BD: " . htmlspecialchars($usuarioDesdeDB['clave']) . "<br>";
        $comparacion = password_hash($clave, PASSWORD_DEFAULT);
        echo "Hash generado: " . htmlspecialchars($comparacion) . "<br>";
        
        $verificacionHash = password_verify($clave, $usuarioDesdeDB['clave']);
        echo "Resultado password_verify: " . ($verificacionHash ? 'Verdadero' : 'Falso') . "<br>";
        
        if ($verificacionHash) {
            $contrasenaValida = true;
            echo "Contraseña válida (hash)<br>";
            
        } 



        // Verificación de contraseña en texto plano (SOLO PARA MIGRACIÓN)
        if (!$contrasenaValida) {
            echo "Comparando con texto plano...<br>";
            if ($clave === $usuarioDesdeDB['clave']) {
                $contrasenaValida = true;
                echo "Contraseña válida (texto plano)<br>";
                echo "Es estrictamente igual" . "<br>";
                
                // Migrar a hash (SOLO PARA MIGRACIÓN)
                $nuevoHash = password_hash($clave, PASSWORD_DEFAULT);
                echo "Nuevo hash generado: " . htmlspecialchars($nuevoHash) . "<br>";
            }
        }

        echo "<hr>";
        echo "Resultado final validación: " . ($contrasenaValida ? 'Válida' : 'Inválida') . "<br>";
        ////die(); // Punto de depuración estratégico

        if (!$contrasenaValida) {
            throw new Exception('Credenciales incorrectas');
        }

        // Regenerar el ID de sesión para prevenir fixation
        session_regenerate_id(true);

        // Configurar variables de sesión (manteniendo tu estructura original)
        $_SESSION['usuario_activo'] = $usuarioDesdeDB['nombre'];
        $_SESSION['nivel'] = $usuarioDesdeDB['tipo_de_usuario'];
        $_SESSION['id'] = $usuarioDesdeDB['idUsuario'];

        echo "<h2>Sesión configurada:</h2>";
        var_dump($_SESSION);
      ////die(); // Punto de depuración estratégico

        // Redirigir según el tipo de usuario
        if ($_SESSION['nivel'] === 'administrador') {
            header('Location: ../listados/gerentesListados.php');
        } else {
            header('Location: ../listados/piezasListado.php');
        }
        exit;

    } catch (Exception $e) {
        // Manejo de errores
        echo "<h2>Error:</h2>";
        echo $e->getMessage();
       ////die(); // Punto de depuración estratégico
        
        $_SESSION['error_login'] = $e->getMessage();
        header('Location: ../contacto/formulario.php?error=1');
        exit;
    }
} else {
    // Si no es POST, redirigir al formulario
    header('Location: ../contacto/formulario.php');
    exit;
}