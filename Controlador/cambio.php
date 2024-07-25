<?php
// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost:3307';
$db_name = 'servicio_autobuses';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Debe iniciar sesión para cambiar la contraseña.";
    header("Location: ../Vista/IngresarUsuario.php");
    exit();
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nueva_contrasena = isset($_POST['nueva_contrasena']) ? $_POST['nueva_contrasena'] : null;
    $confirmar_contrasena = isset($_POST['confirmar_contrasena']) ? $_POST['confirmar_contrasena'] : null;
    $persona_cedula = isset($_SESSION['user']['Persona_Cedula']) ? $_SESSION['user']['Persona_Cedula'] : null;

    // Mostrar los valores recibidos para depuración
    echo "<pre>";
    echo "Nueva Contraseña: " . htmlspecialchars($nueva_contrasena) . "<br>";
    echo "Confirmar Contraseña: " . htmlspecialchars($confirmar_contrasena) . "<br>";
    echo "Persona Cedula: " . htmlspecialchars($persona_cedula) . "<br>";
    echo "</pre>";

    // Inicializar el mensaje de error
    $error_messages = [];

    // Validar la nueva contraseña
    if (strlen($nueva_contrasena) < 8) {
        $error_messages[] = "La nueva contraseña debe tener al menos 8 caracteres.";
    }

    // Validar que la contraseña contenga al menos una mayúscula
    if (!preg_match('/[A-Z]/', $nueva_contrasena)) {
        $error_messages[] = "La nueva contraseña debe contener al menos una letra mayúscula.";
    }

    // Validar que la contraseña contenga al menos un número
    if (!preg_match('/\d/', $nueva_contrasena)) {
        $error_messages[] = "La nueva contraseña debe contener al menos un número.";
    }

    // Validar que ambas contraseñas coincidan
    if ($nueva_contrasena !== $confirmar_contrasena) {
        $error_messages[] = "Las contraseñas no coinciden.";
    }

    // Si hay mensajes de error, redirigir con todos los mensajes
    if (!empty($error_messages)) {
        $_SESSION['error'] = implode("", $error_messages);
        header("Location: ../Vista/cambio.php");
        exit();
    }
    try {
        $sql = "UPDATE usuarios SET Contraseña = :contrasena WHERE Empleados_Persona_Cedula = :persona_cedula";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':contrasena', $nueva_contrasena);
        $stmt->bindParam(':persona_cedula', $persona_cedula);
        $stmt->execute();

        $_SESSION['success'] = "Contraseña cambiada exitosamente.";
        header("Location: ../Vista/Inicio.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al cambiar la contraseña: " . $e->getMessage();
        header("Location: ../Vista/cambio.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Datos del formulario no válidos.";
    header("Location: ../Vista/cambio.php");
    exit();
}
?>