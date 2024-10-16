<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión / Registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/formularioLogin.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="#">Logo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Acerca de</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contacto</a>
            </li>
        </ul>
    </div>
</nav>



<div class="container auth-container">
    <div class="row">
        <!-- Columna para los formularios -->
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
            <!-- Formulario de Iniciar Sesión -->
            <div class="auth-form" id="login-form">
                <h3 class="text-center">Iniciar Sesión</h3>
                <form action="../funciones/procesar_login.php" method="post">
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
                    </div>

                    <div class="input-group mb-3">
                        
                    <input id="password" name="clave" type="password" class="form-control" placeholder="Ingresa tu contraseña" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button onclick="togglePassword('password')" class="btn btn-outline-secondary" type="button" id="button-addon2">ver</button>
                    </div>

                   
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Recuérdame</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>
                <span class="toggle-link" onclick="toggleForms()">¿No tienes una cuenta? Regístrate</span>
            </div>
            
            <!-- Formulario de Registro -->
            <div class="auth-form" id="register-form" style="display: none;">
                <h3 class="text-center">Registro</h3>
                <form action="../funciones/procesar_login.php" method="post">
                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingresa tu DNI" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingresa tu apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
                    </div>
                    <div class="form-group password-container">
                        <label for="clave">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingresa tu contraseña" required>
                        <span class="show-password" onclick="togglePassword('clave')">
                            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/>
                            </svg>
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                </form>
                <span class="toggle-link" onclick="toggleForms()">¿Ya tienes una cuenta? Inicia sesión</span>
            </div>
        </div>
        <!-- Columna para la imagen -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="https://via.placeholder.com/400x400" alt="Imagen Random" class="auth-image">
        </div>
    </div>
</div>

<script>
    // Función para alternar entre los formularios de inicio de sesión y registro
    function toggleForms() {
        var loginForm = document.getElementById('login-form');
        var registerForm = document.getElementById('register-form');
        if (loginForm.style.display === 'none') {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        } else {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        }
    }

    // Función para mostrar/ocultar la contraseña
    function togglePassword(inputId) {
        var input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php include('../includes/footer.php'); ?>
</html>
