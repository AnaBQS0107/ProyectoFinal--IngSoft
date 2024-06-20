<?php

session_start(); 

require_once '../Modelo/Validar_Credenciales.php';

class AuthController {
    private $ValidarCredenciales;

    public function __construct() {
        $this->ValidarCredenciales = new ValidarCredenciales();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Persona_Cedula'], $_POST['contrasena'])) {
            $Persona_Cedula = $_POST['Persona_Cedula'];
            $contrasena = $_POST['contrasena'];

            $user = $this->ValidarCredenciales->login($Persona_Cedula, $contrasena);

            if ($user) {
                $_SESSION['user'] = [
                    'Nombre' => $user['Nombre'],
                    'Nombre_Rol' => $user['Nombre_Rol']
                ];

                header("Location: ../Vista/Inicio.php");
                exit();
            } else {
                echo "Credenciales inválidas. Acceso denegado.";
            }
        } else {
            echo "Error: No se recibieron los datos del formulario.";
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
