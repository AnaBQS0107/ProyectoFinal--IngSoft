<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Modelo/Validar_Credenciales.php';

class AuthController {
    private $validarCredenciales;

    public function __construct() {
        $this->validarCredenciales = new ValidarCredenciales();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Persona_Cedula'], $_POST['contrasena'])) {
            $Persona_Cedula = $_POST['Persona_Cedula'];
            $contrasena = $_POST['contrasena'];
    
            $user = $this->validarCredenciales->login($Persona_Cedula, $contrasena);
    
            if ($user) {
                // Usuario encontrado
                if ($contrasena === '1234') {
                    // Redirigir a la página de cambio de contraseña
                    $_SESSION['user'] = [
                        'Nombre' => $user['Nombre'],
                        'Nombre_Rol' => $user['Nombre_Rol'],
                        'Persona_Cedula' => $user['Persona_Cedula']
                    ];
                    header("Location: ../Vista/cambiar_contrasena.php");
                    exit();
                } else {
                    // Contraseña válida, iniciar sesión normalmente
                    $_SESSION['user'] = [
                        'Nombre' => $user['Nombre'],
                        'Nombre_Rol' => $user['Nombre_Rol'],
                        'Persona_Cedula' => $user['Persona_Cedula']
                    ];
                    header("Location: ../Vista/Inicio.php");
                    exit();
                }
            } else {
                // Contraseña incorrecta o usuario no encontrado
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
