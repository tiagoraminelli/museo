<?php
session_start();
if (!isset($_SESSION['usuario_activo'])) {
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../index.php");
    exit;
}
if($_SESSION['nivel'] != 'administrador'){
    header("Location: ./piezaslistado.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión / Registro</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../public/css/formularioLogin.css">
</head>
<body class="bg-gray-100">

<!-- Navbar -->

<?php include('../includes/navListados.php'); ?>
<!-- Contenedor principal -->
<div class="container mx-auto my-10">
    <div class="flex flex-col md:flex-row items-center bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Formulario de Registro -->
        <div class="w-full md:w-1/2 p-6">
            <h3 class="text-center text-2xl font-bold mb-6">Registro</h3>
            <form action="../funciones/cargarUsuario.php" method="post">
                <div class="mb-4">
                    <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                    <input type="text" id="dni" name="dni" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu DNI" required>
                </div>
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu nombre" required>
                </div>
                <div class="mb-4">
                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input type="text" id="apellido" name="apellido" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu apellido" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu correo" required>
                </div>
                <div class="mb-4">
                    <label for="clave" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="relative">
                        <input id="clave" name="clave" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu contraseña" required>
                        <button type="button" onclick="togglePassword('clave')" class="absolute inset-y-0 right-0 px-3 text-sm text-gray-500 hover:text-blue-500">Ver</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Crear</button>
                
            </form>
           
        </div>

        <!-- Imagen lateral -->
        <div class="hidden md:block md:w-1/2">
            <img src="../assets/img/contacto.jpg" alt="Imagen" class="h-full w-full object-cover">
        </div>
    </div>
</div>

<!-- Modales -->
<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">Se produjo un error al enviar el formulario. Por favor, inténtalo de nuevo.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Éxito</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">¡La operación se realizó con éxito!</div>
        </div>
    </div>
</div>

<!-- Modal de Error: Correo ya registrado -->
<div class="modal fade" id="errorCorreoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">El correo electrónico ya está registrado. Por favor, utiliza otro correo.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleForms() {
        var loginForm = document.getElementById('login-form');
        var registerForm = document.getElementById('register-form');
        loginForm?.classList.toggle('hidden');
        registerForm?.classList.toggle('hidden');
    }

    function togglePassword(inputId) {
        var input = document.getElementById(inputId);
        input.type = input.type === "password" ? "text" : "password";
    }


</script>
<?php
if (isset($_GET['errorCargarUsuario']) && $_GET['errorCargarUsuario'] == 1) {
    echo "<script>
            $(document).ready(function() {
                $('#errorCorreoModal').modal('show');
            });
          </script>";
}
?>

<?php include('../includes/footer.php'); ?>
</body>
</html>
