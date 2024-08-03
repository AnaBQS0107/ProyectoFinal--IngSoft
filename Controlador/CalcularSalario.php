<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
    
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
$cedula = $user['Persona_Cedula'];

// Configurar la conexión a la base de datos
require_once '../Config/config.php'; // Asegúrate de que la conexión a la base de datos está configurada correctamente
require_once 'Controlador.php';
require_once '../Modelo/CalcularSalario.php';

//use App\Controller; // llama a la herencia controller//
//use App\Modelo\CalcularSalario;  // esto conecta con la carpeta modelo de calcular salario//


class CalcularSalarioControlador extends Controller  //herencia controller//
{
    public function index()
    {
        try {
            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit();
        }
        
        try {
            $stmt = $conn->prepare("SELECT SalarioBase FROM empleados WHERE Persona_Cedula = :cedula"); 
             // consulta de base de datos de lo que ocupamos para la formula de salario//
            $stmt->bindParam(':cedula', $cedula, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $salario_base = $result['SalarioBase'] ?? 0;// respuesta base de datos//

        } catch(PDOException $e) {
            echo "Error al obtener los datos del empleado: " . $e->getMessage();
            
        }

        $modelo_salario = new CalcularSalario($cedula, $salario_base, null, null, null, null);

        $this->render('CalcularSalario', ['modelo_salario' => $modelo_salario]); //eso llamar a vista y a data del controller//

    }

    public function Calcular()
    {

    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $controlador = new CalcularSalarioControlador();
    $controlador->index();
}