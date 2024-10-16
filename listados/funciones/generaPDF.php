<?php
session_start();
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";
require_once '../../fpdf/fpdf.php'; // Asegúrate de que FPDF esté en la ubicación correcta

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idPieza = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($idPieza > 0) {
        $detalles = new Pieza();
        $resultado = $detalles->getTablasRelacionadasConPieza($idPieza);

        // Inicializar el array $resultados
        $resultados = [];

        // Paleontología
        if (isset($resultado['paleontologia']) && !empty($resultado['paleontologia'])) {
            $resultados['paleontologia'] = $resultado['paleontologia'];
        }

        // Osteología
        if (isset($resultado['osteologia']) && !empty($resultado['osteologia'])) {
            $resultados['osteologia'] = $resultado['osteologia'];
        }

        // Ictiología
        if (isset($resultado['ictiologia']) && !empty($resultado['ictiologia'])) {
            $resultados['ictiologia'] = $resultado['ictiologia'];
        }

        // Geología
        if (isset($resultado['geologia']) && !empty($resultado['geologia'])) {
            $resultados['geologia'] = $resultado['geologia'];
        }

        // Botánica
        if (isset($resultado['botanica']) && !empty($resultado['botanica'])) {
            $resultados['botanica'] = $resultado['botanica'];
        }

        // Zoología
        if (isset($resultado['zoologia']) && !empty($resultado['zoologia'])) {
            $resultados['zoologia'] = $resultado['zoologia'];
        }

        // Arqueología
        if (isset($resultado['arqueologia']) && !empty($resultado['arqueologia'])) {
            $resultados['arqueologia'] = $resultado['arqueologia'];
        }

        // Octología
        if (isset($resultado['octologia']) && !empty($resultado['octologia'])) {
            $resultados['octologia'] = $resultado['octologia'];
        }
    } else {
        echo "ID de pieza no válido.";
        exit;
    }

    // Crear PDF con FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, "Detalles de la Pieza", 0, 1, 'C');
    $pdf->Ln(10); // Salto de línea

    if (!empty($resultados)) {
        // Mostrar tablas por cada tipo de resultado
        foreach ($resultados as $tabla => $filas) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(190, 10, ucfirst($tabla), 0, 1, 'C');
            $pdf->Ln(5); // Salto de línea

            if (!empty($filas)) {
                // Mostrar encabezados dinámicos
                $pdf->SetFont('Arial', 'B', 10);
                foreach (array_keys($filas[0]) as $campo) {
                    $pdf->Cell(40, 10, ucfirst(str_replace('_', ' ', $campo)), 1);
                }
                $pdf->Ln();

                // Mostrar filas dinámicas
                $pdf->SetFont('Arial', '', 10);
                foreach ($filas as $fila) {
                    foreach ($fila as $valor) {
                        $pdf->Cell(40, 10, htmlspecialchars($valor), 1);
                    }
                    $pdf->Ln();
                }
                $pdf->Ln(10); // Salto de línea al final de cada tabla
            }
        }
    } else {
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(190, 10, "No se encontraron resultados relacionados con la pieza.", 0, 1, 'C');
    }

    // Salida del PDF
    $pdf->Output('I', 'detalle_pieza.pdf');
} else {
    echo "Método de solicitud no válido.";
}
?>
