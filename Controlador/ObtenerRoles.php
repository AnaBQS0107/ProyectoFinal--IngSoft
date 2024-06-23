<?php
require_once '../Config/config.php';

class RolesController {

    protected $db;

    public function __construct() {
        // Establecer la conexión a la base de datos
        try {
            $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit; // Detener la ejecución si hay un error de conexión
        }
    }

    public function obtenerRoles() {
        try {
            $query = "SELECT idRoles, Nombre_Rol FROM roles";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $roles;
        } catch (PDOException $e) {
            echo "Error al obtener roles: " . $e->getMessage();
            return [];
        }
    }
}

// Ejemplo de uso del controlador
$controller = new RolesController();
$roles = $controller->obtenerRoles();
?>
