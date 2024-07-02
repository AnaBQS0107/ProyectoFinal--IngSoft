<?php
require_once '../Config/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['idRol']) && isset($_GET['nuevoNombre'])) {
    $idRol = $_GET['idRol'];
    $nuevoNombre = $_GET['nuevoNombre'];

    $database = new Database1();
    $conn = $database->getConnection();

    try {
        $query = "UPDATE roles SET Nombre_Rol = :nombreRol WHERE idRoles = :idRol";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombreRol', $nuevoNombre);
        $stmt->bindParam(':idRol', $idRol);
        $stmt->execute();

        echo "success"; 
    } catch (PDOException $exception) {
        echo "Error al actualizar el rol: " . $exception->getMessage();
    }
} else {
    echo "Solicitud de actualización inválida.";
}
?>
