<?php
require_once '../Config/config.php';

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
            exit();
        }
    }


    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}


class Cobro {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerCobros() {
        try {
            $query = "SELECT * FROM cobrospeaje";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error en la consulta SQL: " . $exception->getMessage();
            return [];
        }
    } 
}

class TrabajadoresTabla {
    private $db;

    public function __construct() {
        $database = new Database1();
        $this->db = $database->getConnection();
    }
    public function obtenerEstaciones() {
        $query = "SELECT idEstacionesPeaje, Nombre FROM estacionespeaje";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTodosLosTrabajadores() {
        $query = "SELECT p.Cedula, p.Nombre, p.Primer_Apellido AS Apellido1, p.Segundo_Apellido AS Apellido2, 
                         e.Fecha_Ingreso, e.Roles_idRoles AS Rol_ID, e.SalarioBase, e.EstacionesPeaje_idEstacionesPeaje AS Estacion_ID,
                         r.Nombre_Rol AS Nombre_Rol, est.Nombre AS Nombre_Estacion,
                         e.Correo_Electronico AS Correo_Electronico, u.Contraseña AS Contrasena
                  FROM empleados e
                  LEFT JOIN persona p ON e.Persona_Cedula = p.Cedula
                  LEFT JOIN roles r ON e.Roles_idRoles = r.idRoles
                  LEFT JOIN estacionespeaje est ON e.EstacionesPeaje_idEstacionesPeaje = est.idEstacionesPeaje
                 LEFT JOIN usuarios u ON e.Persona_Cedula = u.Empleados_Persona_Cedula";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTrabajadoresPorEstacion($estacionID) {
        $query = "SELECT p.Cedula, p.Nombre, p.Primer_Apellido AS Apellido1, p.Segundo_Apellido AS Apellido2, 
                         e.Fecha_Ingreso, e.Roles_idRoles AS Rol_ID, e.SalarioBase, e.EstacionesPeaje_idEstacionesPeaje AS Estacion_ID,
                         r.Nombre_Rol AS Nombre_Rol, est.Nombre AS Nombre_Estacion,
                         e.Correo_Electronico AS Correo_Electronico
                  FROM empleados e
                  LEFT JOIN persona p ON e.Persona_Cedula = p.Cedula
                  LEFT JOIN roles r ON e.Roles_idRoles = r.idRoles
                  LEFT JOIN estacionespeaje est ON e.EstacionesPeaje_idEstacionesPeaje = est.idEstacionesPeaje
                  LEFT JOIN usuarios u ON e.Persona_Cedula = u.Empleados_Persona_Cedula
                  WHERE e.EstacionesPeaje_idEstacionesPeaje = :estacionID";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':estacionID', $estacionID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Manejo del caso en que la clave 'Contrasena' no existe
        $result = array_map(function($row) {
            if (!isset($row['Contrasena'])) {
                $row['Contrasena'] = ''; // O algún valor predeterminado
            }
            return $row;
        }, $result);
    
        return $result;
    }
    
    

    public function obtenerNombreEstacion($estacionID) {
        $estacion = new Estacion($this->db);
        $result = $estacion->obtenerEstacionPorID($estacionID);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['Nombre'];
    }

    public function obtenerTipoDeRol($rolID) {
        $rol = new Rol($this->db);
        $result = $rol->obtenerRolPorID($rolID);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['Nombre_Rol'];
    }
}
    


class Rol {
    private $conn;
    private $table_name = "roles";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerRoles() {
        $query = "SELECT idRoles, Nombre_Rol FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerRolPorID($rolID) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idRoles = :idRoles"; // Corregido aquí
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idRoles', $rolID); // Corregido aquí
        $stmt->execute();
        return $stmt;
    }
}

class Estacion {
    private $conn;
    private $table_name = "estacionespeaje";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerEstaciones() {
        $query = "SELECT idEstacionesPeaje, Nombre FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEstacionPorID($estacionID) {
        $query = "SELECT idEstacionesPeaje, Nombre FROM " . $this->table_name . " WHERE idEstacionesPeaje = :idEstacionesPeaje";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idEstacionesPeaje', $estacionID);
        $stmt->execute();
        return $stmt;
    }
}

class TrabajadoresInfo {
    private $db;
    private $estacion;
    private $rol;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
        $this->estacion = new Estacion($this->db);
        $this->rol = new Rol($this->db);
    }

    public function obtenerEstaciones() {
        return $this->estacion->obtenerEstaciones();
    }

    public function obtenerRoles() {
        return $this->rol->obtenerRoles();
    }

}

$trabajadoresInfo = new TrabajadoresInfo();

$resultEstaciones = $trabajadoresInfo->obtenerEstaciones();
$resultRoles = $trabajadoresInfo->obtenerRoles();


?>