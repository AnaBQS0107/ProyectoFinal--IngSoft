<?php
require('../fpdf/fpdf.php');

// Incluir el archivo donde se realiza la consulta y se obtienen los resultados
require_once '../Modelo/MontoCobradoGeneral.php';

// Verificar si $resultadoTotal está definido y es un número válido
if (isset($resultadoTotal) && is_numeric($resultadoTotal)) {
    // Limpiar el búfer de salida
    ob_clean();

    // Configurar PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Monto Total Recaudado por los Cinco Puestos de Peaje', 0, 1, 'C');

    // Mostrar el monto total
    $pdf->Image('../img/icono.png', 10, 10, 15);
    $pdf->SetFont('Arial', '', 14);
    $pdf->Cell(0, 10, 'Monto total: $ ' . number_format($resultadoTotal, 2), 0, 1, 'C');

    // Nombre del archivo para descarga
    $fileName = 'reporte_monto_total_cinco_puestos.pdf';

    // Generar el archivo PDF para descarga
    $pdf->Output('D', $fileName);
} else {
    // Manejar el caso donde $resultadoTotal no está definido o no es válido
    echo "No se encontraron resultados válidos para generar el PDF.";
}
?>
