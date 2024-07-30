<?php
require_once '../Config/config.php';

if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

    try {
        $conn = getConnection();
        $sql = "DELETE FROM aguinaldo WHERE Empleados_Persona_Cedula1 = :cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);

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
    echo json_encode(['status' => 'error', 'message' => 'Cédula no proporcionada']);
}
?>