<?php
session_start();
if (!isset($_SESSION['usuario_activo'])) {
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../../index.php");
    exit;
}
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";
require_once '../../fpdf/fpdf.php'; // Asegúrate de que FPDF esté en la ubicación correcta

class PDF extends FPDF {
    // Encabezado
    function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Detalles de la Pieza', 0, 1, 'C');
        $this->Ln(5); // Salto de línea
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idPieza = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($idPieza > 0) {
        $detalles = new Pieza();
        $resultado = $detalles->getTablasRelacionadasConPieza($idPieza);

        // Inicializar el array $resultados
        $resultados = [];

        // Agregar los resultados según las tablas
        $tablas = ['paleontologia', 'osteologia', 'ictiologia', 'geologia', 'botanica', 'zoologia', 'arqueologia', 'octologia'];
        foreach ($tablas as $tabla) {
            if (isset($resultado[$tabla]) && !empty($resultado[$tabla])) {
                $resultados[$tabla] = $resultado[$tabla];
            }
        }
    } else {
        echo "ID de pieza no válido.";
        exit;
    }

    // Crear PDF con FPDF
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Ln(10); // Salto de línea

    if (!empty($resultados)) {
        foreach ($resultados as $tabla => $filas) {
            // Mostrar el título
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, "Asociada a la tabla: ".ucfirst($tabla), 0, 1, 'L');
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Ln(5); // Salto de línea

            // Mostrar cada fila como subtítulo con sus valores
            foreach ($filas as $fila) {
                foreach ($fila as $campo => $valor) {
                    // Subtítulo con el nombre del campo
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(0, 10, ucfirst(str_replace('_', ' ', $campo)), 0, 1, 'L');
                    // Valor debajo del subtítulo
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->MultiCell(0, 10, htmlspecialchars($valor), 0, 'L');
                    $pdf->Ln(2); // Espacio entre cada campo
                }
                $pdf->Ln(5); // Salto de línea al final de cada fila
            }
            $pdf->Ln(10); // Espacio entre tablas
        }
    } else {
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(0, 10, "No se encontraron resultados relacionados con la pieza.", 0, 1, 'C');
    }

    // Salida del PDF
    $pdf->Output('I', 'detalle_pieza.pdf');
} else {
    echo "Método de solicitud no válido.";
}
?>
