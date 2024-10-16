<?php
// Incluir el archivo que contiene la clase Pieza y la conexión a la base de datos
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";


// Comprobar si se ha recibido el parámetro 'search'
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Crear una instancia de la clase Pieza
    $pieza = new Pieza();

    // Llamar a la función buscarPiezas pasando el término de búsqueda
    $resultados = $pieza->buscarPiezas($search);

    // Enviar los resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($resultados);
} else {
    // Si no se recibe el parámetro de búsqueda, devolver un array vacío
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>
