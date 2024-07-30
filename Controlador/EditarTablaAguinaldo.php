<?php
require_once '../Config/config.php';

if (isset($_POST['cedula']) && isset($_POST['fecha']) && isset($_POST['monto'])) {
    $cedula = $_POST['cedula'];
    $fecha = $_POST['fecha'];
    $monto = $_POST['monto'];

    try {
        $conn = getConnection();
        $sql = "UPDATE aguinaldo SET Meses = :fecha, Monto_A_Pagar = :monto WHERE Empleados_Persona_Cedula1 = :cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':monto', $monto, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos no proporcionados']);
}
?>
