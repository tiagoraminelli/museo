<?php
session_start();

if (!isset($_SESSION['usuario_activo'])) {
    header("Location: ../../index.php");
    exit;
}

require_once "../../modelo/bd.php";
require_once "../../modelo/donante.php";

// Inicializar variables
$errores = [];
$datosFormulario = [
    'nombre' => '',
    'apellido' => '',
    'fecha' => date('Y-m-d') // Fecha actual por defecto
];

// Procesar el formulario si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar datos
    $datosFormulario = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'apellido' => trim($_POST['apellido'] ?? ''),
        'fecha' => $_POST['fecha'] ?? ''
    ];

    // Validaciones
    if (empty($datosFormulario['nombre'])) {
        $errores['nombre'] = 'El nombre es requerido';
    } elseif (preg_match('/[0-9]/', $datosFormulario['nombre'])) {
        $errores['nombre'] = 'El nombre no puede contener números';
    }

    if (empty($datosFormulario['apellido'])) {
        $errores['apellido'] = 'El apellido es requerido';
    } elseif (preg_match('/[0-9]/', $datosFormulario['apellido'])) {
        $errores['apellido'] = 'El apellido no puede contener números';
    }

    if (empty($datosFormulario['fecha'])) {
        $errores['fecha'] = 'La fecha es requerida';
    } elseif ($datosFormulario['fecha'] > date('Y-m-d')) {
        $errores['fecha'] = 'La fecha no puede ser futura';
    }

    // Si no hay errores, guardar el donante
    if (empty($errores)) {
        $donanteModel = new Donante();
        
        // Determinar si es creación o edición
        if (!empty($_POST['idDonante'])) {
            $idDonante = intval($_POST['idDonante']);
            $datosFormulario['idDonante'] = $idDonante;
            $resultado = $donanteModel->save($datosFormulario);
            $mensaje = $resultado ? 'Donante actualizado correctamente' : 'Error al actualizar donante';
        } else {
            $resultado = $donanteModel->save($datosFormulario);
            $mensaje = $resultado ? 'Donante creado correctamente' : 'Error al crear donante';
        }

        if ($resultado) {
            $_SESSION['mensaje_exito'] = $mensaje;
            header("Location: ../donadoresLista.php");
            exit();
        } else {
            $errores['general'] = 'Ocurrió un error al guardar el donante';
        }
    }
}

// Si viene por GET para edición
if (isset($_GET['idDonante'])) {
    $idDonante = intval($_GET['idDonante']);
    $donanteModel = new Donante();
    $donante = $donanteModel->getDonanteById($idDonante);
    
    if ($donante && count($donante) > 0) {
        $datosFormulario = [
            'idDonante' => $donante[0]['idDonante'],
            'nombre' => $donante[0]['nombre'],
            'apellido' => $donante[0]['apellido'],
            'fecha' => $donante[0]['fecha']
        ];
    } else {
        $_SESSION['error'] = 'Donante no encontrado';
        header("Location: ../donadoresLista.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($datosFormulario['idDonante']) ? 'Editar' : 'Agregar'; ?> Donante</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .error-mensaje {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
    </style>
</head>
<body class="bg-light">
<?php include('../../includes/navbar.php') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 text-center"><?php echo isset($datosFormulario['idDonante']) ? 'Editar' : 'Agregar'; ?> Donante</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($errores['general'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $errores['general']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="formDonante">
                        <?php if (isset($datosFormulario['idDonante'])): ?>
                            <input type="hidden" name="idDonante" value="<?php echo $datosFormulario['idDonante']; ?>">
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php echo isset($errores['nombre']) ? 'is-invalid' : ''; ?>" 
                                   id="nombre" name="nombre" placeholder="Ingrese el nombre"
                                   value="<?php echo htmlspecialchars($datosFormulario['nombre']); ?>">
                            <?php if (isset($errores['nombre'])): ?>
                                <div class="error-mensaje"><?php echo $errores['nombre']; ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php echo isset($errores['apellido']) ? 'is-invalid' : ''; ?>" 
                                   id="apellido" name="apellido" placeholder="Ingrese el apellido"
                                   value="<?php echo htmlspecialchars($datosFormulario['apellido']); ?>">
                            <?php if (isset($errores['apellido'])): ?>
                                <div class="error-mensaje"><?php echo $errores['apellido']; ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-4">
                            <label for="fecha" class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?php echo isset($errores['fecha']) ? 'is-invalid' : ''; ?>" 
                                   id="fecha" name="fecha" max="<?php echo date('Y-m-d'); ?>"
                                   value="<?php echo htmlspecialchars($datosFormulario['fecha']); ?>">
                            <?php if (isset($errores['fecha'])): ?>
                                <div class="error-mensaje"><?php echo $errores['fecha']; ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="../donadoresLista.php" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> <?php echo isset($datosFormulario['idDonante']) ? 'Actualizar' : 'Guardar'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS y dependencias -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    // Validación del formulario con jQuery Validation
    $('#formDonante').validate({
        rules: {
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
            fecha: {
                required: true,
                date: true,
                maxDate: "<?php echo date('Y-m-d'); ?>"
            }
        },
        messages: {
            nombre: {
                required: "Por favor ingrese el nombre",
                lettersonly: "El nombre solo puede contener letras",
                minlength: "El nombre debe tener al menos 2 caracteres"
            },
            apellido: {
                required: "Por favor ingrese el apellido",
                lettersonly: "El apellido solo puede contener letras",
                minlength: "El apellido debe tener al menos 2 caracteres"
            },
            fecha: {
                required: "Por favor ingrese la fecha",
                date: "Ingrese una fecha válida",
                maxDate: "La fecha no puede ser futura"
            }
        },
        errorElement: "div",
        errorClass: "error-mensaje",
        highlight: function(element, errorClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass("is-invalid").addClass("is-valid");
        }
    });

    // Método personalizado para validar solo letras
    $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value);
    });

    // Método personalizado para validar fecha máxima
    $.validator.addMethod("maxDate", function(value, element, param) {
        if (!value) return true;
        return new Date(value) <= new Date(param);
    });
});
</script>

<?php include('../../includes/footer.php') ?>
</body>
</html>