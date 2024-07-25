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

    // Validar la nueva contraseña
    if (strlen($nueva_contrasena) < 6) {
        $_SESSION['error'] = "La nueva contraseña debe tener al menos 6 caracteres.";
        header("Location: ../Vista/cambiar_contrasena.php");
        exit();
    }

    // Validar que ambas contraseñas coincidan
    if ($nueva_contrasena !== $confirmar_contrasena) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header("Location: ../Vista/cambiar_contrasena.php");
        exit();
    }

    // Hash de la nueva contraseña
    $hashedPassword = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    try {
        $sql = "UPDATE usuarios SET Contraseña = :contrasena WHERE Empleados_Persona_Cedula = :persona_cedula";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':contrasena', $hashedPassword);
        $stmt->bindParam(':persona_cedula', $persona_cedula);
        $stmt->execute();

        $_SESSION['success'] = "Contraseña cambiada exitosamente.";
        header("Location: ../Vista/Inicio.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al cambiar la contraseña: " . $e->getMessage();
        header("Location: ../Vista/cambiar_contrasena.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Datos del formulario no válidos.";
    header("Location: ../Vista/cambiar_contrasena.php");
    exit();
}
?>
