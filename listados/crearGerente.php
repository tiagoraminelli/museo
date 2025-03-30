<?php
session_start();
if (!isset($_SESSION['usuario_activo'])) {
    header("Location: ../index.php");
    exit;
}
if($_SESSION['nivel'] != 'administrador'){
    header("Location: ./piezaslistado.php");
    exit;
}
$breadcrumb = "Crear Gerente";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Gerente</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap (solo para modales) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">

<!-- Navbar -->
<?php include('../includes/navListados.php')?>
<?php include('../includes/breadcrumb.php')?>

<!-- Contenedor principal -->
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="md:flex">
            <!-- Formulario de Registro -->
            <div class="w-full md:w-1/2 p-8">
                <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">Registro de Gerente</h3>
                <form action="../funciones/cargarUsuario.php" method="post" class="space-y-6">
                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
                        <input type="text" id="dni" name="dni" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Ingresa tu DNI" required>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                            <input type="text" id="nombre" name="nombre" 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   placeholder="Ingresa tu nombre" required>
                        </div>
                        <div>
                            <label for="apellido" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                            <input type="text" id="apellido" name="apellido" 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   placeholder="Ingresa tu apellido" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                        <input type="email" id="email" name="email" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Ingresa tu correo" required>
                    </div>
                    
                    <div>
                        <label for="clave" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <div class="relative">
                            <input id="clave" name="clave" type="password" 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 pr-10"
                                   placeholder="Ingresa tu contraseña" required>
                            <button type="button" onclick="togglePassword('clave')" 
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-blue-600">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 transform hover:scale-[1.01] shadow-md">
                        Crear Gerente
                    </button>
                </form>
            </div>

            <!-- Imagen lateral -->
            <div class="hidden md:block md:w-1/2 bg-gradient-to-br from-blue-500 to-blue-700">
                <div class="h-full flex items-center justify-center p-8">
                    <div class="text-center text-white">
                        <img src="../assets/img/contacto.jpg" alt="Imagen de contacto" class="w-full h-auto rounded-xl shadow-2xl object-cover max-h-[500px]">
                        <h3 class="text-2xl font-bold mt-6">Gestión de Usuarios</h3>
                        <p class="mt-2 opacity-90">Administra los perfiles de gerentes y personal autorizado</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales (se mantienen igual) -->
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
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