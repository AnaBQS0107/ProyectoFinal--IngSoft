<?php
require_once '../Config/config.php';

class ValidarCredenciales {
    private $db;

    public function __construct() {
        $database = new Database1();
        $this->db = $database->getConnection();
    }

    function login($Persona_Cedula, $contrasena) {
        try {
            error_log("Executing login with Cedula: $Persona_Cedula and Contraseña: $contrasena");

            $stmt = $this->db->prepare("
                SELECT p.Nombre AS Nombre, r.Nombre_Rol AS Nombre_Rol, p.Cedula AS Persona_Cedula
                FROM Empleados e 
                INNER JOIN persona p ON e.Persona_Cedula = p.Cedula 
                INNER JOIN Usuarios u ON p.Cedula = u.Empleados_Persona_Cedula 
                INNER JOIN Roles r ON e.Roles_idRoles = r.idRoles
                WHERE u.Contraseña = :contrasena AND e.Persona_Cedula = :Persona_Cedula
            ");
            $stmt->bindParam(':Persona_Cedula', $Persona_Cedula);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                error_log("Login result: " . print_r($result, true)); 
                return $result;
            } else {
                error_log("No rows found for login query."); 
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function getRoleName($idRoles) {
        try {
            $stmt = $this->db->prepare("SELECT Nombre_Rol FROM roles WHERE ID = :idRoles");
            $stmt->bindParam(':idRoles', $idRoles);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC)['Nombre_Rol'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getPersonaCedula($usuario_id) {
        try {
            $stmt = $this->db->prepare("SELECT Empleados_Persona_Cedula FROM Usuarios WHERE idUsuario = :usuario_id");
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC)['Empleados_Persona_Cedula'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getEstacionesPeaje($Nombre) {
        try {
            $stmt = $this->db->prepare("
                SELECT e.EstacionesPeaje_idEstacionesPeaje, ep.Nombre AS Nombre_Estacion, p.Nombre AS Nombre_Empleado
                FROM Empleados e
                LEFT JOIN EstacionesPeaje ep ON e.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
                INNER JOIN persona p ON e.Persona_Cedula = p.Cedula
                WHERE p.Nombre = :Nombre
            ");
            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return null; 
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
?>
