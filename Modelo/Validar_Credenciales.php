<?php
// Validar_Credenciales.php

require_once '../Config/config.php';

class ValidarCredenciales {
    private $db;

    public function __construct() {
        $database = new Database1();
        $this->db = $database->getConnection();
    }

    public function login($Persona_Cedula, $contrasena) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.Nombre AS Nombre, r.Nombre_Rol AS Nombre_Rol, e.Persona_Cedula AS Persona_Cedula
                FROM Empleados e 
                INNER JOIN Persona p ON e.Persona_Cedula = p.Cedula 
                INNER JOIN Usuarios u ON p.Cedula = u.Empleados_Persona_Cedula 
                INNER JOIN Roles r ON e.Roles_idRoles = r.idRoles
                WHERE u.Contraseña = :contrasena AND e.Persona_Cedula = :Persona_Cedula
            ");
            $stmt->bindParam(':Persona_Cedula', $Persona_Cedula);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
