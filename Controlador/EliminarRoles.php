<?php
require_once '../Config/config.php'; 

if (isset($_GET['idRoles'])) {
    $idRoles = $_GET['idRoles'];

    $database = new Database1();
    $conn = $database->getConnection();

    try {
        $query_roles = "DELETE FROM roles WHERE idRoles = :idRoles";
        $stmt_roles = $conn->prepare($query_roles);
        $stmt_roles->bindParam(':idRoles', $idRoles);
        $stmt_roles->execute();

        echo "success"; 
    } catch (PDOException $exception) {
        echo "Error al eliminar el rol: " . $exception->getMessage();
    }
} else {
    echo "Solicitud de ID de Rol inválida.";
}
?>
