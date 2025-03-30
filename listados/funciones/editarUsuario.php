<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/usuario.php");

// Obtener el ID del usuario a editar
$idUsuario = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Crear una instancia de la clase Usuario
$usuario = new Usuario();

// Obtener los datos del usuario a editar
$usuarioActual = $usuario->getUsuariosById($idUsuario);

// Si no se encuentra el usuario, redirigir
if (!$usuarioActual) {
    header("Location: listadoUsuarios.php");
    exit();
}

// Verificar el tipo de usuario
if($_SESSION['nivel'] != 'administrador'){
    header("Location: ../index.php");
    exit();
}

// Usar datos de sesión si existen (por errores en el formulario)
$datosFormulario = isset($_SESSION['datos_formulario']) ? $_SESSION['datos_formulario'] : $usuarioActual;
if (isset($_SESSION['datos_formulario'])) {
    unset($_SESSION['datos_formulario']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
        .is-invalid {
            border-color: #dc3545;
        }
    </style>
</head>
<body>
<?php include('../../includes/navFunciones.php')?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Editar Usuario</h1>

    <?php if (isset($_SESSION['error_edicion'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['error_edicion']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_edicion']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['errores_validacion'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">Por favor corrige los siguientes errores:</h5>
            <ul class="mb-0">
                <?php foreach ($_SESSION['errores_validacion'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['errores_validacion']); ?>
    <?php endif; ?>

    <form method="POST" action="../funciones/funcionEditarUsuario.php">
        <input type="hidden" name="idUsuario" value="<?php echo htmlspecialchars($datosFormulario['idUsuario']); ?>">
        
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control <?php echo (isset($_SESSION['errores_campos']['dni']) ? 'is-invalid' : ''); ?>" 
                   id="dni" name="dni" value="<?php echo htmlspecialchars($datosFormulario['dni']); ?>" required>
            <?php if (isset($_SESSION['errores_campos']['dni'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($_SESSION['errores_campos']['dni']); ?></div>
                <?php unset($_SESSION['errores_campos']['dni']); ?>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control <?php echo (isset($_SESSION['errores_campos']['nombre']) ? 'is-invalid' : ''); ?>" 
                   id="nombre" name="nombre" value="<?php echo htmlspecialchars($datosFormulario['nombre']); ?>" required>
            <?php if (isset($_SESSION['errores_campos']['nombre'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($_SESSION['errores_campos']['nombre']); ?></div>
                <?php unset($_SESSION['errores_campos']['nombre']); ?>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control <?php echo (isset($_SESSION['errores_campos']['apellido']) ? 'is-invalid' : ''); ?>" 
                   id="apellido" name="apellido" value="<?php echo htmlspecialchars($datosFormulario['apellido']); ?>" required>
            <?php if (isset($_SESSION['errores_campos']['apellido'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($_SESSION['errores_campos']['apellido']); ?></div>
                <?php unset($_SESSION['errores_campos']['apellido']); ?>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control <?php echo (isset($_SESSION['errores_campos']['email']) ? 'is-invalid' : ''); ?>" 
                   id="email" name="email" value="<?php echo htmlspecialchars($datosFormulario['email']); ?>" required>
            <?php if (isset($_SESSION['errores_campos']['email'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($_SESSION['errores_campos']['email']); ?></div>
                <?php unset($_SESSION['errores_campos']['email']); ?>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" class="form-control <?php echo (isset($_SESSION['errores_campos']['clave']) ? 'is-invalid' : ''); ?>" 
                   id="clave" name="clave">
            <?php if (isset($_SESSION['errores_campos']['clave'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($_SESSION['errores_campos']['clave']); ?></div>
                <?php unset($_SESSION['errores_campos']['clave']); ?>
            <?php endif; ?>
            <small class="text-muted">Mínimo 8 caracteres</small>
        </div>

        <div class="mb-3">
            <label for="tipo_de_usuario" class="form-label">Tipo de Usuario</label>
            <select class="form-select <?php echo (isset($_SESSION['errores_campos']['tipo_de_usuario']) ? 'is-invalid' : ''); ?>" 
                    id="tipo_de_usuario" name="tipo_de_usuario" required>
                <option value="gerente" <?php echo ($datosFormulario['tipo_de_usuario'] == 'gerente') ? 'selected' : ''; ?>>Gerente</option>
                <option value="administrador" <?php echo ($datosFormulario['tipo_de_usuario'] == 'administrador') ? 'selected' : ''; ?>>Admin</option>
            </select>
            <?php if (isset($_SESSION['errores_campos']['tipo_de_usuario'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($_SESSION['errores_campos']['tipo_de_usuario']); ?></div>
                <?php unset($_SESSION['errores_campos']['tipo_de_usuario']); ?>
            <?php endif; ?>
        </div>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="../gerentesListados.php" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>
<?php include('../../includes/footer.php')?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Cerrar automáticamente las alertas después de 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        var alertas = document.querySelectorAll('.alert');
        alertas.forEach(function(alert) {
            setTimeout(function() {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
</body>
</html>