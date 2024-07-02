<?php
require('../fpdf/fpdf.php');

// Incluir el archivo donde se realiza la consulta y se obtienen los resultados
require_once '../Modelo/MontoTotalporMES.php';

// Verificar si $resultados está definido y es un array u objeto válido
if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    // Limpiar el búfer de salida
    ob_clean();

    // Configurar PDF
    $pdf = new FPDF();
    $pdf->AddPage(); // Añadir una página al PDF
    $pdf->Image('../img/icono.png', 10, 10, 15);

    // Título centrado
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Monto Total Recaudado por Mes', 0, 1, 'C');
    $pdf->Ln(10); // Espacio adicional después del título

    // Calculamos la posición para centrar la tabla
    $marginLeft = 10; // Margen izquierdo
    $marginTop = $pdf->GetY(); // Posición actual en Y después del título y espacio

    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, 'Mes', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Monto Total', 1, 1, 'C');

    // Datos de la tabla
    $pdf->SetFont('Arial', '', 12);
    foreach ($resultados as $row) {
        $pdf->Cell(50, 10, $row['Mes'], 1, 0, 'C');
        $pdf->Cell(50, 10, '$ ' . number_format($row['MontoTotal'], 2), 1, 1, 'C');
    }

    // Calcular posición para centrar la tabla horizontalmente
    $pdf->SetXY(($pdf->GetPageWidth() - $marginLeft) / 2 - 50, $marginTop);

    // Nombre del archivo para descarga
    $fileName = 'reporte_monto_total_recaudado_por_mes.pdf';

    // Generar el archivo PDF para descarga
    $pdf->Output('D', $fileName);
} else {
    // Manejar el caso donde $resultados no está definido o no es válido
    echo "No se encontraron resultados válidos para generar el PDF.";
}
?>
