<?php
require('fpdf.php');
require('../modelo/bd.php'); // Ajusta la ruta a donde está realmente tu archivo 'bd.php'
require('../modelo/alumno-materia.php'); // Ajusta la ruta a donde está realmente tu archivo 'alumno-materia.php');

// Verificar si se recibieron los parámetros por POST
if (isset($_POST['dni']) && isset($_POST['año'])) {
    $dni = $_POST['dni'];
    $año = $_POST['año'];
}

// Clase extendida para personalizar el PDF
class PDF extends FPDF
{
    private $background;

    // Método para configurar la imagen de fondo
    function setBackground($img)
    {
        $this->background = $img;
    }

    // Encabezado del PDF
    function Header()
    {
        // Agregar imagen de fondo si está configurada
        if ($this->background) {
            $this->Image($this->background, 0, 0, $this->GetPageWidth(), $this->GetPageHeight());
        }
    
        // Configuración del encabezado con datos de la escuela
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(33, 37, 41); // Un gris oscuro

        // Título de la institución
        $this->SetXY(10, 15);
        $this->Cell(0, 10, 'Escuela Normal Superior N40 Mariano Moreno', 0, 1, 'L');

        // Subtítulo
        $this->SetFont('Arial', '', 12);
        $this->SetXY(10, 25);
        $this->Cell(0, 10, utf8_decode('Dirección: J.M. Bullo 1402 - C.P. 3070'), 0, 1, 'L');
        $this->SetXY(10, 30);
        $this->Cell(0, 10, 'Tel: 03408-422447 | Email: esc40mmoreno@yahoo.com.ar', 0, 1, 'L');

        // Línea divisoria
        $this->Ln(10);
        $this->SetLineWidth(0.8);
        $this->Line(10, 45, 200, 45); // Línea de separación
        $this->Ln(5);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-30);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Firma del Director: ___________________________', 0, 1, 'L');
        $this->Cell(0, 10, 'Firma del Coordinador: _______________________', 0, 0, 'L');

        // Número de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    // Generar tabla con datos
    function TablaDatos($header, $data)
    {
        // Configuración de colores y estilos para la tabla
        $this->SetFillColor(224, 224, 224); // Color de relleno para encabezados
        $this->SetTextColor(33, 37, 41); // Color de texto gris oscuro
        $this->SetDrawColor(128, 128, 128); // Color de borde gris
        $this->SetLineWidth(0.3);

        // Encabezados de la tabla
        $this->SetFont('Arial', 'B', 12);
        $columnWidths = array(80, 30, 25, 40); // Anchos de columnas ajustados

        // Centrar la tabla
        $this->SetX(($this->GetPageWidth() - array_sum($columnWidths)) / 2);

        foreach ($header as $index => $colName) {
            $this->Cell($columnWidths[$index], 7, utf8_decode($colName), 1, 0, 'C', true);
        }
        $this->Ln();

        // Datos de la tabla
        $this->SetFont('Arial', '', 10);
        $fill = false; // Alternar color de fondo

        foreach ($data as $row) {
            // Centrar las filas también
            $this->SetX(($this->GetPageWidth() - array_sum($columnWidths)) / 2);

            // Alternar los colores de fondo en gris claro
            if ($fill) {
                $this->SetFillColor(240, 240, 240); // Gris claro
            } else {
                $this->SetFillColor(255, 255, 255); // Blanco
            }

            $this->Cell($columnWidths[0], 6, utf8_decode($row['nombre']), 'LR', 0, 'L', true);
            $this->Cell($columnWidths[1], 6, utf8_decode($row['anioCursado']), 'LR', 0, 'C', true);
            $this->Cell($columnWidths[2], 6, utf8_decode($row['nota']), 'LR', 0, 'C', true);
            $this->Cell($columnWidths[3], 6, utf8_decode($row['estado_final']), 'LR', 0, 'L', true);
            $this->Ln();
            $fill = !$fill; // Alternar color de fondo para la siguiente fila
        }

        // Línea de cierre de tabla
        $this->SetX(($this->GetPageWidth() - array_sum($columnWidths)) / 2);
        $this->Cell(array_sum($columnWidths), 0, '', 'T');
    }
}

// Datos para el encabezado de la tabla
$header = array('Nombre', 'Año Cursado', 'Nota', 'Estado Final');

// Instancia del modelo para obtener datos
$alumnoCarrera = new AlumnoCarrera();
$data = $alumnoCarrera->fetchAlumnosInscriptosAñoDni($año, $dni);

// Crear instancia del PDF y generar el documento
$pdf = new PDF();
$pdf->setBackground('C:\xampp\htdocs\libreta\public\FW3.jpg'); // Configurar la imagen de fondo
$pdf->AddPage();
$pdf->TablaDatos($header, $data);
$pdf->Output('I', 'Libreta.pdf');
?>
