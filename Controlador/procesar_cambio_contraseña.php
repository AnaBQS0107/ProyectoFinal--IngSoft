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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nueva_contrasena'])) {
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $persona_cedula = $_SESSION['user']['Persona_Cedula'];

    // Validar la nueva contraseña
    if (strlen($nueva_contrasena) < 6) {
        $_SESSION['error'] = "La nueva contraseña debe tener al menos 6 caracteres.";
        header("Location: ../Vista/cambiar_contrasena.php");
        exit();
    }

    // Hash de la nueva contraseña
    $hashedPassword = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    try {
        // Consulta SQL
        $sql = "UPDATE usuarios SET Contraseña = '$hashedPassword' WHERE Empleados_Persona_Cedula = '$persona_cedula'";
        
        // Depuración: Mostrar consulta SQL
        echo "Consulta SQL: " . $sql . "<br>";

        // Ejecutar la consulta
        $pdo->exec($sql);

        // Mensaje de éxito
        $_SESSION['success'] = "Contraseña cambiada exitosamente.";
        header("Location: ../Vista/Inicio.php");
        exit();
    } catch (PDOException $e) {
        // Mensaje de error
        $_SESSION['error'] = "Error al cambiar la contraseña: " . $e->getMessage();
        echo "Error al cambiar la contraseña: " . $e->getMessage() . "<br>";
        header("Location: ../Vista/cambiar_contrasena.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Datos del formulario no válidos.";
    header("Location: ../Vista/cambiar_contrasena.php");
    exit();
}
?>
