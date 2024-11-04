<?php
session_start();
require_once("../../modelo/bd.php");
require_once("../../modelo/usuarioPieza.php");
require_once '../../fpdf/fpdf.php'; // Asegúrate de que FPDF esté en la ubicación correcta

// Crear una instancia de la clase UsuarioHasPieza
$usuarioHasPieza = new UsuarioHasPieza();

// Obtener todos los registros del historial
$registros = $usuarioHasPieza->getAllDetalles(); // Implementa esta función en tu modelo

// Crear una instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título
$pdf->Cell(0, 10, 'Historial de Usuario-Pieza', 0, 1, 'C');

// Salto de línea
$pdf->Ln(10);

// Establecer el tipo de letra para los registros
$pdf->SetFont('Arial', '', 12);

// Escribir los datos en el PDF
if (!empty($registros)) {
    foreach ($registros as $registro) {
        $pdf->Cell(0, 10, "ID Usuario: " . $registro['Usuario_idUsuario'], 0, 1);
        $pdf->Cell(0, 10, "ID Pieza: " . $registro['Pieza_idPieza'], 0, 1);
        $pdf->Cell(0, 10, "DNI: " . $registro['dni'], 0, 1);
        $pdf->Cell(0, 10, "NOMBRE: " . $registro['nombre'], 0, 1);
        $pdf->Cell(0, 10, "APELLIDO: " . $registro['apellido'], 0, 1);
        $pdf->Cell(0, 10, "FECHA DE INGRESO: " . $registro['fecha_ingreso'], 0, 1);
        $pdf->Cell(0, 10, "----------------------", 0, 1); // Separador
    }
} else {
    $pdf->Cell(0, 10, "No hay registros de usuario-pieza.", 0, 1);
}

// Configurar encabezados para mostrar el PDF en el navegador
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="historial.pdf"'); // Cambia el nombre del archivo según necesites
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Expires: 0');

// Generar el PDF
$pdf->Output();
exit();
?>
