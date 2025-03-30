<?php
require_once "../../modelo/usuario.php";
$donante = new Usuario();

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Aquí debes implementar la lógica para buscar donantes que contengan el término de búsqueda.
    // Esto es solo un ejemplo; ajusta la consulta según tu modelo de datos.
    $donantes = $donante->buscarUsuario($searchTerm); // Implementa este método en tu modelo

    header('Content-Type: application/json');
    echo json_encode($donantes);
} else {
    echo json_encode([]);
}
?>
