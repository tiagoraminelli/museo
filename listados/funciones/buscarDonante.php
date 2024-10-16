<?php
require_once "../../modelo/donante.php";
$donante = new Donante();

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Aquí debes implementar la lógica para buscar donantes que contengan el término de búsqueda.
    // Esto es solo un ejemplo; ajusta la consulta según tu modelo de datos.
    $donantes = $donante->buscarDonantes($searchTerm); // Implementa este método en tu modelo

    header('Content-Type: application/json');
    echo json_encode($donantes);
} else {
    echo json_encode([]);
}
?>
