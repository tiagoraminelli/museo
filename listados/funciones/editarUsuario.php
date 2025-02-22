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
if ($_SESSION['tipo_de_usuario'] !== 'administrador') {
    // Si el usuario no es de tipo "admin", redirigir a piezaslistado.php
    header("Location: ../piezaslistado.php");
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $param = [
        'idUsuario' => $idUsuario,
        'dni' => $_POST['dni'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'email' => $_POST['email'],
        'clave' => $_POST['clave'], // La contraseña se hashea en el método save
        'tipo_de_usuario' => $_POST['tipo_de_usuario']
    ];

    // Guardar los cambios utilizando el método save
    $usuario->save($param);

    // Redirigir al listado de usuarios después de la edición
    header("Location: listadoUsuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('../../includes/navFunciones.php')?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Editar Usuario</h1>

    <form method="POST" action="../funciones/funcionEditarUsuario.php">
        <div class="mb-3">
            <label for="id" class="form-label">ID:</label>
            <input type="text" class="form-control" id="idUsuario" name="idUsuario" value="<?php echo htmlspecialchars($usuarioActual['idUsuario']); ?>" required readonly>
        </div>
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" value="<?php echo htmlspecialchars($usuarioActual['dni']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuarioActual['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuarioActual['apellido']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuarioActual['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">clave</label>
            <input type="password" class="form-control" id="clave" name="clave" value="<?php echo htmlspecialchars($usuarioActual['clave']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="tipo_de_usuario" class="form-label">Tipo de Usuario</label>
            <select class="form-select" id="tipo_de_usuario" name="tipo_de_usuario" required>
                <option value="gerente" <?php echo ($usuarioActual['tipo_de_usuario'] == 'gerente') ? 'selected' : ''; ?>>Gerente</option>
                <option value="admin" <?php echo ($usuarioActual['tipo_de_usuario'] == 'administrador') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="../gerentesListados.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php include('../../includes/footer.php')?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>