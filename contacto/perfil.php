<?php
session_start();
require_once "../modelo/bd.php"; 
require_once "../modelo/usuario.php"; 

// Obtiene el ID del usuario a partir de la URL
$id = $_GET["id"] ?? null;

if ($id) {
    $usuario = new Usuario();
    $usuarioData = $usuario->getUsuariosById($id); 
} else {
    die("ID de usuario no proporcionado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Usuario</title>
    
    <!-- CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-Dy6+6CzD9H0dP8TFZ3mBvZ5F5uTfl0Htw1FFkNzJ8Mepjq8PfFff9CkYoh+P1JovC8bLy8lYcZ2gr0eHq3D2iw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Tailwind CSS (si lo estás usando) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .hidden { display: none; }
    </style>
</head>


<body class="bg-gray-100">
    <!-- Navbar -->
    <?php include('../includes/navListados.php'); ?>

    <div class="container mx-auto mt-10">
        <?php if ($usuarioData): ?>
            <!-- Información del usuario -->
            <div class="card shadow-lg rounded-lg mb-5">
                <div class="card-body">
                    <h5 class="text-2xl font-bold text-gray-700 mb-2">
                        <?php echo htmlspecialchars($usuarioData['nombre'] . ' ' . $usuarioData['apellido']); ?>
                    </h5>
                    <h6 class="text-md text-gray-500 mb-4">
                        <?php echo htmlspecialchars($usuarioData['email']); ?>
                    </h6>
                    <p class="text-lg text-gray-600">
                        <strong class="font-semibold text-gray-700">DNI:</strong> <?php echo htmlspecialchars($usuarioData['dni']); ?><br>
                        <strong class="font-semibold text-gray-700">Tipo de Usuario:</strong> <?php echo htmlspecialchars($usuarioData['tipo_de_usuario']); ?><br>
                        <strong class="font-semibold text-gray-700">Fecha de Alta:</strong> <?php echo htmlspecialchars($usuarioData['fecha_alta']); ?><br>
                        <strong class="font-semibold text-gray-700">Contraseña:</strong> <?php echo htmlspecialchars($usuarioData['clave']); ?>
                    </p>
                    <a href="#" class="btn btn-primary mt-3" onclick="toggleForm()">Editar Información</a>
                </div>
            </div>

            <!-- Formulario oculto para edición -->
            <div class="card shadow-lg rounded-lg mb-5 hidden" id="editForm">
                <div class="card-body">
                    <h5 class="text-xl font-bold text-gray-700 mb-4">Editar Información del Usuario</h5>
                    <form action="actualizarUsuario.php" method="POST">
                        <input type="hidden" name="idUsuario" value="<?php echo $usuarioData['idUsuario']; ?>">

                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuarioData['nombre']); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="apellido" class="block text-gray-700">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo htmlspecialchars($usuarioData['apellido']); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($usuarioData['email']); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="dni" class="block text-gray-700">DNI:</label>
                            <input type="text" id="dni" name="dni" class="form-control" value="<?php echo htmlspecialchars($usuarioData['dni']); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="tipo_de_usuario" class="block text-gray-700">Tipo de Usuario:</label>
                            <input type="text" id="tipo_de_usuario" name="tipo_de_usuario" class="form-control" value="<?php echo htmlspecialchars($usuarioData['tipo_de_usuario']); ?>" required>
                        </div>

                        <div class="mb-4 relative">
                            <label for="clave" class="block text-gray-700">Contraseña:</label>
                            <div class="input-group">
                                <input type="password" id="clave" name="clave" class="form-control" value="<?php echo htmlspecialchars($usuarioData['clave']); ?>" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                        <i id="passwordIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        <a href="#" class="btn btn-secondary" onclick="toggleForm()">Cancelar</a>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <strong>No se encontraron datos para el usuario.</strong>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include('../includes/footer.php'); ?>

    <script>
        function toggleForm() {
            const form = document.getElementById('editForm');
            form.classList.toggle('hidden');
        }

        function togglePassword() {
            const passwordField = document.getElementById('clave');
            const passwordIcon = document.getElementById('passwordIcon');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
