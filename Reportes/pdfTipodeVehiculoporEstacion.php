<?php
require('../fpdf/fpdf.php');

require('../Modelo/ReporteTipodeVehiculoporPeaje.php');
if (isset($resultados) && !empty($resultados)) {
    ob_clean();

    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->Image('../img/icono.png', 10, 10, 15);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Cantidad de Vehiculos por Estacion y Tipo', 0, 1, 'C');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(60, 10, 'Estacion de Peaje', 1);
    $pdf->Cell(60, 10, 'Tipo de Vehiculo', 1);
    $pdf->Cell(60, 10, 'Cantidad de Vehiculos', 1, 1);

    $pdf->SetFont('Arial', '', 10);
    foreach ($resultados as $row) {
        $pdf->Cell(60, 10, $row['EstacionPeaje'], 1);
        $pdf->Cell(60, 10, $row['TipoVehiculo'], 1);
        $pdf->Cell(60, 10, $row['CantidadVehiculos'], 1, 1, 'R');
    }

    $fileName = 'reporte_cantidad_vehiculos_por_estacion.pdf';
    $pdf->Output('D', $fileName);
} else {
    echo "No se encontraron resultados válidos para generar el PDF.";
}
?>