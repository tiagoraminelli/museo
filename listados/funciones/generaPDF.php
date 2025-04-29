<?php
session_start();
if (!isset($_SESSION['usuario_activo'])) {
    header("Location: ../../index.php");
    exit;
}

// Limpiar buffer de salida para evitar el error fatal
if (ob_get_length()) ob_clean();

require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";
require_once '../../fpdf/fpdf.php';

class PDF extends FPDF {
    private $headerTitle = 'Detalles de la Pieza';
    private $footerText = 'Sistema de Gestión de Colecciones - Página ';
    
    function Header() {
        // Configurar UTF-8
        $this->SetFont('Arial', 'B', 16);
        
        // Logo (con márgenes ajustados)
        $logoPath = $_SERVER['DOCUMENT_ROOT'].'/proyectoMuseo/assets/img/escuela-logo.png';
        if(file_exists($logoPath)) {
            try {
                // Ajustar posición y tamaño para evitar superposición
                $this->Image($logoPath, 160, 6, 30);
            } catch(Exception $e) {}
        } 
        
        // Título del encabezado (centrado con espacio para el logo)
        $this->SetTextColor(40, 40, 40);
        $this->Cell(0, 40, utf8_decode($this->headerTitle), 0, 1, 'C');
        
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 10, utf8_decode($this->footerText) . $this->PageNo(), 0, 0, 'C');
    }
    
    function InfoGeneral($data) {
        if(empty($data)) {
            $this->SetFont('Arial', 'I', 12);
            $this->Cell(0, 10, utf8_decode('No se encontró información general de la pieza'), 0, 1);
            $this->Ln(10);
            return;
        }
        
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(79, 129, 189);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 11, utf8_decode('  Información General de la Pieza'), 0, 1, 'L', true);
        $this->Ln(5);
        
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(60, 60, 60);
        
        $campos = [
            'idPieza' => 'ID de Pieza',
            'num_inventario' => 'Número de Inventario',
            'especie' => 'Especie',
            'estado_conservacion' => 'Estado de Conservación',
            'fecha_ingreso' => 'Fecha de Ingreso',
            'cantidad_de_piezas' => 'Cantidad',
            'clasificacion' => 'Clasificación',
            'observacion' => 'Observación',
        ];
        
        foreach ($campos as $key => $label) {
            if(isset($data[$key])) {
                $this->SetFont('', 'B');
                $this->Cell(55, 8, utf8_decode($label.':'));
                $this->SetFont('', '');
                if($key == 'descripcion') {
                    $this->MultiCell(0, 8, utf8_decode($data[$key]), 0, 'L');
                } else {
                    $this->Cell(0, 8, utf8_decode($data[$key]), 0, 1);
                }
            }
        }
        $this->Ln(10);
    }
    
    function TableSection($title, $data) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(230, 230, 250);
        $this->SetTextColor(40, 40, 100);
        $this->Cell(0, 10, "  " . utf8_decode(ucfirst($title)), 0, 1, 'L', true);
        $this->Ln(4);
        
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(60, 60, 60);
        
        foreach ($data as $fila) {
            foreach ($fila as $campo => $valor) {
                $this->SetFont('', 'B');
                $this->Cell(55, 10, utf8_decode(ucfirst(str_replace('_', ' ', $campo)).':'));
                $this->SetFont('', '');
                $this->MultiCell(0, 8, utf8_decode($valor));
                $this->SetDrawColor(220, 220, 220);
                $this->Line($this->GetX(), $this->GetY(), $this->GetX()+190, $this->GetY());
                $this->Ln(2);
            }
            $this->Ln(5);
        }
        $this->Ln(8);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idPieza = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($idPieza > 0) {
        $detalles = new Pieza();
        $infoGeneral = $detalles->getPiezaById($idPieza);
        $resultado = $detalles->getTablasRelacionadasConPieza($idPieza);

        $resultados = [];
        $tablas = ['paleontologia', 'osteologia', 'ictiologia', 'geologia', 'botanica', 'zoologia', 'arqueologia', 'octologia'];
        
        foreach ($tablas as $tabla) {
            if (isset($resultado[$tabla]) && !empty($resultado[$tabla])) {
                $resultados[$tabla] = $resultado[$tabla];
            }
        }

        // Crear PDF con codificación UTF-8
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);
        
        // Mostrar información general
        $pdf->InfoGeneral($infoGeneral);
        
        // Mostrar información de tablas relacionadas
        if (!empty($resultados)) {
            foreach ($resultados as $tabla => $filas) {
                $pdf->TableSection($tabla, $filas);
            }
        } else {
            $pdf->SetFont('Arial', 'I', 12);
            $pdf->SetTextColor(150, 50, 50);
            $pdf->Cell(0, 10, utf8_decode("No se encontraron resultados relacionados con la pieza."), 0, 1, 'C');
        }

        // Salida del PDF
        $pdf->Output('I', 'detalle_pieza_' . $idPieza . '.pdf');
        exit;
    } else {
        die("ID de pieza no válido.");
    }
} else {
    die("Método de solicitud no válido.");
}
?>