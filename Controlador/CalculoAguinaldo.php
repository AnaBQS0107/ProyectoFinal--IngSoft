<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Config/config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salarios = isset($_POST['salarios']) ? $_POST['salarios'] : [];
    $Empleados_Persona_Cedula = htmlspecialchars($_SESSION['user']['Persona_Cedula']);
    $salarioEspecie = isset($_POST['salarioEspecie']) ? $_POST['salarioEspecie'] : '0';
    $porcentajeEspecie = isset($_POST['PorcentajeEspecie']) ? $_POST['PorcentajeEspecie'] : 0;
    $montoMensualEspecie = isset($_POST['MontoMensualEspecie']) ? $_POST['MontoMensualEspecie'] : 0;

    try {
        $db = Database1::getInstance()->getConnection();
        $totalSalarios = 0;

        foreach ($salarios as $salario) {
            $totalSalarios += floatval(str_replace(',', '', $salario));
        }

        if ($salarioEspecie == '1') {
            $totalSalarios += $totalSalarios * ($porcentajeEspecie / 100);
        } elseif ($salarioEspecie == '2') {
            $totalSalarios += $montoMensualEspecie * 12 / 12;
        }

        $aguinaldo = $totalSalarios / 12;

        // Guardar el aguinaldo en la sesión en lugar de la base de datos
        $_SESSION['aguinaldo_calculado'] = $aguinaldo;

        $response['success'] = true;
        $response['message'] = 'Aguinaldo calculado exitosamente.';
        $response['aguinaldo'] = number_format($aguinaldo, 2);

    } catch (Exception $e) {
        $response['message'] = 'Error al calcular el aguinaldo: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Método no permitido.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>