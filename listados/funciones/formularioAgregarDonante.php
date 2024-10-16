<?php
require_once "../../modelo/bd.php"; // Asegúrate de tener tu archivo de conexión a la base de datos
require_once "../../modelo/donante.php"; // Asegúrate de que esta clase exista y esté correctamente configurada

$donante = []; // Inicializa la variable como un arreglo vacío

if (isset($_GET['idDonante'])) {
    $idDonante = intval($_GET['idDonante']); // Convierte a entero para evitar inyección SQL

    // Crea una instancia de la clase Donante
    $donanteModel = new Donante();

    // Obtiene los datos del donante por su ID
    $donante = $donanteModel->getDonanteById($idDonante);

    // Verifica si se encontró el donante
    if (!$donante) {
        echo "Donante no encontrado.";
        exit; // Termina la ejecución si el donante no existe
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar/Editar Donador</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2><?php echo isset($donante['idDonante']) ? 'Editar Donador' : 'Agregar Donador'; ?></h2>
  <form action="agregarDonador.php" method="POST">
    
    <!-- Campo oculto para el ID del donante si se está editando -->
    <?php if (isset($donante['idDonante'])): ?>
      <input type="hidden" name="idDonante" value="<?php echo $donante['idDonante']; ?>">
    <?php endif; ?>
    
    <div class="form-group">
      <label for="nombre">Nombre:</label>
      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre" 
             value="<?php echo isset($donante['nombre']) ? htmlspecialchars($donante['nombre']) : ''; ?>">
    </div>
    
    <div class="form-group">
      <label for="apellido">Apellido:</label>
      <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese el apellido" 
             value="<?php echo isset($donante['apellido']); ?>">
    </div>
    
    <div class="form-group">
      <label for="fecha">Fecha:</label>
      <input type="date" class="form-control" id="fecha" name="fecha" 
             value="<?php echo isset($donante['fecha']) ? htmlspecialchars($donante['fecha']) : ''; ?>">
    </div>
    
    <button type="submit" class="btn btn-primary">
      <?php echo isset($donante['idDonante']) ? 'Actualizar Donador' : 'Agregar Donador'; ?>
    </button>
    <a href="../donadoresLista.php" class="btn btn-danger">Cancelar</a>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
<?php include('../../includes/footer.php') ?>
</html>
