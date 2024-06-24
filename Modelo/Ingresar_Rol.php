<?php
require_once '../Config/config.php'; // Asegúrate de que este archivo contiene las variables de configuración necesarias

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreRol = $_POST['nombreRol'];

    // Crear la conexión
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar la conexión
    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = "Conexión fallida: " . $conn->connect_error;
    } else {
        // Preparar y vincular la consulta para prevenir inyección SQL
        $stmt = $conn->prepare("INSERT INTO roles (Nombre_Rol) VALUES (?)");
        $stmt->bind_param("s", $nombreRol);

        // Ejecutar la consulta
        if ($stmt->execute() === TRUE) {
            $response['status'] = 'success';
            $response['message'] = "Nuevo rol agregado exitosamente";
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error al agregar el nuevo rol: " . $stmt->error;
        }

        // Cerrar la conexión
        $stmt->close();
        $conn->close();
    }

    // Devolver la respuesta JSON al cliente
    echo json_encode($response);
}
?>

