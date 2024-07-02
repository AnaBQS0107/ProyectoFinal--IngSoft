<?php
require('../fpdf/fpdf.php');
require('../Modelo/ReporteCobradoporEstacion.php'); // Asegúrate de incluir el archivo correcto que realiza la consulta y obtiene los resultados

// Verificar si $resultados está definido y es un array u objeto válido
if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    // Limpiar el búfer de salida
    ob_clean();

    // Iniciar el objeto PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Configurar la fuente y tamaño para el título
    $pdf->Image('../img/icono.png', 10, 10, 15);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Monto Total Cobrado por Estacion', 0, 1, 'C');

    $pdf->Ln(10);
    // Encabezados de tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80, 10, 'Estacion de Peaje', 1);
    $pdf->Cell(80, 10, 'Monto Total Cobrado', 1, 1);

    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 10);
    foreach ($resultados as $row) {
        $pdf->Cell(80, 10, $row['Nombre'], 1);
        $pdf->Cell(80, 10, '$ ' . number_format($row['MontoTotalCobrado'], 2), 1, 1, 'R');
    }

    // Nombre del archivo para descarga
    $fileName = 'reporte_monto_total_cobrado_por_estacion.pdf';

    // Generar el archivo PDF para descarga
    $pdf->Output('D', $fileName);
} else {
    // Manejar el caso donde $resultados no está definido o es nulo
    echo "No se encontraron resultados válidos para generar el PDF.";
}
?>
