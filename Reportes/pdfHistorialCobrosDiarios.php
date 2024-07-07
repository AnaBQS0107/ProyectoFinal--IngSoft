<?php
require('../fpdf/fpdf.php');
require_once '../Modelo/HistorialCobrosDiarios.php';

class PDF extends FPDF {

    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Historial de Cobros Diarios', 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(40, 10, 'Fecha', 1);
        $this->Cell(60, 10, 'Estacion de Peaje', 1);
        $this->Cell(60, 10, 'Tipo de Vehiculo', 1);
        $this->Cell(40, 10, 'Monto Cobrado', 1);
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}


$pdf = new PDF();
$pdf->AddPage();
$pdf->Image('../img/icono.png', 10, 10, 15);
$pdf->SetFont('Arial', '', 10);

$resultados = obtenerHistorialCobrosDiarios();

if (!empty($resultados)) {
    foreach ($resultados as $row) {
        $pdf->Cell(40, 10, $row['Fecha'], 1);
        $pdf->Cell(60, 10, utf8_decode($row['Estacion']), 1);
        $pdf->Cell(60, 10, utf8_decode($row['TipoVehiculo']), 1);
        $pdf->Cell(40, 10, '$ ' . number_format($row['MontoCobrado'], 2), 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No se encontraron resultados para generar el historial de cobros diarios.', 1, 1, 'C');
}

$pdf->Output('D', 'Historial_Cobros_Diarios.pdf');
?>
