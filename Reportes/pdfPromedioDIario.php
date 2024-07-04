<?php
require('../fpdf/fpdf.php');
require_once '../Modelo/ReportePromedioDiario.php';

$modelo = new PromedioDiarioVehiculosModelo();
$resultados = $modelo->obtenerDatosPromedioDiario();

if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    ob_clean();

    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->Image('../img/icono.png', 10, 10, 15);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Promedio Diario de Vehiculos por Estacion', 0, 1, 'C');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80, 10, 'Estacion de Peaje', 1);
    $pdf->Cell(80, 10, 'Promedio Diario de Vehiculos (%)', 1, 1);

    $pdf->SetFont('Arial', '', 10);
    foreach ($resultados as $row) {
        $pdf->Cell(80, 10, $row['EstacionPeaje'], 1);
        $pdf->Cell(80, 10, $row['PromedioDiarioVehiculos'] . ' %', 1, 1, 'R');
    }

    $fileName = 'reporte_promedio_diario_vehiculos_por_estacion.pdf';
    $pdf->Output('D', $fileName);
} else {
 
    echo "No se encontraron resultados válidos para generar el PDF.";
}
?>
