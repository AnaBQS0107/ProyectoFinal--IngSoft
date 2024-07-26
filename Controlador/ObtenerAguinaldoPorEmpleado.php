<?php
require_once '../Config/config.php';

header('Content-Type: application/json');

try {
    $conn = getConnection();
    $cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';

    if ($cedula) {
        $sql = "SELECT * FROM aguinaldo WHERE Empleados_Persona_Cedula1 = :cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $cedula);
    } else {
        $sql = "SELECT * FROM aguinaldo";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch (PDOException $e) {
    echo json_encode([]);
} finally {
    $conn = null;
}