<?php
require('../fpdf/fpdf.php');
require_once '../Modelo/ReporteCantidadporTipoyEstacion.php';

class PDF extends FPDF {

    function Header() {
        $this->SetFont('Arial', 'B', 12);
      
        $this->Cell(0, 10, 'Reporte - Cantidad de Vehiculos por Tipo y Estacion', 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 10, 'Estacion de Peaje', 1);
        $this->Cell(60, 10, 'Tipo de Vehículo', 1);
        $this->Cell(60, 10, 'Cantidad de Vehiculos', 1);
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

$resultados = obtenerCantidadVehiculosPorTipoYEstacion();

if (!empty($resultados)) {
    foreach ($resultados as $row) {
        $pdf->Cell(60, 10, utf8_decode($row['Estacion']), 1);
        $pdf->Cell(60, 10, utf8_decode($row['TipoVehiculo']), 1);
        $pdf->Cell(60, 10, $row['CantidadVehiculos'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No se encontraron resultados para generar el reporte.', 1, 1, 'C');
}

$pdf->Output('D', 'Reporte_Cantidad_Vehiculos.pdf');
?>
