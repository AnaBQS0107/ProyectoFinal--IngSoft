<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Modelo/Validar_Credenciales.php';

class AuthController {
    private $Validar_Credenciales;

    public function __construct() {
        $this->Validar_Credenciales = new ValidarCredenciales();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Persona_Cedula'], $_POST['contrasena'])) {
            $Persona_Cedula = $_POST['Persona_Cedula'];
            $contrasena = $_POST['contrasena'];

            error_log("Cedula: " . $Persona_Cedula);
            error_log("Contraseña: " . $contrasena);

            $user = $this->Validar_Credenciales->login($Persona_Cedula, $contrasena);

            if ($user) {
                error_log("User found: " . print_r($user, true));

                $_SESSION['user'] = [
                    'Nombre' => $user['Nombre'],
                    'Nombre_Rol' => $user['Nombre_Rol'],
                    'Persona_Cedula' => $user['Persona_Cedula']
                ];

              
                header("Location: ../Vista/Inicio.php");
                exit();
            } else {
                $_SESSION['error'] = "Credenciales inválidas. Acceso denegado.";
                header("Location: ../Vista/Index.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Error: No se recibieron los datos del formulario.";
            header("Location: ../Vista/Index.php");
            exit();
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ../Vista/Index.php");
        exit();
    }

    public function checkSession() {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];

         
            echo "Usuario: " . htmlspecialchars($user['Nombre']) . "<br>";
            echo "Cédula: " . htmlspecialchars($user['Persona_Cedula']) . "<br>";
            echo "Rol: " . htmlspecialchars($user['Nombre_Rol']) . "<br>";
        } else {
            echo "No hay usuario conectado.";
        }
    }
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $authController = new AuthController();

    if ($action == 'login') {
        $authController->login();
    } elseif ($action == 'logout') {
        $authController->logout();
    } elseif ($action == 'checkSession') {
        $authController->checkSession();
    } else {
        echo "Acción no válida.";
    }
} else {
    echo "No se recibió ninguna acción.";
}
?>
