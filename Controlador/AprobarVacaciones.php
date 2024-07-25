<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $idVacaciones = $_POST['idVacaciones'] ?? null;
    $accion = $_POST['accion'] ?? null;

    // Para depuración: ver qué datos están llegando
    error_log("Datos recibidos: idVacaciones = " . print_r($idVacaciones, true) . ", accion = " . print_r($accion, true));

    // Verificar que todas las variables están definidas
    if ($idVacaciones === null || $accion === null) {
        $response = [
            'success' => false,
            'message' => 'Faltan datos requeridos.'
        ];
        echo json_encode($response);
        exit;
    }

    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "servicio_autobuses";

    // Conectar a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        $response = [
            'success' => false,
            'message' => 'Conexión fallida: ' . $conn->connect_error
        ];
        echo json_encode($response);
        exit;
    }

    if ($accion === 'aprobar') {
        // Aprobar la solicitud
        $sql = "UPDATE vacaciones SET Estado = 'aprobado' WHERE idVacaciones = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $response = [
                'success' => false,
                'message' => 'Error al preparar la consulta para aprobar: ' . $conn->error
            ];
            echo json_encode($response);
            exit;
        }
        $stmt->bind_param("i", $idVacaciones);
        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'message' => 'La solicitud de vacaciones ha sido aprobada.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Error al aprobar la solicitud: ' . $stmt->error
            ];
        }
        $stmt->close();
    } elseif ($accion === 'denegar') {
        // Denegar la solicitud
        $sql = "SELECT Fecha_Inicio, Fecha_Fin, Empleados_Persona_Cedula FROM vacaciones WHERE idVacaciones = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $response = [
                'success' => false,
                'message' => 'Error al preparar la consulta para obtener datos de vacaciones: ' . $conn->error
            ];
            echo json_encode($response);
            exit;
        }
        $stmt->bind_param("i", $idVacaciones);
        $stmt->execute();
        $stmt->bind_result($fechaInicio, $fechaFin, $cedula);
        $stmt->fetch();
        $stmt->close();

        if ($fechaInicio === null) {
            $response = [
                'success' => false,
                'message' => 'Solicitud de vacaciones no encontrada.'
            ];
            echo json_encode($response);
            exit;
        }

        $diasVacaciones = (new DateTime($fechaFin))->diff(new DateTime($fechaInicio))->days + 1;

        // Obtener los días de vacaciones disponibles del empleado
        $sql = "SELECT VacacionesDisponibles FROM empleados WHERE Persona_Cedula = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $response = [
                'success' => false,
                'message' => 'Error al preparar la consulta para obtener días disponibles: ' . $conn->error
            ];
            echo json_encode($response);
            exit;
        }
        $stmt->bind_param("i", $cedula);
        $stmt->execute();
        $stmt->bind_result($vacacionesDisponibles);
        $stmt->fetch();
        $stmt->close();

        if ($vacacionesDisponibles === null) {
            $response = [
                'success' => false,
                'message' => 'Empleado no encontrado.'
            ];
            echo json_encode($response);
            exit;
        }

        // Actualizar días de vacaciones disponibles
        $diasRestantes = $vacacionesDisponibles + $diasVacaciones;
        $sql = "UPDATE empleados SET VacacionesDisponibles = ? WHERE Persona_Cedula = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $response = [
                'success' => false,
                'message' => 'Error al preparar la consulta para actualizar días disponibles: ' . $conn->error
            ];
            echo json_encode($response);
            exit;
        }
        $stmt->bind_param("ii", $diasRestantes, $cedula);
        if ($stmt->execute()) {
            // Actualizar el estado de la solicitud a 'denegado'
            $sql = "UPDATE vacaciones SET Estado = 'denegado' WHERE idVacaciones = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                $response = [
                    'success' => false,
                    'message' => 'Error al preparar la consulta para denegar la solicitud: ' . $conn->error
                ];
                echo json_encode($response);
                exit;
            }
            $stmt->bind_param("i", $idVacaciones);
            if ($stmt->execute()) {
                $response = [
                    'success' => true,
                    'message' => 'La solicitud de vacaciones ha sido denegada y los días han sido devueltos.'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error al denegar la solicitud: ' . $stmt->error
                ];
            }
            $stmt->close();
        } else {
            $response = [
                'success' => false,
                'message' => 'Error al actualizar los días de vacaciones disponibles: ' . $stmt->error
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'Acción inválida.'
        ];
    }

    $conn->close();
    echo json_encode($response);
    exit;
} else {
    header('Location: ../Vista/AprobarVacaciones.php');
    exit;
}
?>
