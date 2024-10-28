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
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a class="text-lg font-bold text-gray-700" href="#">MUSEO</a>
            <div class="md:hidden">
                <button class="navbar-toggler" type="button" onclick="toggleNavbar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden md:flex space-x-4">
                <a href="../index.php" class="text-gray-700 hover:text-blue-500">Inicio</a>
                <a href="#" class="text-gray-700 hover:text-blue-500">Acerca de</a>
                <a href="../contacto/formulario.php" class="text-gray-700 hover:text-blue-500">Contacto</a>
            </div>
        </div>
    </div>
</nav>

<!-- Formulario de autenticación -->
<div class="container mx-auto mt-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Formulario de Iniciar Sesión -->
        <div class="flex flex-col justify-center items-center bg-white p-6 rounded-lg shadow-lg">
            <div id="login-form">
                <h3 class="text-center text-2xl font-bold mb-4">Iniciar Sesión</h3>
                <form action="../funciones/procesar_login.php" method="post">
                    <div class="form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu correo" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <div class="input-group">
                            <input id="password" name="clave" type="password" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-l-md" placeholder="Ingresa tu contraseña" required>
                            <div class="input-group-append">
                                <button type="button" onclick="togglePassword('password')" class="btn btn-outline-secondary">Ver</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label text-sm text-gray-600">Recuérdame</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Iniciar Sesión</button>
                </form>
                <span class="text-blue-500 cursor-pointer mt-4" onclick="toggleForms()">¿No tienes una cuenta? Regístrate</span>
            </div>

            <!-- Formulario de Registro -->
            <div id="register-form" class="hidden">
                <h3 class="text-center text-2xl font-bold mb-4">Registro</h3>
                <form action="../funciones/cargarUsuario.php" method="post">
                    <div class="form-group">
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                        <input type="text" id="dni" name="dni" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu DNI" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Ingresa tu correo" required>
                    </div>
                    <div class="form-group">
                        <label for="clave" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <div class="input-group">
                            <input id="clave" name="clave" type="password" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-l-md" placeholder="Ingresa tu contraseña" required>
                            <div class="input-group-append">
                                <button type="button" onclick="togglePassword('clave')" class="btn btn-outline-secondary">Ver</button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Registrarse</button>
                </form>
                <span class="text-blue-500 cursor-pointer mt-4" onclick="toggleForms()">¿Ya tienes una cuenta? Inicia sesión</span>
            </div>
        </div>

        <!-- Imagen lateral -->
        <div class="hidden md:flex justify-center items-center">
            <img src="../assets/img/contacto.jpg" alt="Imagen Random" class="rounded-lg shadow-md">
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Se produjo un error al enviar el formulario. Por favor, inténtalo de nuevo.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a href="../contacto/formulario.php" class="btn btn-primary">Volver al formulario</a>
            </div>
        </div>
    </div>
</div>

 <!-- Modal -->
 <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¡La operación se realizó con éxito! Has enviado el formulario correctamente.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='../contacto/formulario.php'">Ir al Formulario</button>
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
        loginForm.classList.toggle('hidden');
        registerForm.classList.toggle('hidden');
    }

    function togglePassword(inputId) {
        var input = document.getElementById(inputId);
        input.type = input.type === "password" ? "text" : "password";
    }
</script>
<script>
    // Verificar si hay un parámetro "error" en la URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error')) {
        // Mostrar el modal
        $('#errorModal').modal('show');
    }
</script>
<script>
        // Función para mostrar el modal si hay un parámetro de éxito en la URL
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                const modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();
            }
        });
    </script>

<?php include('../includes/footer.php'); ?>
</body>
</html>
