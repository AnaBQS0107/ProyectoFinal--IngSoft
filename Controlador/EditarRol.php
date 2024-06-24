<?php
require_once '../Config/config.php'; // Asegúrate de que este archivo contiene las variables de configuración necesarias

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['idRol']) && isset($_GET['nuevoNombre'])) {
    $idRol = $_GET['idRol'];
    $nuevoNombre = $_GET['nuevoNombre'];

    $database = new Database1();
    $conn = $database->getConnection();

    try {
        // Actualiza el nombre del rol en la base de datos
        $query = "UPDATE roles SET Nombre_Rol = :nombreRol WHERE idRoles = :idRol";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombreRol', $nuevoNombre);
        $stmt->bindParam(':idRol', $idRol);
        $stmt->execute();

        echo "success"; // Devuelve 'success' si se actualizó correctamente
    } catch (PDOException $exception) {
        echo "Error al actualizar el rol: " . $exception->getMessage();
    }
} else {
    echo "Solicitud de actualización inválida.";
}
?>
