<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/usuarioPieza.php");

// Crear una instancia de la clase UsuarioHasPieza
$usuarioHasPieza = new UsuarioHasPieza();

// Obtener todos los registros del historial
$registros = $usuarioHasPieza->getAllDetalles(); // Implementa esta función en tu modelo

// Establecer la ruta del archivo donde se guardará
$directorio = '../../assets/uploads/';
$nombreArchivo = 'historial.txt';
$rutaArchivo = $directorio . $nombreArchivo;

// Abrir el archivo para escribir
$file = fopen($rutaArchivo, 'w');
/*

Usuario_idUsuario, 
Pieza_idPieza, 
dni, 
nombre, 
apellido, 
fecha_ingreso 
*/
// Escribir los datos en el archivo
if (!empty($registros)) {
    foreach ($registros as $registro) {
        fwrite($file, "ID Usuario: " . $registro['Usuario_idUsuario'] . "\n");
        fwrite($file, "ID Pieza: " . $registro['Pieza_idPieza'] . "\n");
        fwrite($file, "DNI: " . $registro['dni'] . "\n");
        fwrite($file, "NOMBRE: " . $registro['nombre'] . "\n");
        fwrite($file, "APELLIDO: " . $registro['apellido'] . "\n");
        fwrite($file, "FECHA DE INGRESO: " . $registro['fecha_ingreso'] . "\n");
        fwrite($file, "----------------------\n"); // Separador
    }
} else {
    fwrite($file, "No hay registros de usuario-pieza.\n");
}

// Cerrar el archivo
fclose($file);

// Devolver la ruta del archivo para la descarga
echo json_encode(['file' => $rutaArchivo]);
exit();
?>
