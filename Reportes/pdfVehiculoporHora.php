<?php
require('../fpdf/fpdf.php');
require_once '../Modelo/ReporteHora.php'; // Incluye el modelo que creamos anteriormente

// Instancia del modelo para obtener los datos
$modelo = new CantidadVehiculosPorHoraModelo();
$resultados = $modelo->obtenerCantidadVehiculosPorHora();

if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    ob_clean();

    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->Image('../img/icono.png', 10, 10, 15);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Cantidad de Vehiculos por Hora del Dia', 0, 1, 'C');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80, 10, 'Hora del Dia', 1);
    $pdf->Cell(80, 10, 'Cantidad de Vehículos', 1, 1);

    $pdf->SetFont('Arial', '', 10);
    foreach ($resultados as $row) {
        $pdf->Cell(80, 10, $row['HoraDelDia'], 1);
        $pdf->Cell(80, 10, $row['CantidadVehiculos'], 1, 1, 'R');
    }

    $fileName = 'reporte_cantidad_vehiculos_por_hora.pdf';
    $pdf->Output('D', $fileName);
} else {
    // Manejar el caso donde $resultados no está definido o es nulo
    echo "No se encontraron resultados válidos para generar el PDF.";
}
?>
