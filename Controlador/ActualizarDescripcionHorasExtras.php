<?php
require_once '../Config/config.php';
header('Content-Type: application/json');

$response = array('error' => true, 'message' => 'Unknown error occurred');

$db = Database1::getInstance(); // Obtener la instancia de la clase Database1
$conn = $db->getConnection(); // Obtener la conexión PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $description = $_POST['description'] ?? null;

    if ($id && $description) {
        try {
            $query = "UPDATE extras SET Descripcion = :descripcion WHERE idExtras = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':descripcion', $description);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $response['error'] = false;
                $response['message'] = 'Descripción actualizada correctamente';
            } else {
                $response['message'] = 'Error al ejecutar la actualización';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error de ejecución: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Datos incompletos';
    }
} else {
    $response['message'] = 'Método no permitido';
}

echo json_encode($response);
?>