<?php
require_once '../Config/config.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreRol = $_POST['nombreRol'];

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = "Conexión fallida: " . $conn->connect_error;
    } else {
        
        $stmt = $conn->prepare("INSERT INTO roles (Nombre_Rol) VALUES (?)");
        $stmt->bind_param("s", $nombreRol);

        if ($stmt->execute() === TRUE) {
            $response['status'] = 'success';
            $response['message'] = "Nuevo rol agregado exitosamente";
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error al agregar el nuevo rol: " . $stmt->error;
        }


        $stmt->close();
        $conn->close();
    }

    echo json_encode($response);
}
?>

