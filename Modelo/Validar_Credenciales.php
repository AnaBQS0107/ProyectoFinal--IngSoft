<?php
class ValidarCredenciales {
    private $conn;

    public function __construct() {
        $host = "localhost:3307";
        $db_name = "servicio_autobuses";
        $username = "root";
        $password = "";
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function login($Persona_Cedula, $contrasena) {
        $sql = "SELECT p.Nombre, r.Nombre_Rol, u.Contraseña, p.Cedula AS Persona_Cedula 
                FROM usuarios u
                JOIN empleados e ON u.Empleados_Persona_Cedula = e.Persona_Cedula
                JOIN persona p ON e.Persona_Cedula = p.Cedula
                JOIN roles r ON e.Roles_idRoles = r.idRoles
                WHERE p.Cedula = :Persona_Cedula";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':Persona_Cedula', $Persona_Cedula);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            return $user; // Retornar todos los datos del usuario
        } else {
            // Usuario no encontrado
            error_log("No se encontró ningún usuario con la cédula: " . $Persona_Cedula);
            return false;
        }
    }
    

    // Método para obtener la contraseña hasheada
    public function getHashedPassword($Persona_Cedula) {
        $sql = "SELECT Contraseña FROM usuarios WHERE Empleados_Persona_Cedula = :Persona_Cedula";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':Persona_Cedula', $Persona_Cedula);
        $stmt->execute();
        $hashedPassword = $stmt->fetchColumn();
        
        return $hashedPassword;
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
