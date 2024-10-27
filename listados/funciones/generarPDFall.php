<?php
session_start();
require_once "../../modelo/bd.php";  // Asegúrate de que la conexión esté correcta
require_once "../../modelo/pieza.php";  // Asegúrate de que esta clase esté bien definida
require_once '../../fpdf/fpdf.php'; // Asegúrate de que FPDF esté en la ubicación correcta

class PDF extends FPDF {
    // Encabezado
    function Header() {
        // Establecer color de fondo (gris claro)
        $this->SetFillColor(220, 220, 220); // Color gris claro
        $this->Rect(0, 0, 297, 40, 'F'); // Dibujar rectángulo de fondo

        // Configurar el color del texto
        $this->SetTextColor(0, 0, 0); // Color negro
        $this->SetFont('Arial', 'B', 15);
        
        // Título
        $this->Cell(0, 10, 'Detalles de la Pieza', 0, 1, 'C');
        $this->Ln(10); // Salto de línea
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear una instancia de la clase Pieza
$pieza = new Pieza();
$resultados = $pieza->getAllPiezas(); // Método para obtener todos los registros de la tabla

// Crear el PDF con orientación horizontal y márgenes ajustados
$pdf = new PDF('L', 'mm', 'A4'); // 'L' para horizontal
$pdf->SetMargins(10, 10, 10); // Márgenes (izquierda, arriba, derecha)
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Comprobar si hay resultados
if ($resultados) {
    // Mostrar encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $headers = ['ID', utf8_decode('N° Inventario'), 'Especie', 'Estado', utf8_decode('Ingreso'), 'Cantidad', utf8_decode('Clasificación')];

    // Anchos de las columnas
    $widths = [20, 50, 60, 40, 35, 30, 42]; // Anchos de las columnas 

    // Mostrar encabezados
    foreach ($headers as $index => $header) {
        $pdf->Cell($widths[$index], 10, $header, 1, 0, 'C'); // Centrar el texto
    }
    $pdf->Ln();

    // Mostrar filas
    $pdf->SetFont('Arial', '', 12);
    foreach ($resultados as $fila) {
        $pdf->Cell($widths[0], 10, $fila['idPieza'], 1);
        $pdf->Cell($widths[1], 10, $fila['num_inventario'], 1);
        $pdf->Cell($widths[2], 10, utf8_decode($fila['especie']), 1);
        $pdf->Cell($widths[3], 10, $fila['estado_conservacion'], 1);
        $pdf->Cell($widths[4], 10, $fila['fecha_ingreso'], 1);
        $pdf->Cell($widths[5], 10, $fila['cantidad_de_piezas'], 1);
        $pdf->Cell($widths[6], 10, utf8_decode($fila['clasificacion']), 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, "No se encontraron registros en la tabla de piezas.", 0, 1, 'C');
}

// Salida del PDF
$pdf->Output('I', 'detalles_pieza.pdf');
?>
