<?php
session_start();
require_once '../Modelo/Validar_Credenciales.php'; // Asegúrate de que la ruta sea correcta

class LoginController {
    private $validarCredenciales;

    public function __construct() {
        $this->validarCredenciales = new ValidarCredenciales();
    }

    public function login($Persona_Cedula, $contrasena) {
        // Primero, obtenemos los datos del usuario usando la cédula
        $user = $this->validarCredenciales->login($Persona_Cedula);

        if ($user) {
            // Verificamos la contraseña
            $hashedPassword = $this->validarCredenciales->getHashedPassword($Persona_Cedula);
            
            // Logs para depuración
            error_log("Contraseña proporcionada: " . $contrasena);
            error_log("Contraseña hasheada: " . $hashedPassword);

            // Verificar si la contraseña está hasheada o no
            if (strpos($hashedPassword, '$2y$') === 0) {  // Indica que es un hash de bcrypt
                if (password_verify($contrasena, $hashedPassword)) {
                    $_SESSION['Persona_Cedula'] = $user['Persona_Cedula'];
                    $_SESSION['Nombre'] = $user['Nombre'];
                    $_SESSION['Nombre_Rol'] = $user['Nombre_Rol'];

                    header("Location: ../vista/Inicio.php");
                    exit();
                } else {
                    $_SESSION['error'] = "La contraseña es incorrecta.";
                    header("Location: ../vista/index.php");
                    exit();
                }
            } else {  // Contraseña no hasheada
                if ($contrasena === $hashedPassword) {
                    $_SESSION['Persona_Cedula'] = $user['Persona_Cedula'];
                    $_SESSION['Nombre'] = $user['Nombre'];
                    $_SESSION['Nombre_Rol'] = $user['Nombre_Rol'];

                    header("Location: ../vista/Inicio.php");
                    exit();
                } else {
                    $_SESSION['error'] = "La contraseña es incorrecta.";
                    header("Location: ../vista/index.php");
                    exit();
                }
            }
        } else {
            $_SESSION['error'] = "El usuario no existe.";
            header("Location: ../vista/index.php");
            exit();
        }
    }
}

// Verificamos si se envió el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $Persona_Cedula = $_POST['Persona_Cedula'];
    $contrasena = $_POST['contrasena'];

    $loginController = new LoginController();
    $loginController->login($Persona_Cedula, $contrasena);
} else {
    // Redirigir si el acceso no es por POST
    header("Location: ../vista/login.php");
    exit();
}
?>
