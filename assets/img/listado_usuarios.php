
<?php
// Conexión a la base de datos (ajusta los parámetros según tu configuración)
$servername = "localhost";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "tu_base_de_datos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener datos de la tabla
$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Listado de Usuarios</title>
</head>
<body>
<div class="container mt-5">
    <h1>Listado de Usuarios</h1>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>ID Usuario</th>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Clave</th>
                <th>Fecha de Alta</th>
                <th>Tipo de Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Salida de cada fila
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["idUsuario"] . "</td>
                        <td>" . $row["dni"] . "</td>
                        <td>" . $row["nombre"] . "</td>
                        <td>" . $row["apellido"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["clave"] . "</td>
                        <td>" . $row["fecha_alta"] . "</td>
                        <td>" . $row["tipo_de_usuario"] . "</td>
                        <td>
                            <button class='btn btn-warning btn-sm'>Cambiar</button>
                            <button class='btn btn-danger btn-sm'>Eliminar</button>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center'>No hay usuarios registrados</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
