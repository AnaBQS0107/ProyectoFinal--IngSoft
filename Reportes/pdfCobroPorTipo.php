<?php
require('../fpdf/fpdf.php');

// Incluir el archivo donde se realiza la consulta y se obtienen los resultados
require('../Modelo/ReporteCobradoporTipo.php');

// Verificar si $resultados está definido y es un array u objeto válido
if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    // Limpiar el búfer de salida
    ob_clean();

    $pdf = new FPDF();
    $pdf->AddPage();

    // Definir el título con el ícono
    $pdf->Image('../img/icono.png', 10, 10, 15);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 15, 'Monto Total Cobrado por Tipo de Vehiculo', 0, 1, 'C');

    // Agregar espacio antes de la tabla
    $pdf->Ln(10);

    // Establecer la fuente y tamaño para la tabla
    $pdf->SetFont('Arial', 'B', 12);

    // Encabezados de la tabla
    $pdf->Cell(80, 10, 'Tipo de Vehiculo', 1, 0, 'C');
    $pdf->Cell(80, 10, 'Monto Total Cobrado', 1, 1, 'C');

    // Datos de la tabla
    $pdf->SetFont('Arial', '', 12);
    foreach ($resultados as $row) {
        $pdf->Cell(80, 10, $row['TipoVehiculo'], 1, 0, 'L');
        $pdf->Cell(80, 10, '$ ' . number_format($row['MontoTotalCobrado'], 2), 1, 1, 'R');
    }

    // Nombre del archivo PDF para descarga
    $fileName = 'reporte_monto_total_cobrado_por_tipo_vehiculo.pdf';

    // Generar el archivo PDF para descarga
    $pdf->Output('D', $fileName);
} else {
    // Manejar el caso donde $resultados no está definido o es nulo
    echo "No se encontraron resultados válidos para generar el PDF.";
}
?>
