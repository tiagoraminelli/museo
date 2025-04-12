<?php
session_start();
require_once("../modelo/bd.php");
require_once("../modelo/usuario.php");

// Verificar permisos
if(!isset($_SESSION['usuario_activo']) || $_SESSION['nivel'] != 'administrador'){
    header("Location: ../index.php");
    exit();
}

// Usar datos de sesión si existen (por errores en el formulario)
$datosFormulario = isset($_SESSION['datos_formulario']) ? $_SESSION['datos_formulario'] : [
    'dni' => '',
    'nombre' => '',
    'apellido' => '',
    'email' => '',
    'tipo_de_usuario' => ''
];

if (isset($_SESSION['datos_formulario'])) {
    unset($_SESSION['datos_formulario']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Gerente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .error-message p {
            margin-bottom: 0.2rem;
            font-size: 0.8rem;
        }
        .error-message p:not(:last-child) {
            margin-bottom: 0.3rem;
        }
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>
<body>
<?php include('../includes/navListados.php')?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0 text-center">Crear Nuevo Gerente</h2>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error_general'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($_SESSION['error_general']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error_general']); ?>
                    <?php endif; ?>

                    <form method="POST" action="../funciones/cargarUsuario.php" id="formCrearGerente">
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php echo (isset($_SESSION['errores_campos']['dni'])) ? 'is-invalid' : ''; ?>" 
                                   id="dni" name="dni" value="<?php echo htmlspecialchars($datosFormulario['dni']); ?>" 
                                   placeholder="Ingrese 8 dígitos" required>
                            <?php if (isset($_SESSION['errores_campos']['dni'])): ?>
                                <div class="error-message">
                                    <?php foreach ((array)$_SESSION['errores_campos']['dni'] as $error): ?>
                                        <p><?php echo htmlspecialchars($error); ?></p>
                                    <?php endforeach; ?>
                                </div>
                                <?php unset($_SESSION['errores_campos']['dni']); ?>
                            <?php endif; ?>
                            <small class="text-muted">Debe contener exactamente 8 dígitos numéricos</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo (isset($_SESSION['errores_campos']['nombre'])) ? 'is-invalid' : ''; ?>" 
                                       id="nombre" name="nombre" value="<?php echo htmlspecialchars($datosFormulario['nombre']); ?>" 
                                       placeholder="Ej: Juan" required>
                                <?php if (isset($_SESSION['errores_campos']['nombre'])): ?>
                                    <div class="error-message">
                                        <?php foreach ((array)$_SESSION['errores_campos']['nombre'] as $error): ?>
                                            <p><?php echo htmlspecialchars($error); ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php unset($_SESSION['errores_campos']['nombre']); ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo (isset($_SESSION['errores_campos']['apellido'])) ? 'is-invalid' : ''; ?>" 
                                       id="apellido" name="apellido" value="<?php echo htmlspecialchars($datosFormulario['apellido']); ?>" 
                                       placeholder="Ej: Pérez" required>
                                <?php if (isset($_SESSION['errores_campos']['apellido'])): ?>
                                    <div class="error-message">
                                        <?php foreach ((array)$_SESSION['errores_campos']['apellido'] as $error): ?>
                                            <p><?php echo htmlspecialchars($error); ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php unset($_SESSION['errores_campos']['apellido']); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control <?php echo (isset($_SESSION['errores_campos']['email'])) ? 'is-invalid' : ''; ?>" 
                                   id="email" name="email" value="<?php echo htmlspecialchars($datosFormulario['email']); ?>" 
                                   placeholder="Ej: ejemplo@dominio.com" required>
                            <?php if (isset($_SESSION['errores_campos']['email'])): ?>
                                <div class="error-message">
                                    <?php foreach ((array)$_SESSION['errores_campos']['email'] as $error): ?>
                                        <p><?php echo htmlspecialchars($error); ?></p>
                                    <?php endforeach; ?>
                                </div>
                                <?php unset($_SESSION['errores_campos']['email']); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="clave" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="password" class="form-control <?php echo (isset($_SESSION['errores_campos']['clave'])) ? 'is-invalid' : ''; ?>" 
                                       id="clave" name="clave" placeholder="Ingrese una contraseña segura" required>
                                <i class="fas fa-eye password-toggle" onclick="togglePassword('clave')"></i>
                            </div>
                            <?php if (isset($_SESSION['errores_campos']['clave'])): ?>
                                <div class="error-message">
                                    <?php foreach ((array)$_SESSION['errores_campos']['clave'] as $error): ?>
                                        <p><?php echo htmlspecialchars($error); ?></p>
                                    <?php endforeach; ?>
                                </div>
                                <?php unset($_SESSION['errores_campos']['clave']); ?>
                            <?php endif; ?>
                            <small class="text-muted">Mínimo 8 caracteres, con al menos 1 mayúscula, 1 minúscula y 1 número</small>
                        </div>

                        <div class="mb-4">
                            <label for="tipo_de_usuario" class="form-label">Tipo de Usuario <span class="text-danger">*</span></label>
                            <select class="form-select <?php echo (isset($_SESSION['errores_campos']['tipo_de_usuario'])) ? 'is-invalid' : ''; ?>" 
                                    id="tipo_de_usuario" name="tipo_de_usuario" required>
                                <option value="gerente" <?php echo ($datosFormulario['tipo_de_usuario'] == 'gerente') ? 'selected' : ''; ?>>Gerente</option>
                                <option value="administrador" <?php echo ($datosFormulario['tipo_de_usuario'] == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                            </select>
                            <?php if (isset($_SESSION['errores_campos']['tipo_de_usuario'])): ?>
                                <div class="error-message">
                                    <?php foreach ((array)$_SESSION['errores_campos']['tipo_de_usuario'] as $error): ?>
                                        <p><?php echo htmlspecialchars($error); ?></p>
                                    <?php endforeach; ?>
                                </div>
                                <?php unset($_SESSION['errores_campos']['tipo_de_usuario']); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="../gerentesListados.php" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times-circle me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Crear Gerente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php')?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    // Función para mostrar/ocultar contraseña
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling;
        
        if (field.type === "password") {
            field.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Validación del formulario con jQuery Validation
    $(document).ready(function() {
        $('#formCrearGerente').validate({
            rules: {
                dni: {
                    required: true,
                    digits: true,
                    minlength: 8,
                    maxlength: 8
                },
                nombre: {
                    required: true,
                    lettersonly: true,
                    minlength: 2
                },
                apellido: {
                    required: true,
                    lettersonly: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                clave: {
                    required: true,
                    minlength: 8,
                    strongPassword: true
                },
                confirmar_clave: {
                    required: true,
                    equalTo: "#clave"
                },
                tipo_de_usuario: {
                    required: true
                }
            },
            messages: {
                dni: {
                    required: "El DNI es requerido",
                    digits: "Solo se permiten números",
                    minlength: "El DNI debe tener 8 dígitos",
                    maxlength: "El DNI debe tener 8 dígitos"
                },
                nombre: {
                    required: "El nombre es requerido",
                    lettersonly: "Solo se permiten letras",
                    minlength: "Mínimo 2 caracteres"
                },
                apellido: {
                    required: "El apellido es requerido",
                    lettersonly: "Solo se permiten letras",
                    minlength: "Mínimo 2 caracteres"
                },
                email: {
                    required: "El email es requerido",
                    email: "Ingrese un email válido"
                },
                clave: {
                    required: "La contraseña es requerida",
                    minlength: "Mínimo 8 caracteres"
                },
                confirmar_clave: {
                    required: "Confirme la contraseña",
                    equalTo: "Las contraseñas no coinciden"
                },
                tipo_de_usuario: {
                    required: "Seleccione un tipo de usuario"
                }
            },
            errorElement: "div",
            errorClass: "error-message",
            highlight: function(element, errorClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass("is-invalid").addClass("is-valid");
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        // Método personalizado para validar solo letras
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value);
        });

        // Método personalizado para contraseña segura
        $.validator.addMethod("strongPassword", function(value, element) {
            return this.optional(element) || 
                   /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(value);
        }, "Debe contener al menos 1 mayúscula, 1 minúscula y 1 número");

        // Cerrar automáticamente las alertas después de 5 segundos
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    });
</script>
</body>
</html>